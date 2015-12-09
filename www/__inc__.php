<?php 
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */ 
 
	// Root include file
	// Questo file viene incluso da tutte le directory di livello superiore che lo richiedono
	$_dirRecursiveCount = isset($_dirRecursiveCount) ? $_dirRecursiveCount + 1 : 0;
	define("ROOT_PATH", str_repeat("../", $_dirRecursiveCount));
	require_once("boot.php");

?>