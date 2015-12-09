<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */ 

	/** Permette di visualizzare dei messaggi di avviso statici all'utente */
	class AlertMessage{
		const INFO = 0;
		const WARN = 1;

		// Ritorna l'HTML per visualizzare un messaggio
		// $type puo' essere AlertMessage::INFO o AlertMessage::WARN
		public static function Get($message, $type = self::INFO){
			$class = "";
			$icon = "icon-information_black";
			if ($type == self::WARN){
				$class = "warning";
				$icon = "icon-warning";
			}

			return sprintf('<div class="alert %s"><span class="icon %s"></span><span class="message">%s</span></div>', $class, $icon, $message);
		} 

		// Stampa l'HTML per visualizzare un messaggio
		// $type puo' essere AlertMessage::INFO o AlertMessage::WARN
		public static function Show($message, $type = self::INFO){
			echo self::Get($message, $type);
		}
	}

?>
