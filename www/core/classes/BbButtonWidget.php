<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */ 

	/** Widget per visualizzare un popup per scegliere i codici BB */
	class BbButtonWidget extends FormWidget{
		private $html;

		// @param element_id ID dell'elemento nel DOM che ricevera' il testo (es. "message-text")
		// @param features lista separata da | contenente gli elementi da includere
		//			dove ogni elemento e' uno di: code,quote,g,c,s
		//			esempio #1: "code|quote"
		//			esempio #2: "code|g|c" 
		public function BbButtonWidget($element_id, $features = "code|quote|g|c|s"){
			parent::__construct();

			$vb = new ViewBuilder("form/bbButtonWidget.html");
			
			$features = explode("|", $features);
			foreach($features as $feature){
				$vb->addValue($feature, true);
			}
			$vb->addValue("widget_id", $this->widget_id);
			$vb->addValue("element_id", $element_id);

			$this->html = $vb->render();
		}

		// @return il codice HTML del widget
		public function getHtml(){
			return $this->html;
		}
	}

?>
