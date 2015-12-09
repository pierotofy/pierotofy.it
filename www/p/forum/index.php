<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */ 
 
	$pagTitle = "Forum";
	
	require_once("__inc__.php");
	require_once(ROOT_PATH . "header.php");

?>

<ul class="nav-list">
<?php

/* pierotofy: chiedo scusa per la confusione

 root = nome categoria (Programming, Off-Topic, ecc.)
 title = titolo canale
 subject = descrizione canale forum
*/
$q = exequery("SELECT f.id, f.root, f.title, f.subject, f.private, f.priority FROM forum_arguments f
WHERE root != 'Projects' ORDER BY priority");
$category = "";

while($values = mysqli_fetch_array($q, MYSQLI_ASSOC)){

  // Inserisci i nomi della categoria quando necessario
  if ($values['root'] != $category){
	$category = $values['root'];
  	echo '<li class="nav-title">' . $category . "</li>";
  }

  echo sprintf('<li><a class="nowrap has-children" href="/p/forum/%s/">%s</a></li>', $values['id'], $values['title']);
}

?>
</ul>

<?php
	require_once(ROOT_PATH . "footer.php");
?>