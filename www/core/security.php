<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */ 
 
	/* In questo file ci sono gli helpers the si occupano
	 * di sicurezza */

	// Pulisce un input per limitare la possiblita' di attacchi XSS
	function purify($input){
		return htmlentities($input, ENT_COMPAT, 'ISO-8859-1');
	}

	// Esegue un escape su un'input per inserimento nel database
	function db_escape($input){
		global $link;
		return mysqli_real_escape_string($link, $input);
	}

	// Assicura che l'input e' un numero e termina lo script se non lo e'
	function validate_num($n){
	   if (!is_numeric($n)){ echo "Input invalido"; die(); }
	}

?>
