<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */ 

	/** Helpers per manipolare stringhe */
	class Text{

		// "Taglia" una stringa se la sua lunghezza e' superiore a $limit
		// @return una stringa lunga al massimo $limit caratteri
		public static function Cut($string, $limit, $ending = "..."){
			if (strlen($string) > $limit) $string = substr($string,0,$limit-strlen($ending)) . $ending;
			return $string;
		}

		// Rimuove tutti i caratteri non alfanumerici (piu' "_") dalla stringa
		// @return stringa filtrata
		public static function AlphaNumericFilter($text, $replace = ""){
			return preg_replace("/[^A-Za-z0-9_]/", $replace, $text);
		}

		// Converte i tags bbcode nei rispettivi componenti HTML
		// @return codice HTML
		public static function BBCodesToHtml($text){
			// Stili
			$out = preg_replace("/\[b\](.*)\[\/b\]/Us", "<b>\\1</b>", $text);
			$out = preg_replace("/\[i\](.*)\[\/i\]/Us", "<i>\\1</i>", $out);
			$out = preg_replace("/\[u\](.*)\[\/u\]/Us", "<u>\\1</u>", $out);

			// Tags
			$out = preg_replace("/\[center\](.*)\[\/center\]/Us", "<div style='text-align: center;'>\\1</div>", $out);
			$out = preg_replace("/\[left\](.*)\[\/left\]/Us", "<div style='text-align: left;'>\\1</div>", $out);
			$out = preg_replace("/\[right\](.*)\[\/right\]/Us", "<div style='text-align: right;'>\\1</div>", $out);
			
			// Quotazioni
			$out = preg_replace("/\[quote\]([\n\r]*)/s", "<div class='quote'>", $out);
			$out = preg_replace("/\[\/quote\]/s", "</div>", $out);


			// Tags left/center/right non chiusi
			$out = preg_replace("/\[\/?(left|center|right)\]\s?\n?/", "", $out);
			
			// Vecchia convenzione per gli URL
			$out = preg_replace("/\[url\](.*)\[\/url\]/U", "\\1", $out);
			
			return $out;
		}

		// Converte alcuni caratteri di escape (\n, \t, ecc.) nei rispettivi tags HTML
		// @return codice HTML
		public static function EscapeCharsToHtml($text){
			// Esegue le conversioni...
			$text = str_replace("\n", "<br/>", $text);
			$text = str_replace("\t", "&nbsp;&nbsp;&nbsp;&nbsp;", $text);

			return $text;
		}

		// Si occupa di convertire un messaggio contenente bbcodes, smiles e pezzi di codice sorgente
		// in un HTML pronto per essere visualizzato. Usato ad esempio nel forum, messaggi, commenti, ecc.
		public static function MessageToHtml($text){
			$text = CodeHighlighter::PreProcess($text);

			$text = Smiles::Apply($text);
			$text = Text::BBCodesToHtml($text);
			$text = Text::AutoLink($text);
			$text = Text::EscapeCharsToHtml($text);

			$text = CodeHighlighter::PostProcess($text);

			return $text;
		}

		// Converte gli URL di un testo in anchor tags
		// http://stackoverflow.com/questions/1959062/how-to-add-anchor-tag-to-a-url-from-text-input
		// @param text testo
		// @return codice HTML
		public static function AutoLink($text){
		   $pattern  = '#\b(([\w-]+://?|www[.])[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/)))#';
		   return preg_replace_callback($pattern, 'Text::AutoLinkCallback', $text);
		}
		private static function AutoLinkCallback($matches){
			$url = array_shift($matches);
		    $url_parts = parse_url($url);

	       	$text = parse_url($url, PHP_URL_HOST) . parse_url($url, PHP_URL_PATH);
		    $text = preg_replace("/^www./", "", $text);

		    $last = -(strlen(strrchr($text, "/"))) + 1;
		    if ($last < 0) {
		        $text = substr($text, 0, $last) . "&hellip;";
		    }

		    return sprintf('<a rel="nowfollow" href="%s">%s</a>', $url, $text);
		}
	}

?>
