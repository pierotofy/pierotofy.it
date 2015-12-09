<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */ 
 
	/* In questo file ci sono gli helpers the si occupano
	 * della comunicazione con il database */

	// Riferimento all'istanza generata con mysqli_connect
	$link = NULL;

	// Alla sua distruzione (termine dello script) chiamera' il distruttore.
	class _DbConnector{
		function _DbConnector() {
	   		global $link;
	   		$errmsg = "Momentaneamente offline. Riprova in 5 minuti.";
			$link = mysqli_connect(DBHOST, DBUSER, DBPASS,DBNAME);
			if (!$link) ndie($errmsg .  " errno: ". mysqli_errno());
		}

		function __destruct() {
		   global $link;
		   if ($link) mysqli_close($link);
		}
	}

	// Tiene traccia delle queries eseguite per debugging/profiling
	$debug_queries_count = 0;
	$debug_queries_list = array();

	// Esegue una query e ritorna la sua risorsa 
	function exequery($sql){
	 	global $link, $debug_queries_count, $debug_queries_list;

		// Tieni traccia
		if (DEBUG){
			$debug_queries_count++; 
		 	$debug_queries_list[] = $sql; 
		}

		// Esegui
		if (!($query = mysqli_query($link, $sql))){
		 	if (DEBUG){
				ndie("Errore. Dump della query: \n\n" . $sql . "\n\n - Errore: " . mysqli_error($link));
		 	}else{
			    echo make_warn_msg("Ooops! E' successo un errore","Ci scusiamo per l'inconveniente, ma qualche volta succede. 
					Se vuoi aiutarci a prevenire questo errore per favore <a href='/p/conctat/writeus.php?member_id=4'>contatta l'amministratore</a> spiegando 
					come è possibile replicare questo errore.");
		 	}
		}

		// In ogni caso ritorna il risultato della query
		return $query;
	}
?>