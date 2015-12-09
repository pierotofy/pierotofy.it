<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */ 
	
  require_once("__inc__.php");

  validate_num($_GET['guide_id']);

  // Inizializza
  if(isset($_GET['guide_id'])){
    $guide = new Guide($_GET['guide_id']);
  }else{
    $guide = null;
  }

  $pagTitle = $guide['name'];
  $backUrl = "/p/guide/";
	require_once(ROOT_PATH . "header.php");

?>

<?php
  if($guide){
    // Creo un istanza di Guide e vedo se la guida è presente nel DB
    $guide = new Guide($_GET['guide_id']);

    if($guide->exists()){
      echo "<div class='center'><h1>$guide[descr]</h1></div>";
      
      echo "<ul class='nav-list' style='margin-top: 1em;'>";
      $chapters = $guide->getAllChapters();
      foreach($chapters as $chapter){
        echo "<li><a href='".$chapter->getLink()."'>$chapter[chapter]. $chapter[name]</a></li>";
      }
      echo "</ul>";  

    }else{
      AlertMessage::Show('Guida selezionata inesistente!', AlertMessage::WARN);
    }
  }else{
    AlertMessage::Show('Nessuna guida selezionata!', AlertMessage::WARN);   
  }

	require_once(ROOT_PATH . "footer.php");
?>