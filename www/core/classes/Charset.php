<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */ 
 
	/** Helpers per convertire charsets */
	class Charset{

		// @param utf8 stringa UTF-8
		// @return valore convertito per essere inserito nel database
		// 		MySQL usa latin1 ( ISO-8859-1 )
		public static function Utf8ToDB($utf8){
			return iconv("UTF-8", "ISO-8859-1//TRANSLIT", $utf8);
		}

		// @param latin1 stringa ISO-8859-1
		// @return valore convertito in UTF-8
		public static function DBToUtf8($latin1){
			return iconv("ISO-8859-1//TRANSLIT", "UTF-8", $latin1);
		}


		// Si assicura che la stringa passata come argomento
		// sia in formato UTF-8
		public static function AssureUtf8(&$string){
			if (mb_detect_encoding($string, 'utf-8', true) === false) {
			    $string = mb_convert_encoding($string, 'utf-8', 'iso-8859-1');
			}
		}
	}

?>
