<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */ 
 
	/** Classe che si occupa di comunicare con il templating engine */
	class ViewBuilder{
		private $engine;
		private $values = array();

		// @param view_file nome del template scurvy da usare come template (in core/views/)
		// @param values (opzionale) hash di valori da passare al template
		public function ViewBuilder($view_file, $values = array()){
			$this->engine = new Scurvy($view_file, ROOT_PATH . '/core/views/');
			$this->setValues($values);
		}

		// @param values hash di valori da passare al template
		public function setValues($values){
			$this->values = $values;

			foreach($this->values as $key => $value){
				$this->engine->set($key, $value);
			}
		}

		// @param singolo elemento chiave/valore da aggiungere alla lista di valori da passare al template
		public function addValue($key, $value){
			$this->values = array_merge($this->values, array($key, $value));
			$this->engine->set($key, $value);
		}

		// Renderizza il template corrente
		public function render(){
			return $this->engine->render();
		}
	}

?>
