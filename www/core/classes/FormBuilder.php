<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */ 

	/** Classe per generare forms */
	class FormBuilder{
		private $form_id;
		private $post_url;
		private $fields = array();
		private $widgets = array();
		private $closeable = false;
		private $visible = true;
		private $control_buttons = array();
		private $validation_rules = array();
		private $serverside_autovalidate = true;

		// Crea un nuovo form
		// @param form_id id del form (inserito poi nel DOM come <form id="id" name="id">)
		// @param post_url url della pagina dove viene inviato il form
		public function FormBuilder($form_id, $post_url){
			$this->form_id = $form_id;
			$this->post_url = $post_url;
		}

		// Aggiunge dei campi al form
		// @param fields array di array associativi (lista di oggetti), dove ogni array associativo contiene:
		//		"id" => id del campo
		//		"type" => |textinput, textarea, checkbox|
		//		"height" => (opzionale) altezza in pixels del campo
		//		"label" => (opzionale) testo da affiancare al campo
		//		"value" => (opzionale) valore di default
		//		"attrs" => (opzionale) stringa contenente attributi che verranno aggiunti al campo
		//      "validation" => (opzionale) array di stringhe che usa la sintassi specificata qui: http://www.benjaminkeen.com/open-source-projects/smaller-projects/really-simple-validation-js/really-simple-validation-standalone-version/
		// 						le regole verranno applicate sia nella parte client (js) che server (php)
		//						ogni stringa nell'array corrisponde ad una regola
		//						l'utente puo' anche decidere di passare una singola stringa se c'e' solo una regola da seguire
		//		"send"	=> (opzionale) |true, false| indica se questo campo deve essere inviato con il form. A volte puo' essere necessario avere dei campi
		//					che vengono riempiti dall'utente ma poi non devono essere inviati direttamente (magari vengono modificati tramite JS)
		public function addFields($fields){
			$this->fields = array_merge($this->fields, $fields);
		}

		// Aggiunge un campo al form
		// @param fields vedi AddFields
		public function addField($field){
			array_push($this->fields, $field);
		}

		// Aggiunge un widget (componente) alla fine del form
		// @param widget un oggetto FormWidget
		public function addWidget($widget){
			array_push($this->widgets, array("html" => $widget->getHtml()));
		}

		// Imposta questo form come chiudibile oppure no
		// Quando un form e' chiudibile, una "X" viene aggiunta per permettere all'utente
		// di chiudere il form. Quando il form viene chiuso, un evento "FormClosed" viene inviato
		// tramite Javascript.
		// @param value true|false
		public function setCloseable($value){ 
			$this->closeable = $value;
		}

		// Imposta la visibilita' iniziale del form
		// @param value true|false
		public function setVisible($value){
			$this->visible = $value;
		}

		// Imposta se questo form deve includere il codice di validazione automatico lato server
		// @param value true|false
		public function setServerSideAutovalidate($value){
			$this->serverside_autovalidate = $value;
		}

		// Helper per impostare velocemente un pulsante di invio di default
		// @param label etichetta da aggiungere al pulsante di invio
		public function setDefaultSubmit($label = "Invia"){
			$this->addControlButton($label, "submit");
		}

		// Aggiunge un bottone alla fine del form
		// @param label etichetta del bottone
		// @param action "submit"|"javascript:*" (submit invia il form, una stringa che comincia per javascript: esegue il comando specificato dopo javascript:)
		//		
		public function addControlButton($label, $action){
			$js = null;
			if (strtolower($action) == "submit"){
				$js = "javascript:FormBuilder.Submit('$this->form_id')";

			// $action Inizia per javascript: ?
			}else if (strpos(strtolower($action), "javascript:") === 0){
				$js = $action;
			}

			array_push($this->control_buttons, array("label" => $label, "action" => $js));
		}

		// Aggiunge un elemento nascosto che verra' inviato con il form
		// @param id id dell'elemento
		// @param value valore dell'elemento
		public function addValue($id, $value){
			$this->addField(array(
		        "id" => $id,
		        "type" => "hidden",
		        "value" => $value
	    	));
		}

		// Ritorna il DOM id del campo (mappa id --> DOM id)
		// Siccome ci possono essere piu' forms sulla stessa pagina, e' essenziale che
		// non ci siano collissioni di nomi per i campi del form
		// @param field_id ID del campo
		public function getDOMId($element_id){
			return 'form-' . $this->form_id . '-field-' . $element_id;
		}

		public function render(){
			$vb = new ViewBuilder("form/form.html");

			// Calcola i campi di validazione
			// da passare alla view
			$all_rules = array();

			for ($i = 0; $i < count($this->fields); $i++){
				if (!isset($this->fields[$i]['value'])) $this->fields[$i]['value'] = "";
				if (!isset($this->fields[$i]['label'])) $this->fields[$i]['label'] = "";
				if (!isset($this->fields[$i]['send'])) $this->fields[$i]['send'] = true;

				$attributes = ""; // Attributi' da aggiungere ad ogni campo

				$attributes .= ' data-reset-value="' . $this->fields[$i]['value'] . '"'; // valore di default
				$attributes .= ' data-formfield ';
				$attributes .= ' id="' . $this->getDOMId($this->fields[$i]["id"]) . '" ';
				$attributes .= ' name="' . $this->fields[$i]["id"] . '" ';

				if (!$this->fields[$i]['send']) $attributes .= ' data-dontsend="true" ';

				// Attributi specificati dall'utente
				if (isset($this->fields[$i]['attrs']))	$attributes .= ' ' . $this->fields[$i]['attrs'] . ' ';			

				if (isset($this->fields[$i]['validation'])){

					// Una sola regola (stringa)?
					if (!is_array($this->fields[$i]['validation'])){
						// Wrappa
						$this->fields[$i]['validation'] = array($this->fields[$i]['validation']);
					}

					$rules = array();
					foreach($this->fields[$i]['validation'] as $validation_rule){
						$parts = explode(",", $validation_rule);

						// Trim
						for ($j = 0; $j < count($parts); $j++){
							$parts[$j] = trim($parts[$j]);
						}

						// Le regole di validazione devono includere l'ID dell'elemento
						// siccome non vogliamo fare ripetizioni, (l'ID e' gia' conosciuto)
						// lo aggiungiamo dinamicamente
						// "[if:FIELDNAME=VALUE,]REQUIREMENT,fieldname[,fieldname2[,fieldname3,date_flag]],error message"
						if (count($parts) >= 2){
							$id_offset = 1;
							if (strpos($parts[0], "if:") === 0){
								$id_offset = 2;
							}

							array_splice($parts, $id_offset, 0, array($this->fields[$i]['id']));
						}
						$rules[] = join(",", $parts);
					}

					// Le regole verranno aggiunte assieme al campo tramite data-validate
					$attributes .= ' data-validate="' . join("|", $rules) . '" ';

					// Tieni traccia di tutte le regole per l'auto validazione lato server
					// ignorando le regole per i campi che non verranno inviati
					if ($this->fields[$i]['send']){
						$all_rules = array_merge($all_rules, $rules);
					}
				}

				// Ogni elemento ha questi tag aggiuntivi
				$this->fields[$i]['formbuilder_attrs'] = $attributes;
			}

			// Esporta tutti i membri di questa classe alla view
			$members = array();
			foreach($this as $key => $value){
				$members[$key] = $value;
			}
			$vb->setValues($members);

			// Calcola alcuni campi
			$vb->addValue("control_buttons_count", count($this->control_buttons));
			$vb->addValue("widgets_count", count($this->widgets));

			// Imposta l'auto validazione se necessario
			if ($this->serverside_autovalidate){
				$av = new AutoValidator($this->form_id);
				$av->setRules($all_rules);
				$vb->addValue("av_token_id", AutoValidator::TOKEN_ID);
				$vb->addValue("av_token", $av->getToken());
			}

			return $vb->render();
		}
	}

?>
