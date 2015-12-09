<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */ 
 
	require_once("__inc__.php");

	validate_num($_GET['id']);
	validate_num($_GET['p']);

	$forum_info = Forum::GetForumInfo($_GET['id']);
	$pagTitle = "Forum " . $forum_info['title'];
	$backUrl = "/p/forum/";

	require_once(ROOT_PATH . "header.php");

	if (!Forum::IsAccessGrantedTo($forum_info, $currentUser)){
		AlertMessage::Show("Non hai i permessi per visualizzare questo forum.", AlertMessage::WARN);
		ndie();
	}
	
	// TODO: cerca topic

	// argument e' l'id del canale del forum (Android, C++, Off-Topic, etc.)
	$limit = DB::GetLimit($_GET['p'], Forum::TOPICS_PER_PAGE);
	$q = exequery(DB::SelectCalcFoundRows(Topic::SELECT_SQL) . "
				WHERE p.argument = $_GET[id] AND p.type = " . Forum::TYPE_TOPIC . " 
				ORDER BY p.show_as DESC, p.last_post_date DESC
				LIMIT $limit");
	$topics_count = DB::GetCalcFoundRows();

	// TODO: aggiungi indice su show_as
?>

<div class="center" style="margin-bottom: 1em;"> <!-- nuovo post -->
	<?php 
	    $formBuilder = new FormBuilder("frm-forum-post", "/restful/forum/newtopic.php");
	    $fields = array();
		$fields[] = array(
	        "id" => "subject",
	        "type" => "textinput",
	        "label" => "Oggetto:",
	        "validation" => "required,Specifica un oggetto per il messaggio"
	    );
	    $fields[] = array(
	        "id" => "poll",
	        "type" => "textarea",
	        "label" => "Sondaggio:<br/><span class='small'>(1 domanda per linea)</span>",
	        "attrs" => "style='height: 6em;'"
	    );
	    $fields[] = array(
	        "id" => "message",
	        "type" => "textarea",
	        "validation" => "required,Devi scrivere un messaggio"
	    );

	    $formBuilder->addValue("forum_id", $_GET['id']);
	    $formBuilder->addFields($fields);
	    $formBuilder->setCloseable(true);
	    $formBuilder->setDefaultSubmit("Invia");
	    $formBuilder->setVisible(false);
	    $formBuilder->addWidget(new BbButtonWidget($formBuilder->getDOMId("message"), "code|quote|g|c|s"));
	    $formBuilder->addWidget(new SmilesWidget($formBuilder->getDOMId("message")));
	    
	    echo $formBuilder->render();
	?>
</div> <!-- fine nuovo post -->

<script>
"use strict";
FormBuilder.On("frm-forum-post", "Closed", function(e){
	$("#view-forum-container").show();
    e.stopPropagation();
});

FormBuilder.On("frm-forum-post", "Submit", function(e){
	if (e.params.success){
		location.href = e.params.data.topic_url;
	}
});
    
function show_new_post_form(poll){
<?php if ($currentUser->isLogged()){ ?>
	// Mostra il form
	$("#frm-forum-post").show();
	var $poll = FormBuilder.GetFieldContainer("frm-forum-post", "poll");

	if (poll === true){
		$poll.show();
	}else{
		$poll.hide();
	}
	$("#view-forum-container").hide();
	FormBuilder.GetField("frm-forum-post", "subject").focus();

<?php }else{ ?>

	// Mostra il menu di login
	$("#login-panel").show();

<?php } ?>
}
</script>

<div id="view-forum-container">

	<div class="btn-container right">
		<a id="btn-new-discussion" class="btn icon icon-sheet" href="javascript:show_new_post_form();"><span class="hide-phone">Nuova discussione</span></a>
		<a id="btn-new-poll" class="btn icon icon-chart" href="javascript:show_new_post_form(true);"><span class="hide-phone">Nuovo sondaggio</span></a>
	</div>

	<div id="forum-discussion-list">
		<ul class="nav-list">
<?php

while($values = mysqli_fetch_array($q, MYSQLI_ASSOC)){
  $topic = new Topic($values);
  $icon = "icon-discussion";
  $color = "";

  switch($values['show_as']){
  	case Forum::IMPORTANT_LOCAL_POST:
  	case Forum::IMPORTANT_PUBLIC_POST:
  		$icon = "icon-star";
		$color = "highlight";
  }

  if ($values['poll']) $icon = "icon-chart";
  if ($values['locked']) $icon = "icon-lock"; 
?>
		<li class="<?php echo $color; ?>">
			<a class="nowrap icon <?php echo $icon; ?>" href="<?php echo $topic->getUrl(); ?>">
			<span class="bubble pull-right" style="margin-left: 0.5em; margin-top: 0.5em;"><?php echo $topic['replies']; ?></span> <?php echo $topic->getName(); ?><br>
			<div class="subtitle"><?php echo $topic['user']; ?> - <?php echo $topic->getFormattedDate(); ?></div>
			</a>
		</li>
<?php
}

?>
		</ul>
	</div> <!-- forum-discussion-list -->
	<?php
		$pag = new Pagination($topics_count, Forum::TOPICS_PER_PAGE, $_GET['p']);
		echo $pag->getNavigator("default.html", "/p/forum/" . $_GET['id'] . "-#PAGE#/");
	?>
</div> <!-- view-forum-container -->


<?php
	require_once(ROOT_PATH . "footer.php");
?>
