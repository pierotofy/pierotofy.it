<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */ 
 
	require_once("Restful.php");

	/** Una risposta da una pagina RESTFUL */
	class RestfulResponse{
		private $format;
		private $success;
		private $values;

		function RestfulResponse($format = "json"){
			$this->format = $format;
			$this->success = false;
			$this->values = array();
		}

		// Imposta un parametro da inviare nella risposta
		function set($param, $value){

			// json_encode & co supportano solo UTF-8
			// questo controllo aiuta a prevenire errori nell'invio
			// di stringhe. Nota che un array di stringhe non verra' 
			if (is_string($value)) Charset::AssureUtf8($value);

			$this->values[$param] = $value;
		}

		// Indica se il comando e' stato eseguito con successo
		function setSuccess($value){
			if ($value) $this->success = true;
			else $this->success = false;
		}

		// Indica se il comando non e' stato eseguito con successo
		function setError($errorMsg = "errore indefinito"){
			$this->setSuccess(false);
			$this->set("error", $errorMsg);
		}
		
		// Helper per impostare un campo "html"        
        function setHtml($html){
            $this->set("html", $html);
        }
        
        // Helper per impsotare un campo "text"
        function setText($text){
            $this->set("text", $text);
        }
        
		// Stampa questa risposta
		function send(){
			if (DEBUG) sleep(1); // Simula un ritardo nell'invio
			$response = array_merge(array("success" => $this->success), $this->values);
			Restful::PrintResponse($response, $this->format);
		}
	}
?>