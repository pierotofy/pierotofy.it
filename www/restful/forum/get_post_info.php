<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */ 

  /** Ricava il contenuto raw di un post (o topic) del forum
      La richiesta dev'essere effettuata da un utente che ha i permessi per editare il post/topic
    method: GET
    params: 
      id: id del post/topic
    returns:
      informazioni del post/topic, inclusi:
      - messaggio, username del postatore
  */

  require_once("__inc__.php");

  $response = new RestfulResponse("json");

  validate_num($_GET['id']);
  if ($currentUser->isLogged()){
    $post = new ForumPost($_GET['id']);
    
    if ($post->isViewableBy($currentUser)){
      $response->set('message', $post['message']);
      $response->set('username', $post['user']);
    }else{
      $response->setError("Non hai i permessi per leggere queste informazioni.");
    }
  }else{
    $response->setError("Non loggato");
  }

  echo $response->send();
?>
