<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */ 

/** Classe per l'invio e la visualizzazione dei messaggi
 * Il costruttore, richiede l'id dell'utente di cui si vogliono vedere i messaggi o da cui si vogliono inviare.
 * Permette l'invio di messaggi singoli o multipli (per gli admin) usando rispettivamente le funzioni sedToOne() e sendToMore()
 * Invece la funzione getFolder ritorna un array di messaggi (istanze di Message) che corrisponde a: 
 * la posta in arrivo (MessageService::INBOX) o quella inviata (MessageService::SENT) o il cestino(MessageService::DELETED).
 * Si possono spostare i messaggi nel e dal cestino.
 */

class MessageService{
  const INBOX = 1, DELETED = 2, SENT = 3; //Costanti per $folder in getFolder
  const NAME = 1, DATE = 2, SUBJECT = 3; //Costanti per $sorting in getFolder
  const DELETE = 1, RESTORE = 2; //Costanti per la gestione del cestino (trashOperation)
  const MESSAGE_FOR_PAGE = 20;
  private $user_id;
  
  /// Costruttore, richiede l'id dell'utente
  public function __construct($user_id){
    validate_num($user_id);
    $this->user_id = $user_id;
  }
  
  // @param folder $folder può essere: MessageService::INBOX, MessageService::DELETED o MessageService::SENT 
  // @param sorting $sorting può essere: ASC o DESC
  // @param sort_by $sort_by piò essere: MessageService::DATE, MessageService::SUBJECT o MessageService::NAME
  // @return array contenete i messaggi
  public function getFolder($folder, $page=1, $sorting="DESC", $sort_by=self::DATE){
    
  	//Controllo che page sia numerico
  	validate_num($page);
  	
  	//Mi assicuro che sorting sia corretto
    $sorting = strtoupper($sorting);
    if($sorting != "ASC") $sorting = "DESC";

  	//Aggiorno $sort_by per la query
    if($sort_by == self::NAME) $sort_by = (($folder == self::SENT) ? "to_id" : "from_id");
    else if($sort_by == self::SUBJECT) $sort_by = "subject";
    else $sort_by = "date_tm";

  	//Creo i limiti
    $limit = DB::GetLimit($page, self::MESSAGE_FOR_PAGE);

  	//Creo la query con cui prelevo i messaggi dal database
    $query = Message::SELECT_SQL . " WHERE ".self::whereForFolderQuery($folder)." ORDER BY $sort_by $sorting LIMIT $limit";

  	//Eseguo la query
    $qr = exequery($query);

  	//Metto i messaggi nell'array
    $array = NULL;
    while($m = mysqli_fetch_array($qr, MYSQLI_ASSOC)){
      $array[] = new Message($m);
    }

  	//restituisco l'array
    return $array;
  }
  
  // @return numero dei messaggi presenti in una cartella
  public function getFolderCountMessages($folder){
    return DB::Count("messages", self::whereForFolderQuery($folder));
  }
  
  // @param with_user_id id dell'utente con cui è stata fatta la conversazione
  // @return array contenete i messaggi della conversazione
  public function getConversation($with_user_id, $from_date=-1, $to_date=-1){

    //Controllo che i parametri siano numerici
    validate_num($with_user_id);
    validate_num($from_date);
    validate_num($to_date);
	
    //Do un valore di default se $from_date e/o to_date non sono stati passati
    if($form_date == -1) $from_date = mktime(0, 0, 0, date("m")-1, date("d"), date("Y")); //Un mese prima
  	if($to_Date == -1) $to_date = time();
  	
  	//Creo la query con cui prelevo i messaggi dal database
  	$query = Message::SELECT_SQL . " WHERE $from_date<=date_tm AND date_tm<=$to_date
  	                                     AND ((from_id=$with_user_id AND to_id=$user_id)
                                         OR (from_id=$user_id AND to_id=$with_user_id))";
  	
  	//Eseguo la query
  	$rq = exequery($query);
  	
  	//Metto i messaggi nell'array
  	$array = NULL;
  	while($m = mysqli_fetch_array($rq, MYSQLI_ASSOC)){
  	  $array[] = new Message($m);
    }
  	
  	//restituisco l'array
  	return $array;
  }
  
