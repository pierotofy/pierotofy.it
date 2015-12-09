<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */ 
 
/** Si occupa di mandare e-mails */
class Mailer{
	// @return true quando l'e-mail e' inviata con successo, altrimenti false
	// @raise eccezione quando l'indirizzo e-mail del mittente non esiste nella configurazione del sito
	static function SendEmail($fromAddr, $toAddr, $subject, $body){
		global $email_accounts; // definito in /etc/config/email_settings.php

		if (file_exists(stream_resolve_include_path("Mail.php")) && file_exists(stream_resolve_include_path("Mail/mime.php"))){
			include("Mail.php");
			include("Mail/mime.php");
			$include_failed = false;
		}else{
			$include_failed = true;
		}

		if (!isset($email_accounts[$fromAddr])) throw new Exception("Unknown e-mail address account: $fromAddr. Cannot send e-mail.");

		// Se siamo in modalita' debug, oppure la libreria non e' disponibile, le e-mail non verranno
		// inviate, ma semplicemente visualizzate in una flash
		if (DEBUG || $include_failed){
			Flasher::Show("Inviata e-mail da $fromAddr a $toAddr ($subject): $body");
			return true;
		}else{
			// Percorso normale

    		$fromPass = $email_accounts[$fromAddr];
		  	$header_values = array(
				  'From'    => $fromAddr,
				  'Subject' => $subject
			);

		  	$mime = new Mail_mime("\r\n");
		  	$mime->setTXTBody(strip_tags($body));
		  	$mime->setHTMLBody("<!DOCTYPE html><html><head></head><body>" . $body . "</body></html>");
		  	$content = $mime->get();
		  	$headers = $mime->headers($header_values);
		  	
		    $options = array(
		    	'host' => IMAP_HOST, // /etc/config/email_settings.php
		    	'port' => IMAP_PORT, // /etc/config/email_settings.php
		    	'persist' => false,
		    	'auth' => 'LOGIN',
		    	'username' => $fromAddr,
		    	'password' => $fromPass
		    );

		    $mailer =& Mail::factory('smtp', $options);
		    
		    if(!PEAR::isError($mailer)) {
		      $mailer->send($toAddr, $headers, $body);
		    
		      return !(PEAR::isError($mail));
		    }else{
		    	return false;
		    }
	    }
	}
}
	
?>