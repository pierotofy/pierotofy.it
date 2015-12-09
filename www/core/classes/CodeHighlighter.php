<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */ 

	/** Si occupa di evidenziare blocchi di codice */
	class CodeHighlighter{
		// Variabile temporanea contenente i blocchi di [code][/code] usati in PreProcess.
		// Viene messa qui per poter dargli accesso tramite la callback codeMatch
		private static $code_blocks;

		// Rimuove i blocchi [code][/code] dal testo, li rimpiazza con dei segnaposto e li memorizza in un array
		// I segnaposto possono essere poi ripristinati chiamando PostProcess
		// @return testo con i blocchi [code][/code] rimpiazzati da #_CODE_NUM_#
		public static function PreProcess($text){
			self::$code_blocks = array();

			// Togli i blocchi [code][/code] dal testo
			$text = preg_replace_callback("/\[code\](.*?)\[\/code\]\n?/s", 'CodeHighlighter::codeMatch', $text);

			return $text;
		}

		// @return testo con i segnaposto #_CODE_NUM_# rimpiazzati da codice HTML per evidenziare codice
		public static function PostProcess($text){
			for($i = 1; $i <= count(self::$code_blocks); $i++){
				$text = str_replace("#_CODE_".$i."_#", "<pre class='prettyprint linenums'>".self::$code_blocks[$i - 1]."</pre>", $text);
			}

			return $text;
		}

		// Callback per preg_replace_callback in getParsedMessage
		private static function codeMatch($matches){
			CodeHighlighter::$code_blocks[] = $matches[1];
			return "#_CODE_" . count(CodeHighlighter::$code_blocks) . "_#";
		}
        
        // Metodo per convertire i tags <pre> della versione desktop (usati dall'editor WYSIWYG)
        // in tags che usano il nuovo syntax hightlighter
        // @return stringa con i tag <pre> sistemati in modo da far funzionare il syntax highlighting
        public static function fixDeprecatedPreTags($text){
            return preg_replace("/<pre class=\"brush.*?>/", "<pre class='prettyprint linenums'>", $text);
        }
	}

?>
