<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */ 

/** Classe che serve per l'autocomplete con l'inserimento del nome di un utente
 */
 
class UserSearch{

  // @param name parte del nome da cercare
  // @param num_records numero massimo di nomi da cercare (di default è 20)
  // @return array contente l'username degli gli utenti il cui none inizia con $name
  public static function Find($name, $num_records = 20){
    //Controllo dei parametri
    validate_num($num_records);
    db_escape(trim($name));

    // Se non c'e' niente da cercare
    if ($name == "") return array();
    
    $q=exequery("SELECT user FROM users WHERE user LIKE'$name%' LIMIT $num_records");
    $array = array();
    while($u = mysqli_fetch_array($q, MYSQLI_ASSOC)){
	     $array[] = $u['user'];
    }
    
    return $array;
  }
}
?>