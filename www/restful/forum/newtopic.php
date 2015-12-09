<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */ 

  /** Si occupa di inserire un nuovo topic nel forum
    method: POST
    params: 
      forum_id: id del forum in cui inserire il topic
      subject: oggetto del topic
      message: messaggio
      poll (facoltativo): lista di opzioni da inserire in un sondaggio (implica che il post e' un sondaggio)
    returns:
      success: false => errore, true => OK
      topic_url: url (relativo) del topic appena inserito
  */

  require_once("__inc__.php");
  
  $response = new RestfulResponse("json");

  $av = new AutoValidator("frm-forum-post", $_POST);
  if ($av->validate()){
    if ($currentUser->isLogged()){
      // Valida i campi di input
      validate_num($_POST['forum_id']);
      $subject = db_escape(Charset::Utf8ToDB($_POST['subject']));
      $message = db_escape(Charset::Utf8ToDB($_POST['message']));
      $is_poll = isset($_POST['poll']);

      // Le domande del sondaggio vengono memorizzate nel campo
      // "poll" come array serializzato. Se "poll" e' null, allora
      // vuol dire che il topic non e' un sondaggio
      if ($is_poll){
        $poll_questions = explode("\n", trim(purify(Charset::Utf8ToDB($_POST['poll']))));
        if (count($poll_questions) >= 2){
          $poll_data = db_escape(serialize($poll_questions));
        }else{
          // Numero di domande nel sondaggio non valido (< 2)
          $poll_data = null; 
        }
      }

      if (!Forum::IsUserFlooding($currentUser)){
        exequery(sprintf("INSERT INTO forum_posts (user_id, argument, subject, message, type, post_date, last_post_date, ip, poll, replies) 
                        VALUES(%d, %d, '%s', '%s', %d, %d, %d, '%s', \"%s\", 0)", 
                        $currentUser['id'], $_POST['forum_id'], $subject, $message, Forum::TYPE_TOPIC, time(), time(), get_ip(), $poll_data));
        $id = DB::LastId();
        $topic = new Topic($id);

        Forum::IncPostCountForUser($currentUser);
        
        $response->set("topic_url", $topic->getUrl());
        $response->setSuccess(true);
      }else{
        $response->setError("Attendi almeno " . Forum::FLOOD_SECONDS_LIMIT . " secondi tra un post e l'altro.");
      }
    }else{
      $response->setError("Non sei loggato.");
    }
  }else{
    $response->setError($av->getLastError());
  }

  $response->send();
?>
