<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */ 
	
  require_once("__inc__.php");
  $pagTitle = "Guide";
	require_once(ROOT_PATH . "header.php");

  $navlist = GuideManager::getPublishedNavList();
  if($navlist == null){
    AlertMessage::Show('Errore: nessuna guida trovata', AlertMessage::WARN);
  }else{
    echo $navlist;
  }

	require_once(ROOT_PATH . "footer.php");
?>