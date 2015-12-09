<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */ 

	/** Helpers per manipolare date */
	class DateUtils{

		// @return una data formattata in maniera tale che le informazioni "ovvie" sono lasciate da parte
		public static function GetNice($timestamp){
			$now = time();
			$diff = $now - $timestamp;
			if ($diff < 60){
				return $diff . " secondi fa";
			}else if ($diff < 60 * 60){
				return round($diff / 60) . " minuti fa"; 
			}else if ($diff < 60 * 60 * 10){
				return round($diff / 60 / 60) . (round($diff / 60 / 60) == 1 ? " ora fa" : " ore fa");
			}else if ($diff < 60 * 60 * 24){
				return date("G:i", $timestamp);
			}else if ($diff < 60 * 60 * 24 * 365){
				return date("d/m G:i", $timestamp);
			}else{
				return self::GetStandard($timestamp);
			}
		}

		// @return una data formattata in maniera da vedere giorno, mese, anno ora e minuto
		public static function GetStandard($timestamp){
			return date("d/m/y G:i", $timestamp);
		}

		// @return una data formattata in maniera discorsiva "gg/mm/yy alle ore:min"
		public static function GetDiscursive($timestamp){
			return date("d/m/y", $timestamp) . " alle " . date("G:i", $timestamp);
		}
	}

?>
