<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */ 

  /** Ricava il contenuto raw di un post (o topic) del forum
      La richiesta dev'essere effettuata da un utente che ha i permessi per editare il post/topic
    method: GET e POST combinato
    params: 
      id (GET): id del post/topic
      value (POST): nuovo contenuto
    returns:
      success => true|false
      value => HTML contenente il nuovo post
  */

  require_once("__inc__.php");

  $response = new RestfulResponse("json");

  validate_num($_GET['id']);
  if ($currentUser->isLogged()){
    $q = exequery("SELECT argument, user_id FROM forum_posts WHERE id = $_GET[id]");
    $values = mysqli_fetch_array($q);

    // Puo' editare?
    if ($currentUser->isModOfForum($values['argument']) || $currentUser["id"] == $values['user_id']){
      $message = db_escape(Charset::Utf8ToDB($_POST['value']));
      exequery("UPDATE forum_posts SET message = '$message', edit_date = " . time() . ", edit_by = $currentUser[id]
              WHERE id = $_GET[id]");

      $post = new ForumPost($_GET['id']);
      $response->set("value", $post->getParsedMessage());
      $response->setSuccess(true);
    }else{
      $response->setError("Non hai i permessi per modificare questo post");
    }
  }else{
    $response->setError("Non loggato");
  }

  echo $response->send();
?>
