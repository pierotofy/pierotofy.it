<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */ 

  /** Si occupa di aggiungere una risposta ad un topic
    method: POST
    params: 
      topic_id: id del topic (base) su cui aggiungere una risposta
      message: messaggio
    returns:
      success: false => errore, true => OK
      post_html: html contenente il post appena inserito
  */

  require_once("__inc__.php");
  
  $response = new RestfulResponse("json");

  $av = new AutoValidator("frm-forum-reply", $_POST);
  if ($av->validate()){
    if ($currentUser->isLogged()){
      // Valida i campi di input
      validate_num($_POST['topic_id']);
      $topic = new Topic($_POST['topic_id']);
      $message = db_escape(Charset::Utf8ToDB($_POST['message']));

      if (!Forum::IsUserFlooding($currentUser)){
        if (!$topic['locked']){

          // Trova il forum_id
          $values = DB::FindOne("SELECT argument FROM forum_posts WHERE id = $_POST[topic_id]");
          $forum_id = $values['argument'];

          exequery(sprintf("INSERT INTO forum_posts (user_id, root_topic, argument, message, type, post_date, last_post_date, ip) 
                          VALUES(%d, %d, %d, '%s', %d, %d, %d, '%s')", 
                          $currentUser['id'], $_POST['topic_id'], $forum_id, $message, Forum::TYPE_POST, time(), time(), get_ip()));
          $id = DB::LastId();
          $post = new ForumPost($id);

          Forum::UpdateTopicAfterReply($_POST['topic_id']);
          Forum::IncPostCountForUser($currentUser);
          Forum::AddReplyNotifications($post['id']);
          
          $response->set("post_html", $post->render("forum/post.html"));
          $response->setSuccess(true);
        }else{
          $response->setError("Il topic e' stato chiuso dal moderatore.");
        }
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
