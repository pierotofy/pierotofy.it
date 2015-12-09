<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */ 
 
  /** Si occupa di far visualizzare una tabella con i messaggi presenti in una cartella
    method: POST
    params:
      folder : cartella di cui si vogliono vedere i messaggi
      order : tipo di ordinamento
      p : pagina da visualizzare
  */
  
require_once("__inc__.php");

$response = new RestfulResponse("json");

//Salvo i parametri
$folder = isset($_POST['folder']) ? $_POST['folder'] : '';
$order = isset($_POST['order']) ? $_POST['order'] : '';
$page = isset($_POST['p']) ? (int)$_POST['p'] : 1;

//Controllo di folder
$to_field_name = '';
switch($folder){
  case 'inbox':
    $response->set('to_field_name', 'Da');
    $to_field = 'from_id';
    $folder = MessageService::INBOX;
    break;
  case 'sent':
    $response->set('to_field_name', 'A');
    $to_field = 'to_id';
    $folder = MessageService::SENT;
    break;
  case 'trash':
    $response->set('to_field_name', 'Da');
    $to_field = 'from_id';
    $folder = MessageService::DELETED;
    break;
  default:
    $response->setError("Errore: parametro folder non valido");
    $response->send();
    exit();
}

//Controllo di order
$order_by = $order_type = '';
switch($order){
  case 'date_asc':
    $order_by = MessageService::DATE;
    $order_type = "ASC";
    break;
  case 'from_asc':
    $order_by = MessageService::NAME;
    $order_type = "ASC";
    break;
  case 'from_desc':
    $order_by = MessageService::NAME;
    $order_type = "DESC";
    break;
  case 'subject_asc':
    $order_by = MessageService::SUBJECT;
    $order_type = "ASC";
    break;
  case 'subject_desc':
    $order_by = MessageService::SUBJECT;
    $order_type = "DESC";
    break;
  default:
    $order_by = MessageService::DATE;
    $order_type = "DESC";
    break;
}


//Creo il MessageService e prendo i messaggi
$ms = new MessageService($currentUser['id']);
$messages = $ms->getFolder($folder, $page, $order_type, $order_by);

//Array contenente i dati del json
$array = array();

//Creo i dati della paginazione
$pag = new Pagination($ms->getFolderCountMessages($folder), MessageService::MESSAGE_FOR_PAGE, $page);
$array['pagination'] = $pag->getNavigator("default.html", "javascript:Messages.goToPage(#PAGE#);");
$array['messages'] = array();

foreach($messages as $m){
  $date = DateUtils::GetNice($m['date_tm']);
  $q = DB::FindOne("SELECT user FROM users WHERE id = ".$m[$to_field]." LIMIT 1");
  $to_from = (($m->isMultiple() && $folder == MessageService::SENT) ? 'Tutti i membri' : $q['user']);
  $delete_restore='';
  if($folder == MessageService::INBOX) $delete_restore = 'C';
  else if($folder == MessageService::DELETED) $delete_restore = 'R';
  $array['messages'][] = 
      array("date" => $date, 
            "to_from" => $to_from, 
            "delete_restore" => $delete_restore, 
            "id" => $m['id'],
            "subject" => $m->getRaw('subject'), // Gia' purificato durante l'inserimento
            "viewed" => ($m['viewed'] == 1),
            "important" => ($m['important'] == 1));
}

$response->set('value',$array);
$response->setSuccess(true);
$response->send();
?>