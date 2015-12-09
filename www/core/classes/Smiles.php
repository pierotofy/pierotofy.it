<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */ 
 
	/** Si occupa di gestire l'archivio di smiles 
	 * e di convertire un testo con le immagini appropriate */
	class Smiles{
		// Types
		private static $smiles = array(
			":)" => "felice.gif",
			":(" => "triste.gif",
			":-o" => "arrabbiato.gif",
			":asd:" => "asd.gif",
			":d" => "disperato.gif",
			":-?" => "dubbioso.gif",
			"8-)" => "figo.gif",
			"8-|" => "innocente.gif",
			":-|" => "preoccupato.gif",
			":k:" => "ok.gif",
			":rotfl:" => "rotfl.gif",
			";)" => "occhiolino.gif",
			":D" => "sorridente.gif",
			":ot:" => "ot.gif",
			":alert:" => "attenzione.gif",
			":love:" => "love.gif",
			":grr:" => "arrabbiato2.gif",
			":blush:" => "blush.gif",
			":heehee:" => "heehee.gif",
			":idea:" => "idea.gif",
			":noway:" => "noway.gif",
			":om:" => "om.gif",
			":rofl:" => "rofl.gif",
			":yup:" => "yup.gif",
			":cheer:" => "cheer.gif",
			":_doubt:" => "doubt.gif",
			":hail:" => "hail.gif",
			":nono:" => "nono.gif",
			":pat:" => "pat.gif"
		);

		public static function GetList(){
			return self::$smiles;
		}

		// Applica gli smiles al testo passato come argomento
		// @return HTML
		public static function Apply($text){
			foreach(self::$smiles as $pattern => $file){
				// Converti gli smiles rimanenti con le immagini appropriate
				$text = str_replace($pattern, '<img src="/images/smiles/' . $file . '" alt="' . $pattern . '" />', $text);
			}
			
			return $text;
		}			
	}
	
?>