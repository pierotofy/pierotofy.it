<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */ 
 
  /** Si occupa di far visualizzare un messaggio 
    method: POST
    params:
      id : id del messaggio da visualizzare
    returns:
      subject : oggetto del messaggio
      from_or_to : stringa 'A' o 'Da'
      date : data dell'invio del messaggio (formattata in maniera leggibile)
      discursive_date: data dell'invio del messaggio (gg/mm/yy HH:mm)
      important : true o false se il messaggio è importante o no
      message_html : testo del messaggio (formattato in HTML)
      message_plain : testo del messaggio (non formattato)
      reply : true o false se bisonga mostrare il bottone rispondi o no
      from_to_user : nome dell'utente che ha inviato o ricevuto il messaggio
  */
require_once("__inc__.php");

$response = new RestfulResponse("json");
$r = '';

$id = $_POST['id'];
validate_num($id);
$ms = new MessageService($currentUser['id']);
$m = $ms->getMessage($id);
if($m['to_id'] == $currentUser['id']) $ms->viewed($id);

$from_to = 'A';
$user = 'to_id';
$write = "";
if($m['to_id'] == $currentUser['id']){
  $from_to = 'Da';  
  $user = 'from_id';
}
$user = DB::FindOne("SELECT user FROM users WHERE id=".$m[$user]." LIMIT 1");

$array = array("subject" => $m->getRaw('subject'), // Gia' purificato
                   "from_or_to" => $from_to,
                   "date" => DateUtils::GetNice($m['date_tm']),
                   "discursive_date" => DateUtils::GetDiscursive($m['date_tm']),
                   "important" => $m->isImportant(),
                   "multiple" => $m->isMultiple(),
                   "message_html" => Text::MessageToHtml($m->getRaw('message')), // Gia' purificato
                   "message_plain" => $m->getRaw('message'), // Gia' purificato
                   "reply" => ($m['to_id'] == $currentUser['id']),
                   "from_to_user" => $user['user']);

$response->set('value', $array);
$response->setSuccess(true);
$response->send();
?>
