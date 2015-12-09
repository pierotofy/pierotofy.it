<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */ 
 
	/** Helpers usati dalle pagine RESTFUL */
	class Restful{
		private $format;

		function Restful($format = "json"){
			$this->format = $format;
		}

		public static function PrintResponse($response, $format = "json"){
            if ($format == "json"){
                echo json_encode($response);
            }else if($format == "html"){
                echo (isset($response['html']) ? $response['html'] : '1');
            }else if($format == "text"){
                echo (isset($response['text']) ? $response['text'] : '1');
            }else{
                throw new Exception("Format non valido: $format");
            }
		}

		public static function DieResponse($response, $format = "json"){
			Restful::PrintResponse($response, $format);
			die();
		}
	}
	
?>