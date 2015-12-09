<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */ 
 
require_once("__inc__.php");
require_once(ROOT_PATH . "core/3rdparty/simpletest/autorun.php");
 
class PaginationTest extends UnitTestCase {
  
  function testPaginationView(){
  	// 10 elementi, 10 per pagina (una sola pagina, quindi paginatore e' vuoto)
    $p = new Pagination(10, 10, 1);
    $view = new ViewBuilder("pagination/default.html", array('current_page' => 1,
                   											 'pages' => array(array('page' => 1, 'link' => '1')))
    						);
    $this->assertTrue("" == $p->getNavigator("default.html", "#PAGE#"));    

  	// 11 elementi, 10 per pagina (pagina 1)
    $p = new Pagination(11, 10, 1);
    $view = new ViewBuilder("pagination/default.html", array('current_page' => 1,
                   											 'pages' => array(array('page' => 1, 'link' => '1'),
                   											 				  array('page' => 2, 'link' => '2')))
    						);
    $this->assertTrue($view->render() == $p->getNavigator("default.html", "#PAGE#"));

    // 11 elementi, 10 per pagina (pagina 2) 
    $p = new Pagination(11, 10, 2);
    $view = new ViewBuilder("pagination/default.html", array('current_page' => 2,
                   											 'pages' => array(array('page' => 1, 'link' => '1'),
                   											 				  array('page' => 2, 'link' => '2')))
    						);
    $this->assertTrue($view->render() == $p->getNavigator("default.html", "#PAGE#"));
  }
}
?>