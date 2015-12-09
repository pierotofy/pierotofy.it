<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */ 

class GuestUser extends User{
	function GuestUser(){
		// ID = null
	}
	
	/* Un utente anonimo non e' mai loggato */
	function isLogged(){
		return false;
	}
	
	function isGuest(){
		return true;
	}
}

?>
