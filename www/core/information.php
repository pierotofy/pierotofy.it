<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */ 
 
	/* In questo file ci sono gli helpers the si occupano
	 * di prendere informazioni dall'utente */

	// Pulisce un input per limitare la possiblita' di attacchi XSS
	function get_ip(){
		 //IP (script di Neo_z86)
		if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
		}elseif(isset($_SERVER['HTTP_VIA'])) {
			$ip=$_SERVER['HTTP_VIA'];
		}elseif($_SERVER['REMOTE_ADDR']) {
			$ip=$_SERVER['REMOTE_ADDR'];
		}else{
			$ip="Unknow";
		}

		return $ip;
	}

?>