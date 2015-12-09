<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */ 
 
  /** Si occupa di spostare un messaggio dal cestino alla posta in arrivo
    method: GET
    params:
      id : id del messaggio da spostare
      dataType : formato della risposta (vedere Restful::PrintResponse)
    returns:
      success: false => errore, true => OK
  */
require_once("__inc__.php");

$response = new RestfulResponse((isset($_POST['dataType']) ? $_POST['dataType'] : 'html'));

validate_num($_POST['id']);
$ms = new MessageService($currentUser['id']);
$ms->restoreFromTrash($_POST['id']);

$response->setSuccess(true);
$response->send();
?>