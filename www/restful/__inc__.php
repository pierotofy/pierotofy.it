<?php 
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */ 
 
	// Include il livello precedente
	$_dirRecursiveCount = isset($_dirRecursiveCount) ? $_dirRecursiveCount + 1 : 0;
	require(dirname(__FILE__) . "/../__inc__.php");
?>