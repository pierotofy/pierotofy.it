<?php
	include_once("enable.php");

	echo "Aggiorno gli avatars... ";
	exequery("UPDATE users SET avatar = CONCAT(id, \".png\") WHERE avatar IS NOT NULL");
	echo "Fatto!<br/>";
?>