  // @return messaggio che ha id $id
  public function getMessage($id){
    //Controllo che l'id sia numerico
    validate_num($id);
    
    //Prendo il primo elemento della query e creo un Message
    return new Message("id=$id AND (from_id=$this->user_id OR to_id=$this->user_id)");
  }
  
  /// La funzione invia un messaggio ad un utente
  public function sendToOne($subject, $text, $receiver, $important=0, $multiple = 0){
  	//Controllo che $receiver e $important siano numerici
  	validate_num($receiver);
  	validate_num($important);
  	validate_num($multiple);
      
  	//Controllo sicurezza delle stringhe
  	$subject = db_escape(purify($subject));
  	$text = db_escape(purify($text));
  	
  	//Eseguo la query
  	$query_mess = "INSERT INTO messages (from_id, to_id, subject, message, date_tm, important, multiple) 
  	                VALUES($this->user_id, $receiver, '$subject', '$text', ".time().", $important, $multiple)";
  	exequery($query_mess);
  }
  
  /// La funzione invia un messaggio a tutti i membri
  public function sendToAllMembers($subject, $text, $important=0){
    $q=exequery("SELECT id FROM users WHERE member_id != 0");
    
    //Invio ad ogni utente il messaggio
	while($u = mysqli_fetch_array($q, MYSQLI_ASSOC)){
      self::sendToOne($subject, $text, $u['id'], $important, 1);
    }
  }
    
  /// Sposta un messaggio nel cestino
  // @param id rappresenta gli id dei messaggi(o l'id del messaggio) da cancellare e può essere o un int o un array di int
  public function moveToTrash($id){
    if(!is_array($id)) $id = array($id);
    self::trashOperation($id, self::DELETE);
  }
  
  /// Sposta un messaggio dal cestino alla posta in arrivo
  // @param id rappresenta gli id dei messaggi(o l'id del messaggio) da ripristinare e può essere o un int o un array di int
  public function restoreFromTrash($id){
    if(!is_array($id)) $id = array($id);
    self::trashOperation($id, self::RESTORE);
  }
  
  /// Segna che il messaggio è stato visualizzato (quindi nel database setta il campo viewed ad 1)
  // @param id id del messaggio che è stato visualizzato
  public function viewed($id){
    //Mi assicuro che l'id sia numerico
    validate_num($id);

    //Aggiorno il database
    exequery("UPDATE messages SET viewed=1 WHERE id=$id AND (from_id=$this->user_id OR to_id=$this->user_id) LIMIT 1");
  }
  
  /// @return numero di messaggi non letti
  public function getUnreadMessagesCount(){
    return DB::Count("messages", " (to_id=$this->user_id AND viewed=0 AND deleted=0)");
  }
  
  /// Funzione privata che permette di gestire il cestino
  // @param id_array array contente gli id dei messaggi su cui effetturare le operazioni
  // @param option $option può essere: DELETE o RESTORE
  private function trashOperation($id_array, $option){
    //Controllo che gli id dei messaggi siano numerici
    foreach($id_array as $id) validate_num($id);
	
    //Controllo che i valori di $option siano corretti
    if(($option != self::DELETE) && ($option != self::RESTORE)){
      echo "Input invalido"; die();
    }
    
    //Scansiono l'array e aggiorno il campo di ogni messaggio
    foreach($id_array as $message_id){
      exequery("UPDATE messages SET deleted=".(($option == self::DELETE) ? 1 : 0)." WHERE id=$message_id AND to_id=$this->user_id");
    }
  }

  // @return stringa contenente il where per prendere i messagi dalla cartella $folder
  private function whereForFolderQuery($folder){
    if($folder==self::INBOX) return "to_id = $this->user_id AND deleted = 0";
  	if($folder==self::DELETED) return "to_id = $this->user_id AND deleted = 1";
  	if($folder==self::SENT){
      return "from_id = $this->user_id 
              AND (
                 multiple = 0 OR 
                 (multiple = 1 AND to_id = $this->user_id)
              )";
    }
	  die("folder non corretta");
  }
}
?>
