<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */ 

	/** Classe base per la costruzione di widgets da usare
	 * con FormBuilder */
	abstract class FormWidget{
		protected static $widget_count = 1;
		protected $widget_id;

		public function FormWidget(){
			$this->widget_id = self::$widget_count++;
		}

		// @return il codice HTML del widget
		abstract public function getHtml();
	}

?>
