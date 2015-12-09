<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */ 

	/** Helpers per creare JS dinamico tramite PHP */
	class Js{
		// Converte un boolean in stringa
		public static function BoolString($bool){
			return $bool ? "true" : "false";
		}
	}

?>
