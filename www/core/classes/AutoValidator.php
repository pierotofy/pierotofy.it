<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */ 
 
	/** Questa classe si occupa di verificare automaticamente
	 * i campi inviati da un form, sul lato server 
	 * ====================================
	 * Funzionamento:
	 *		 1. Pagina che crea un form inizializza la classe AutoValidator
	 *		 2. Una o piu' regole vengono aggiunte al form
	 *		 3. Una sessione per l'utente corrente "av_" + sha1(form_id|lista_regole) contenente la lista
	 *				delle regole viene creata. L'inclusione di form_id permette di evitare che un utente
	 *				apra un secondo form (in un altra pagina), forgia una risposta che contiene dei campi validi
	 *				per il secondo form e li invia al vero form, passando la validazione.
	 			Il motivo per questo meccanismo (un po' complesso) e' che in questa maniera non dobbiamo ripetere la scrittura
	 			delle regole sia dal lato client che dal lato server.
	 *		 4. Un token viene generato (sha1(form_id|lista_regole)) e viene incluso come parametro nel form
	 *				nel lato client (av_token)
	 *		 5. Quando il form viene inviato, la pagina che riceve il form:
	 *			a. Crea una classe AutoValidator specificando (importante!) il form_id da cui si aspetta i dati
	 *			b. Trova la sessione contenente le regole
	 *			c. Applica le regole ai campi inviati
	 *
	 * Non basterebbe associare ad un form_id una lista di regole? No, utenti diversi potrebbero
	 * avere accesso a campi diversi.
	 */
	class AutoValidator{
		const TOKEN_ID = "av_token";

		private $form_data;
		private $form_id;
		private $rules;
		private $last_error = "";

		// @param @form_id ID del form di cui si sta facendo la validazione
		// @param @form_data solitamente $_POST oppure $_GET se inizializzato nella pagina che riceve i dati del form
		//					 NULL se inizializzato nella pagina che costruisce il form
		public function AutoValidator($form_id, $form_data = NULL){
			$this->form_id = $form_id;
			$this->form_data = $form_data;
		}

		// Imposta le regole di validazione (da chiamare quando si costruisce il form)
		// @param rules array di regole che funzionano per RSV (https://github.com/benkeen/php_validation/blob/master/demo.php)
		public function setRules($rules){
			$this->rules = $rules;

			// Aggiorna la sessione
			$_SESSION["av_" . $this->computeToken($this->form_id, $this->rules)] = $this->rules;
		}

		// Ritorna la sequenza di caratteri che identifica questa validazione
		// 	la sequenza e' da inviare con ID AutoValidator::TOKEN_ID quando il form viene inviato
		public function getToken(){
			return $this->computeToken($this->form_id, $this->rules);
		}

		public function validate(){
			// Cerca il token
			if (isset($this->form_data[self::TOKEN_ID])){
				// Trova la sessione
				$av_token = substr($this->form_data[self::TOKEN_ID], 0, 40); // 40 caratteri massimi
				if (isset($_SESSION["av_" . $av_token])){
					// Prende le regole
					$rules = $_SESSION["av_" . $av_token];

					// Valida
					if ($this->computeToken($this->form_id, $rules) == $av_token){
						// Tutto a posto
						// Comincia la validazione dei campi

						$errors = validateFields($this->form_data, $rules); // validation-2.3.3.php
						if (empty($errors)){
							return true;
						}else{
							$this->last_error = join("<br/>", $errors);
							return false;
						}
					}else{
						$this->last_error = "Il token sembra provenire da un'altro form.";
					}
				}else{
					$this->last_error = "Sessione scaduta. Riprova.";
				}
			}else{
				$this->last_error = "Token mancante.";
			}
		}

		public function getLastError(){
			return $this->last_error;
		}

		private function computeToken($form_id, $rules){
			return sha1($form_id . "|" . join("", $rules));
		}
	}

?>
