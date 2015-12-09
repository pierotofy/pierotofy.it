<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */
	
    require_once("__inc__.php");

    validate_num($_GET['guide_id']);
    validate_num($_GET['chapter_id']);
?>

<?php

if(isset($_GET['guide_id']) && isset($_GET['chapter_id'])){
  // Creo un istanza di Guide e vedo se la guida è presente nel DB
  $guide = new Guide($_GET['guide_id']);
  if($guide->exists()){
    $chapter = $guide->getChapter($_GET['chapter_id']);
    if($chapter->exists()){
      $backUrl = $guide->getLink();
      $pagTitle = "$guide[name] - $chapter[name]";
      require_once(ROOT_PATH . "header.php");
      
      echo "<div id='chapters-navigator' class='center'>";
      $back_next_button = "<div style='overflow: auto;'>";

      $prev_chapter = $chapter->getPrevious();
      $next_chapter = $chapter->getNext();

      if($prev_chapter != NULL){
        $back_next_button .= '<div style="float:left;">
            <button class="btn" onclick="location.href=\''.$prev_chapter->getLink().'\';">&laquo;<span class="hide-phone"> Precedente</span></button>
          </div>';
      }
      
      if($next_chapter != NULL){
        $back_next_button .= '<div style="float:right;">
            <button class="btn" onclick="location.href=\''.$next_chapter->getLink().'\';">&raquo;<span class="hide-phone"> Prossimo</span></button>
          </div>';
      }

      $back_next_button .= "</div>";
      $author = $chapter->getAuthor();
      
      echo $back_next_button;
      echo "<div id='chapter-context' class='left' style='margin: 1em 0;'>".$chapter->getContent()."</div>";
      
      if($author == null) echo "<div>A cura di: Membro non piu' appartenente alla Community </div>";
      else echo "<div>A cura di: <a href='".$author->getProfileUrl()."'>$author[username]</a></div>";
      
      echo $back_next_button;
      echo "</div>";
    }else{
      AlertMessage::Show('Capitolo selezionato insesistente!', AlertMessage::WARN);
    }
  }else{
    require_once(ROOT_PATH . "header.php");
    AlertMessage::Show('Guida selezionata insesistente!', AlertMessage::WARN);
  } 
}else{
  require_once(ROOT_PATH . "header.php");
  AlertMessage::Show('Nessuna guida/capitolo selezionato!', AlertMessage::WARN);
}
?>

<?php
	require_once(ROOT_PATH . "footer.php");
?>
