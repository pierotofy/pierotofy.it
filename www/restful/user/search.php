<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */ 
 
  /** Permette di cercare il nome di un utente da una parte del nome
    method: POST
    params:
      name : parte del nome da cercare
      num_records : numero massimo di nomi che deve ritornare (limite di 50 per evitare di dare troppe informazioni)
    returns:
      results : array con nomi degli utenti
  */
require_once("__inc__.php");

$response = new RestfulResponse("json");

if (isset($_POST['term'])){
	$term = Charset::Utf8ToDB($_POST['term']);
	$num_records = @$_POST['num_records'];

	// Validazione
	if(!isset($num_records)) $num_records = 20;
	if ($num_records > 50) $num_records = 50;

	$results = UserSearch::Find($term, $num_records);

	$response->set('results', $results);
	$response->setSuccess(true);
}else{
	$response->setError("Missing term param");
}

$response->send();
?>
