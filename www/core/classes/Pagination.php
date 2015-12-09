<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */ 

/** Classe per gestire la paginazione (back-end)
 * Permette di ricordarsi a quale pagina si è e fornisce i limiti da usare in una query
 */

class Pagination{
  private $current_page, $pages_count, $records_for_each_page;
  
  /// Costruttore
  // @param records_count è il numero dei records da "paginare".
  // @param records_for_each_page è opzionale e di default è 10
  public function __construct($records_count, $records_for_each_page = 10, $current_page = 1){
    //Controllo che i parametri siano numerici
    validate_num($records_count);
    validate_num($records_for_each_page);
	
    //Controllo che i parametri siano positivi
    if(($records_count < 0) || ($records_for_each_page < 0)){
      die("Errore, parametri negativi nel costruttore della classe Pagination");
    }
	
    //Calcolo il numero delle pagine
    $this->pages_count = ceil($records_count / $records_for_each_page);
    
    //Salvo i valori
    $this->records_count = $records_count;
    $this->records_for_each_page = $records_for_each_page;
    $this->current_page = (($current_page >= 1) && ($current_page <= $this->pages_count)) ? $current_page : 1;
  }
 
  // @return numero della pagine
  public function getPagesCount(){
    return $this->pages_count;
  }
  
  // @return il numero della pagina corrente
  public function getCurrentPage(){
    return $this->current_page;
  }
  
  // @param $view nome della view della paginazione 
  //              (deve essere nella cartella core/views/pagination) (di default è "default.html")
  // @param $page_link link che ogni bottone della pagina deve seguire. 
  //              La direttiva #PAGE# viene sostituita con il numero di pagina di ogni bottone
  // @return l'html della view con i dati insetiti
  public function getNavigator($view = "default.html", $page_link = "javascript:goToPage(#PAGE#);"){
    $num_pages = self::getPagesCount();

    // Non renderizzare il paginatore se c'e' una sola pagina
    if ($num_pages > 1){
      $builder = new ViewBuilder("pagination/".$view);
      $array = array( 'current_page' => self::getCurrentPage(),
                      'pages' => array());
      for($i = 1; $i <= $num_pages; $i++){
        $array['pages'][] = array( 'page' => $i, 'link' => str_replace("#PAGE#", $i, $page_link) );
      }
      $builder->setValues($array);
      return $builder->render();
    }else{
      return "";
    }
  }
}

?>