<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */ 

/** Si occupa di "tradurre" gli URL della versione mobile
 * con quelle della versione desktop per permettere di cambiare 
 * da una versione all'altra */
class UrlBridge{

	// Quelle paths che hanno semplicemente cambiato directory e non convenzione
	// rispetto alla versione desktop devono essere aggiunte in questa lista
	private static $simple_replacements = array(
		array("mobile" => "/p/forum/",
			  "desktop" => "/pages/extras/forum/"
	  	),
	  	array("mobile" => "/p/user/panels/messages/",
			  "desktop" => "/pages/login/cpanel/mail/"
	  	),
	);

	// @param url url completo di una pagina nella versione desktop
	// @return URL completo per la versione mobile (se disponibile, oppure l'URL di base della versione mobile)
	public static function ToMobile($url){
		return self::ToVersion($url, "desktop", "mobile");
	}

	// @param url url completo di una pagina nella versione mobile
	// @return URL completo per la versione desktop (se disponibile, oppure l'URL di base della versione desktop)
	public static function ToDesktop($url){
		return self::ToVersion($url, "mobile", "desktop");
	}

	private static function ToVersion($url, $from_version, $to_version){
		$components = parse_url($url);
		$path = $components['path'];

		foreach (self::$simple_replacements as $replacement){
			$reg = "/^" . preg_quote($replacement[$from_version], '/') . "/";
			if (preg_match($reg, $path)){
				$new_path = preg_replace($reg, $replacement[$to_version], $path);

				$return_url = self::BaseUrl($to_version) . $new_path;

				if (isset($components['query'])) $return_url .= "?" . $components['query'];
				if (isset($components['fragment'])) $return_url .= "#" . $components['fragment'];
				
				return $return_url;
			}
		}
        
        // ###########################
        // Guide
        if(preg_match("/\/p\/guide\//", $path)){
          $return_url = '#';
          if($to_version == "desktop")
            $return_url = DESKTOP_VERSION_URL.preg_replace("/[0-9]-/", "", $path);
          else{
            // TODO
          }
          return $return_url;
        }
        
		return self::BaseUrl($to_version);
	}

	private static function BaseUrl($for_version){
		return $for_version == "mobile" ? MOBILE_VERSION_URL : DESKTOP_VERSION_URL;
	}
}
?>
