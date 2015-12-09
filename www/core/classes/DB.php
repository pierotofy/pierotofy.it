<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */ 
 
	/** Helpers per interagire con il database */
	class DB{

		// Esegue una query specificata come parametro e ritorna il primo risultato
		// @return risultato di mysqli_fetch_array sulla query
		public static function FindOne($sql){
			$q = exequery($sql);
			return mysqli_fetch_array($q, MYSQLI_ASSOC);
		}

		// Conta il numero di records in $table in base alla clausola $where
		// @return il numero di records
		public static function Count($table, $where){
			$res = self::FindOne("SELECT COUNT(1) AS count FROM $table WHERE $where");
			return (int)$res['count'];
		}

		// Aggiunge alla query passata come argomento il parametro SQL_CALC_FOUND_ROWS
		// che permette di ricevere il numero di righe ritornato nell'ultima query
		// ignorando il parametro LIMIT (http://dev.mysql.com/doc/refman/5.0/en/information-functions.html#id2890708)
		// @return query SQL
		public static function SelectCalcFoundRows($select_sql){
			$select_sql = trim($select_sql);
			
			if (stripos($select_sql, "SELECT") === 0){
				return preg_replace("/^SELECT/i", "SELECT SQL_CALC_FOUND_ROWS", $select_sql);
			}else{
				throw new Exception("SelectCalcFoundRows puo' essere chiamato solo con query di SELECT (passato: $select_sql)");
			}
		}

		// Ritorna il numero di righe ritornato nell'ultima query che ha utilizzato SelectCalcFoundRows
		public static function GetCalcFoundRows(){
			$res = self::FindOne("SELECT FOUND_ROWS() AS count");
			return (int)$res['count'];
		}

		// Ritorna la stringa da aggiungere alla clausola LIMIT per visualizzare
		// i records della pagina $page, visualizzando $results_for_page risultati per pagina
		// @return stringa da inserire dopo LIMIT in un comando SQL
		public static function GetLimit($page, $results_for_page){
			return ($page - 1) * $results_for_page . ", " . $results_for_page;
		}

		// @return l'ID dell'ultimo INSERT
		public static function LastId(){
			global $link;

			return mysqli_insert_id($link);
		}
	}

?>
