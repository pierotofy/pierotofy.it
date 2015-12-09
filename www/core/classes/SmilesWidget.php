<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */ 

	/** Widget per visualizzare gli smiles*/
	class SmilesWidget extends FormWidget{
		private $html;

		// @param element_id ID dell'elemento nel DOM che ricevera' gli smiles (es. "message-text")
		// @param smiles_per_row numero di smiles per riga nel widget
		public function SmilesWidget($element_id, $smiles_per_row = 4){
			parent::__construct();
						
			$vb = new ViewBuilder("form/smilesWidget.html");
			
			// Genera l'HTML delle righe degli smiles qui
			$smiles_table = "";
			$c = 0;
			foreach(Smiles::GetList() as $smile => $image){ 
				if ($c == 0) $smiles_table .= "<tr>";
				$smiles_table .= sprintf('<td onclick="javascript:Text.AppendTo(\'%s\', \'%s\');" data-hide="smiles-list-%s">
					<img src="/images/smiles/%s" alt="%s" />
				</td>', $element_id, $smile, $this->widget_id, $image, $smile);
				
				// Dividi gli smiles in righe
				$c = ($c + 1) % $smiles_per_row;
				if ($c == 0) $smiles_table .= "</tr>";
			} 

			$vb->addValue("widget_id", $this->widget_id);
			$vb->addValue("smiles_table", $smiles_table);
			$vb->addValue("element_id", $element_id);

			$this->html = $vb->render();
		}

		// @return il codice HTML del widget
		public function getHtml(){
			return $this->html;
		}
	}

?>
