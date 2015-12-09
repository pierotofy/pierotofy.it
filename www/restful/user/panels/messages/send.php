<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */ 
 
  /** Si occupa di spostare un messaggio dal cestino alla posta in arrivo
    method: POST
    params:
      to : nome dell'utente a cui inviare i messaggi
      subject : oggetto del messaggio
      message : testo del messaggio
      important : flag se il messaggio è importante o no
      multiple : flag se il messaggio è multiplo o no
    returns:
      success: false => errore, true => OK
  */
require_once("__inc__.php");

$response = new RestfulResponse();

//Salvo i parametri
$to = Charset::Utf8ToDB($_POST['to']);
$subject = Charset::Utf8ToDB($_POST['subject']);
$message = Charset::Utf8ToDB($_POST['message']);
$important = isset($_POST['important']) ? $_POST['important'] : false; //boolean
$multiple = isset($_POST['multiple']) ? $_POST['multiple'] : false; //boolean

$av = new AutoValidator("message-write", $_POST);
if ($av->validate()){
  //Controllo solo multiple, to e important (gli altri due vengono controllati in MessageService)
  $important = (($currentUser->isAdmin() && $important) ? 1 : 0 );
  $multiple = ($multiple == "true");
  
  if($multiple != 1){
    $to = db_escape($to);
    $to = DB::FindOne("SELECT id FROM users WHERE user='$to' LIMIT 1");
    $to = (int)$to['id'];
  }
  
  $ms = new MessageService($currentUser['id']);
  
  if($multiple){
    $ms->sendToAllMembers($subject, $message, $important);
    $response->setSuccess(true);
  }else{
    //Prendo l'id dell'utente a cui spedire il messaggio
    if(DB::Count("users", "id='$to' LIMIT 1") == 0){
      $response->setError("Destinatario inesistente");
    }else{
      $ms->sendToOne($subject, $message, $to, $important);
      $response->setSuccess(true);
    }
  }
}else{
  $response->setError($av->getLastError());
}

$response->send();
?>