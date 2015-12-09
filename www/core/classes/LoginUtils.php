<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */ 

/** Helpers per il login */
class LoginUtils{

	// @return array("username" => username, "password" => password)
	public static function HashToCredentials($hash){
		// Per dettagli su $hash, vedere /js/site.js Login.encrypt()

		/* hash è una variabile codificata in base 16, con un salt di 2 bytes,
	    i primi 2 bytes senza salt contengono la lunghezza (in char) dell'username,
	    il resto contiene lo username e la password */

	    // Togliamo il salt... (2 bytes)
	    $hash = substr($hash, 4);

	    // Calcoliamo le dimensioni (1 char = 2 hex digits)
	    $size = 2 * hexdec(substr($hash, 0, 2));
	    $hash = substr($hash, 2);

	    // Riprendi username e password
	    $username = "";
	    for ($c = 0; $c < $size; $c += 2) $username .= chr(hexdec($hash[$c] . $hash[$c + 1]) - 1);

	    	$password = "";
	    for (; $c < strlen($hash); $c += 2) $password .= chr(hexdec($hash[$c] . $hash[$c + 1]) - 1);

	    //et voila! user e pass pronti all'uso
    	return array("username" => $username, "password" => $password);
	}

	// @return un hash md5 per uso per gli users
	public static function Md5FromCredentials($username, $password){
		// L'hash nel database (users.md5) e' una combinazione di username + carattere % + password
		return md5($username . "%" . $password);
	}

	// Cerca di validare un indirizzo e-mail http://www.linuxjournal.com/article/9585?page=0,3
	public static function IsEmailValid($email){
		$isValid = true;
		$atIndex = strrpos($email, "@");
		if (is_bool($atIndex) && !$atIndex){
			$isValid = false;
		}else{
			$domain = substr($email, $atIndex+1);
			$local = substr($email, 0, $atIndex);
			$localLen = strlen($local);
			$domainLen = strlen($domain);
			if ($localLen < 1 || $localLen > 64){
				// local part length exceeded
				$isValid = false;
			}else if ($domainLen < 1 || $domainLen > 255){
				// domain part length exceeded
				$isValid = false;
			}else if ($local[0] == '.' || $local[$localLen-1] == '.'){
				// local part starts or ends with '.'
				$isValid = false;
			}else if (preg_match('/\\.\\./', $local)){
				// local part has two consecutive dots
				$isValid = false;
			}else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain)){
				// character not valid in domain part
				$isValid = false;
			}else if (preg_match('/\\.\\./', $domain)){
				// domain part has two consecutive dots
				$isValid = false;
			}else if (!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/',
					str_replace("\\\\","",$local))){
					// character not valid in local part unless 
					// local part is quoted
				if (!preg_match('/^"(\\\\"|[^"])+"$/',
					str_replace("\\\\","",$local))){
					$isValid = false;
				}
			}
			if ($isValid && !(checkdnsrr($domain,"MX") || checkdnsrr($domain,"A"))){
				// domain not found in DNS
				$isValid = false;
			}
		}
		return $isValid;
	}
}
?>
