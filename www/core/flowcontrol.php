<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */ 
 
	/* In questo file ci sono gli helpers the si occupano
	 * di gestire il flusso d'esecuzione */

	
	// Nice die
	function ndie($html = ""){
		global $home_dir;
		echo $html;
		include_once(ROOT_PATH . "footer.php");
		die();
	}

?>