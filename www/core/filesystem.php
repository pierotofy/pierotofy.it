<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */ 

	/* In questo file ci sono gli helpers the si occupano
	 * di fare operazioni con il file system */

	// Glob ricorsivo
	function rglob($pattern = '*', $flags = 0, $path = ''){
	    $paths = glob($path . '*', GLOB_MARK|GLOB_ONLYDIR|GLOB_NOSORT);
	    $files = glob($path . $pattern, $flags);
	    foreach ($paths as $path) { 
	    	$files = array_merge($files, rglob($pattern, $flags, $path)); 
	    }
	    return $files;
	}
?>