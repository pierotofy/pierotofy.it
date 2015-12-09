<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */ 
 
	require_once("__inc__.php");

	validate_num($_GET['id']);
	validate_num($_GET['forum_id']);
	validate_num($_GET['p']);

	$forum_info = Forum::GetForumInfo($_GET['forum_id']);
	$topic = new Topic($_GET['id']);
	$pagTitle = $topic["argument_title"] . " - " . $topic['subject'];
	$backUrl = "../";

	if ($topic['argument'] != $_GET['forum_id']) ndie("forum_id != id");
	
	require_once(ROOT_PATH . "header.php");

	if (!Forum::IsAccessGrantedTo($forum_info, $currentUser)){
		AlertMessage::Show("Non hai i permessi per visualizzare questo forum.", AlertMessage::WARN);
		ndie();
	}

	$limit = DB::GetLimit($_GET['p'], Forum::POSTS_PER_PAGE);

	$q = exequery(DB::SelectCalcFoundRows(ForumPost::SELECT_SQL) . "
					WHERE (fp.type = ".Forum::TYPE_POST." AND root_topic = $topic[id]) OR (fp.type = ".Forum::TYPE_TOPIC." AND fp.id = $topic[id])
					ORDER BY fp.id
					LIMIT $limit");
	$posts_count = DB::GetCalcFoundRows();
?>
<div id="forum-thread">

<?php 

if ($topic->isPoll()){
	$poll_data = $topic->getPollData();
?>
<div class="poll">
	<b><?php echo $topic['subject']; ?></b></br></br>
<?php
	if (!$poll_data['user_has_voted']){
		echo $topic->renderPollForm();
	}else{
		echo $topic->renderPollResults();
	}
?>
</div>
<?php 
} // end topic->isPoll()
?>


<?php

while($values = mysqli_fetch_array($q, MYSQLI_ASSOC)){
	$post = new ForumPost($values);
	echo $post->render("forum/post.html");
}

?>

</div> <!-- /forum-thread -->

<div style="text-align: right;">
	<input type="button" value="Rispondi" id="btn-forum-reply" />
</div>

<div class="center">
<?php
	    $formBuilder = new FormBuilder("frm-forum-reply", "/restful/forum/reply.php");
	    $fields = array();
	    $fields[] = array(
	        "id" => "message",
	        "type" => "textarea",
	        "validation" => "required,Devi scrivere un messaggio"
	    );

	    $formBuilder->addValue("topic_id", $topic["id"]);
	    $formBuilder->addFields($fields);
	    $formBuilder->setCloseable(true);
	    $formBuilder->setDefaultSubmit("Rispondi");
	    $formBuilder->setVisible(false);
	    $formBuilder->addWidget(new BbButtonWidget($formBuilder->getDOMId("message"), "code|quote|g|c|s"));
	    $formBuilder->addWidget(new SmilesWidget($formBuilder->getDOMId("message")));
	    
	    echo $formBuilder->render();
?>
</div>

<script>
"use strict";
$("#btn-forum-reply").click(function(e){
	if (!$(this).hasClass("disabled")){
		// Se l'utente e' loggato mostra il form per rispondere, altrimenti il pannello di login
		if (CurrentUser.isLogged){
			FormBuilder.Reset("frm-forum-reply");
			Forum.ShowReplyForm();
		}else{
			$("#login-panel").show();
			e.stopPropagation(); // Se non fermiamo la catena, il pannello di login verra' chiuso automaticamente
		}
	}else{
		alert("Questo topic e' chiuso!"); // TODO: migliore finestra di dialogo
	}
});

FormBuilder.On("frm-forum-reply", "Submit", function(e){
	if (e.params.success){
		$("#forum-thread").append(e.params.data.post_html);
		FormBuilder.Close("frm-forum-reply");
	}
});

FormBuilder.On("frm-forum-reply", "Closed", function(){
	$("#btn-forum-reply").show();	
	FormBuilder.Reset("frm-forum-reply");
});

var Forum = {
	Edit: function(post_id){
		var $post = $('#forum-post-' + post_id);
		var $user_actions = $post.find('div.user-actions');
		var $ajax_load = $post.find('div.user-actions .ajax-load');

		InlineEditor.Edit('#forum-post-' + post_id + ' div.message', '/restful/forum/edit_post.php?id=' + post_id, {
		    type : 'textarea',
		    load : '/restful/forum/get_post_info.php?id=' + post_id,
		    loadDataType : 'json',
		    loadCallback: function(data){
		    	return Text.HtmlEntitiesDecode(data.message);
		    },
		    loading : function(){
		    	$ajax_load.show();
		    },
		    loaded : function(){
				$ajax_load.hide();
		    },
		    success : function(){
		    	prettyPrint();
		    	$post.find(".last-modified span i").html("Appena modificato da <b><?php echo $currentUser['username']; ?></b>");
		    },
		    always : function(){
		    	$ajax_load.hide();
		    }
		 });
	},

	Quote: function(post_id){
		<?php if ($topic['locked']){ ?>
			alert("Questo topic e' chiuso!"); // TODO: migliore finestra di dialogo
			return;
		<?php } ?>
		
		if (CurrentUser.isLogged){
			var $post = $('#forum-post-' + post_id);
			var $ajax_load = $post.find('div.user-actions .ajax-load');
			$ajax_load.show();

			$.ajax({
                type: "GET",
                url: '/restful/forum/get_post_info.php?id=' + post_id,
                timeout: 10000,
                dataType: 'json'
            }).done(function(data){
            	var $message = FormBuilder.GetField("frm-forum-reply", "message");
				var old_content = $message.val();
				var new_content = ["[quote][i]Postato originariamente da [b]" + data.username + "[/b]:[/i]",
									Text.HtmlEntitiesDecode(data.message),
									"[/quote]",
									""].join("\n");
				$message.val(old_content + new_content);
				Forum.ShowReplyForm();
          	}).fail(function(){
          		alert("E' successo un errore. Riprova tra un attimo."); // TODO: dialog migliore
            }).always(function(){
    			$ajax_load.hide();      			
        	});
		}else{
			// Hack per ritardare la visualizzazione del pannello
			// siccome non abbiamo accesso a stopPropagation
			// il pannello verrebbe automaticamente chiuso
			setTimeout(function(){ $("#login-panel").show() }, 0);

			// TODO: mettere questo codice in una locazione centrale?
		}
	},

	ShowReplyForm: function(){
		$("#frm-forum-reply").show();	
		$("#btn-forum-reply").hide();

		FormBuilder.GetField("frm-forum-reply", "message").focusToEnd();

		$("body").scrollTo("#frm-forum-reply", {duration: 500});
	}
};	

$(function(){
<?php if ($topic['locked']){ ?>
	// Se il topic e' bloccato, non permettere agli utenti di rispondere e quotare
	$(".btn-quote, #btn-forum-reply").addClass("disabled");
<?php } ?>
});
</script>

<?php
	$pag = new Pagination($posts_count, Forum::POSTS_PER_PAGE, $_GET['p']);
	echo $pag->getNavigator("default.html", $topic->getUrl("#PAGE#"));
?>

<?php
	require_once(ROOT_PATH . "footer.php");
?>