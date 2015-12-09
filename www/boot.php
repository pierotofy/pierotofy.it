<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */ 
 
/* Boot file */
session_start();

// Includi la configurazione del sito
include_once("etc/config/include_all.php");

// Forza SSL (a meno che non siamo in debug)
if (!DEBUG){
	if (!isset($_SERVER['HTTPS']) || !$_SERVER['HTTPS']) {
	    $url = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	    header('Location: ' . $url);
	    exit;
	}
}

// Misura tempo se necessario
if (SHOWDEBUGBOX){
	$time = microtime();
	$time = explode(" ", $time);
	$time = $time[1] + $time[0];
	$debug_start_time = $time;
}

// Includi costanti locali
include_once("etc/locale/it/include_all.php");

// Includi le classi PHP e le funzioni
include_once("core/include_all.php");

// Connette il database
$_dbConnector = new _DbConnector();

// Imposta il fuso orario
define('SITE_TIMEZONE', 'Europe/Rome');
putenv("TZ=" . SITE_TIMEZONE);

// Definisce alcune costanti...
define('SITE_TITLE_SUFIX', " - PieroTofy.it");
define('SITE_TITLE_PREFIX', "PieroTofy.it - ");
define('SITE_TITLE', "Programmazione C/C++, Software open source, java, visual basic 6, .net e molto altro ancora"); 
define('SITE_KEYWORDS', "programmi, sorgenti, guide");
define('SITE_DESCRIPTION', "Il portale per eccellenza sulla programmazione.");
define('SITE_VERSION', "Codename Martial Eagle");

// Asserzioni devono sempre terminare
assert_options(ASSERT_BAIL, true);

// Prende l'utente corrente
$currentUser = UserFactory::CreateCurrentUser();

?>