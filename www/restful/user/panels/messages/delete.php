<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */ 
 
  /** Si occupa di spostare un messaggio nel cestino
    method: POST
    params:
      id_list : id (oppure array di IDs) del messaggio/i da cancellare
    returns:
      success: false => errore, true => OK
  */
require_once("__inc__.php");

$response = new RestfulResponse('json');

$ms = new MessageService($currentUser['id']);

// $_POST[id_list] e' verificato in moveToTrash
$ms->moveToTrash($_POST['id_list']);

$response->setSuccess(true);
$response->send();

?>