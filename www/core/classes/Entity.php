<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */ 

    /** Rappresenta un entita' nel database. Un entita' deve necessariamente
     * possedere un campo ID */
    abstract class Entity implements ArrayAccess{
    	protected $values = null;

        // @param values la lista dei campi per rappresentare l'entita'
        //      oppure la clausola WHERE per trovare un singolo record che rappresenta l'entita'
        //      oppure l'ID che identifica il campo (euristico)
        public function Entity($values){
            if (is_array($values)){
                $this->loadFromData($values);
            }else if (is_numeric($values)){
                $sql = $this->getSelectSql();
                $this->loadFromSql($sql . " WHERE " . $this->heuristicFindId($sql) . " = $values");
            }else{
                $this->loadFromSql($this->getSelectSql() . " WHERE " . $values);
            }
        }

        // Metodo da sovrascrivere per ritornare il codice SQL
        // che permette di selezionare un'entita' singola (e senza la parte WHERE) 
        public abstract function getSelectSql();

        // Cerca di trovare il nome del campo ID nella query passata come argomento
        // @return il primo campo ID (oppure "id" se l'euristica fallisce) presente nella query
        private function heuristicFindId($sql){
            if (preg_match("/SELECT .*([\w]*\.?id)[ ,]/Us", $sql, $matches)){
                return $matches[1];
            }else{
                return "id";
            }
        }

        // Esegue la query specificata in sql_select e carica il risultato nell'entita'
        // @return true se la query ha portato un risultato e i risultati sono stati caricati, false altrimenti
        private function loadFromSql($sql_select){
            $this->values = null;
            $row = DB::FindOne($sql_select);
            return $this->loadFromData($row);
        }

        // Inizializza l'entita' con i dati forniti da $row
        // Solitamente $row contiene un record preso dal database
        // @return true se i dati sono stati caricati con successo, false altrimenti
        private function loadFromData($row){
            if ($row['id']){
                $this->values = $row;
                return true;
            }

            return false;
        }

    	// Permetti di settare dei valori sulle chiavi che esistono gia' 
    	// tranne che per i campi id
        public function offsetSet($offset, $value) {
            if (!is_null($offset)) {
            	if ($offset != "id" && strpos($offset, "_id") === FALSE){
                	$this->values[$offset] = $value;
                }else{
                	throw new Exception("Trying to set a value to an ID field. ($offset)");
                }
            } else {
                throw new Exception("Trying to set a value to a key that does not exist. ($offset)");
            }
        }

        public function offsetExists($offset) {
            return isset($this->values[$offset]);
        }

        public function offsetUnset($offset) {
            throw new Exception("Trying to unset a a key. ($offset)");
        }

        // Accessore tramite []
        // Nota che i valori ritornati tramite questo operatore sono automaticamente purificati
        // per prevenire attacchi XSS. Se si vuole accedere al VERO valore, usare 
        public function offsetGet($offset) {
            return isset($this->values[$offset]) ? purify($this->values[$offset]) : null;
        }

        // @return il valore originale non protetto per attacchi XSS
        public function getRaw($offset){
        	return isset($this->values[$offset]) ? $this->values[$offset] : null;
        }

        // Renderizza questo oggetto tramite un template
        // @param view_file nome del template da usare come template (in core/views/)
        // @param values hash contenente parametri da inviare alla view (in aggiunta a quelli gia' inclusi dall'Entity)
        public function render($view_file, $values = array()){
            // TODO: vedere se costruire un'oggetto comporta un rallentamento troppo grande
            //      oppure se bisognerebbe trovare una soluzione piu' veloce
            $view_builder = new ViewBuilder($view_file);
            $view_builder->setValues(array_merge($this->values, $values));
            return $view_builder->render();
        }
    }

?>
