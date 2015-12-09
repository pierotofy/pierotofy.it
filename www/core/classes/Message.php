<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */ 

/** Classe che serve da contenitore per i dati di un messaggio, e estesa da Entity,
 * quindi per accedere ai dati bisogna fare $message['nome_dato']
 */
 
class Message extends Entity{
  
  const SELECT_SQL = "SELECT * FROM messages";

  // @param where_sql clausola where per identificare un messaggio unico
  public function __construct($where_sql){
    parent::Entity($where_sql);
  }

  public function getSelectSql(){
    return Message::SELECT_SQL;
  }
  
  // @return true or false se il messaggio è multiplo o no
  public function isMultiple(){
    return ($this['multiple'] == 1) ? true : false;
  }
  
  // @return true or false se il messaggio è importante o no
  public function isImportant(){
    return ($this['important'] == 1) ? true : false;
  }
}
?>