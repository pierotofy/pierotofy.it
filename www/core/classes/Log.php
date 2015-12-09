<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */ 
 
	/** Si occupa di loggare eventi nel datbase */
	class Log{
		// Types
		const INFO = 0;
		const WARN = 1;
		const ERR = 2;

		public static function Add($text, $type){
			 global $currentUser;
 
			 $user_id = $currentUser->isLogged() ? $currentUser['id'] : null;
 
			 $ip = get_ip();
			 $timestamp = time();
			 $text = db_escape($text);
			  
			 exequery("INSERT INTO logs (ip, `timestamp`, user_id, `text`, type) VALUES ('$ip', '$timestamp', $user_id, '$text', $type)");
		}

		public static function Info($text){
			Log::Add($text, Log::INFO);
		}

		public static function Warn($text){
			Log::Add($text, Log::WARN);
		}

		public static function Err($text){
			Log::Add($text, Log::ERR);
		}
			
	}
	
?>