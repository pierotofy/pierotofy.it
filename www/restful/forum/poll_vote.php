<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */ 

  /** Si occupa di aggiungere un voto ad un sondaggio
    method: POST
    params: 
      topic_id: id del topic (base) su cui votare
      vote: id della scelta del sondaggio da votare
    returns:
      success: false => errore, true => OK
      results_html: html contenente i risultati del sondaggio
  */

  require_once("__inc__.php");
  
  $response = new RestfulResponse("json");

  if ($currentUser->isLogged()){
    // Valida i campi di input
    validate_num($_POST['topic_id']);
    validate_num($_POST['vote']);

    $topic = new Topic($_POST['topic_id']);

    if ($topic->isPoll() && $topic->isViewableBy($currentUser)){
      $poll_data = $topic->getPollData();


      if (!$poll_data['user_has_voted']){
        // Voto valido?
        $valid_vote = false;
        foreach($poll_data['choices'] as $choice){
          if ($choice['id'] == $_POST['vote']){
             $valid_vote = true;
             break;
          }
        }

        if ($valid_vote){
          // OK. Inseriamo il voto
          exequery("INSERT INTO forum_poll (topic_id, user_id, vote)
            VALUES ($topic[id], $currentUser[id], $_POST[vote])");

          // Ricarica il topic
          $topic = new Topic($_POST['topic_id']);

          $response->set("results_html", $topic->renderPollResults());
          $response->setSuccess(true);
        }else{
          $response->setError("Voto non valido.");
        }
      }else{
        $response->setError("Hai gia' votato.");        
      }
    }else{
      $response->setError("Non hai i permessi per votare questo sondaggio.");
    }
  }else{
    $response->setError("Non sei loggato.");
  }

  $response->send();
?>
