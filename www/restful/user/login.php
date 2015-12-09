<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */ 

  /** Si occupa di autenticare l'utente 
    method: POST
    params: 
      hash: username e password oscurati (see /js/site.js Login.encrypt) 
      usecookie: false => non impostare cookie, true => imposta cookie
    returns:
      success: false => errore, true => OK
      banned_message (optional): un messaggio di ban se l'utente e' bannato

  */

  require_once("__inc__.php");
  
  $response = new RestfulResponse("json");

  $hash = $_POST['hash'];
  if (isset($hash)){
    $currentUser = UserFactory::CreateFromLoginHash($hash);
    if ($currentUser->isLogged()){
      $response->setSuccess(true);

      // Aggiorna ip, data ultimo login
      exequery(sprintf("UPDATE users SET previous_login_timestamp = '%d', 
                                 last_login_timestamp = '%d', 
                                 last_login_ip = '%s' 
                        WHERE id = %d", 
                        $currentUser['last_login_timestamp'], time(), get_ip(), $currentUser['id']));
      
      // Logga
      Log::Info(sprintf("%s effettua il login", $currentUser['username']));

      $_SESSION['login_hash'] = $currentUser['md5'];
      if ($_POST['usecookie']) setcookie('login_hash', $currentUser['md5'], time() + (60*60*24*7), '/');
    }else if ($currentUser->isBanned()){
      $response->set("banned_message", utf8_encode("Il tuo account è stato disattivato fino al " . date("d/m/y - H:i",$currentUser->banned) . " per il seguente motivo: $currentUser->banned_reason.\n\nUna volta scaduto il ban il tuo account sarà automaticamente riattivato."));
      $response->setError("Bannato!");

    }else{
      setcookie('login_hash','',0,'/');
      unset($_SESSION['login_hash']);
      $response->setError("Username o password invalidi.");
    }
  }else{
    $response->setError("Hash mancante");
  }

  $response->send();
?>
