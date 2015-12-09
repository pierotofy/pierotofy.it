<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */ 

/* Questa classe rappresenta l'utente corrente ed e' da usare
 per rappresentare l'utente con il quale una persona si logga sul sito.
 Per rappresentare utenti in parti del codice, utilizza la classe SpecificUser */

 class CurrentUser extends User{
	
	// Crea un utente a partire dal suo hash md5
 	function CurrentUser($md5){
 		$md5 = db_escape($md5);

 		parent::User("md5 = '$md5' AND verified = 1");
 	}

 	/* Se un utente non esiste o e' bannato, non e' loggato */
 	function isLogged(){
 		return $this->isValid() && !$this->isBanned();
 	}

 	function isGuest(){
 		return !$this->isLogged();
 	}

	/* Notare la differenza tra isAdmin e isMember per CurrentUser. Qui non solo controlliamo
	che i campi siano settati correttamente, ma controlliamo anche che l'utente sia loggato! */ 
	function isAdmin(){
		return parent::isAdmin() && $this->isLogged();
	}
	function isMember(){
		return parent::isMember() && $this->isLogged();
	}
}

?>
