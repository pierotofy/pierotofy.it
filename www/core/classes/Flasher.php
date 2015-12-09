<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */ 

  /** Questa classe si occupa di visualizzare dei messaggi "flash"
  nel sito. I messaggi flash sono messaggi che appaiono solo una volta al prossimo ricaricamento di una pagina,
  dopodichè spariscono. Sono utili per visualizzare notifiche. */
  
  class Flasher{
    static function Show($message){
      if (!isset($_SESSION['flash_messages'])) $_SESSION['flash_messages'] = array();

      $_SESSION['flash_messages'][] = $message;
    }

    static function HasFlashes(){
      return isset($_SESSION['flash_messages']) && count($_SESSION['flash_messages']) > 0;
    }

    /* Ritorna la lista di flashes, eliminandola */
    static function PopFlashes(){
      $messages = $_SESSION['flash_messages'];
      unset($_SESSION['flash_messages']);
      return $messages;
    }  
  }

?>
