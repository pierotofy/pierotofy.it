<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */ 

/** Classe per la gestione delle guide*/

class GuideManager{

  // @return la lista di guide pubblicate
  public static function getPublished(){
    $query = exequery(Guide::SELECT_SQL . " WHERE published = 1");
    
  	$array = array();
  	while($g = mysqli_fetch_array($query, MYSQLI_ASSOC)){
  	  $array[] = new Guide($g);
    }
    
    return $array;
  }

  // @return la lista di guide pubblicate in HTML
  public static function getPublishedNavList(){
    $guides = self::getPublished();
    if(count($guides) == 0) return null;
    
    $navlist = "<ul class='nav-list'>";
    foreach($guides as $g)
      $navlist .= "<li><a href='".$g->getLink()."'>$g[name]</a></li>";
    $navlist .= "</ul>";
    return $navlist;
  }
}
?>