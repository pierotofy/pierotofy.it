<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */ 

require_once("__inc__.php");
require_once(ROOT_PATH . "core/3rdparty/simpletest/autorun.php");

// Suite per far eseguire tutti i tests del sito
class AllTests extends TestSuite {
    function AllTests() {
        $this->TestSuite('Tutti i tests');
    	
    	// Considera solamente queste cartelle quando si cerca per i files di test
    	$paths = array("core", "restful");
    	foreach($paths as $path){
    		foreach(rglob(ROOT_PATH . "$path/*/*Test.php") as $filename){
				$this->addFile($filename);
			}
    	}
    }
}



?>
