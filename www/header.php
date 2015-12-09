<?php 
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */ 

// Se una sezione non e' impostata, setta come lo stesso del titolo
if (!isset($pagSection)) $pagSection = isset($pagTitle) ? $pagTitle : "";

// Se un titolo non e' impostato, setta default
if (!isset($pagTitle)){
	$pagTitle = SITE_TITLE;
}else{
	$pagTitle = $pagTitle . SITE_TITLE_SUFIX;
}

?>
<!DOCTYPE html> 
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<title><?php echo $pagTitle; ?></title> 

	<script src="https://code.jquery.com/jquery-2.0.3.min.js"></script> 
	<script src="/js/jquery.plugins.js"></script> 
	
	<script src="/js/site.js"></script>
	<script src="/js/rsv-2.5.2.js"></script>
	<script src="/js/prettify.js"></script>
	<script>
	"use strict";
	var CurrentUser = {
		isLogged: <?php echo Js::BoolString($currentUser->isLogged()); ?>
	};
	</script>

	<link rel="stylesheet" href="/css/mfglabs_iconset.css">
	<link rel="stylesheet" href="/css/prettyprint.css" />
	<link rel="stylesheet" href="/css/style.css" />
</head>
<body> 
<div id="container">
	<div id="nav-panel">
		<div id="nav-panel-container">
			<ul>
				<li class="left">
					<?php if (isset($backUrl)){ ?>
						<a href="<?php echo $backUrl; ?>" class="btn mini icon icon-arrow_left"><span class="hide-phone hide-tablet">Indietro</span></a>
					<?php } ?>
					<a id="btn-nav-menu" href="javascript:void(0);" class="btn mini icon icon-list" data-toggle="menu-panel" data-hide="login-panel"><span class="hide-phone hide-tablet">Menu</span></a>
				</li>
				<li><h1 id="pag-section"><?php echo $pagSection; ?></h1><img id="title-bar-loading"></li>
				<li class="right">
<?php if (!$currentUser->isLogged()){ ?>
					<a id="btn-login-panel" href="javascript:void(0);" class="btn mini icon icon-lock" data-toggle="login-panel" data-hide="menu-panel"><span class="hide-phone">Login</span></a>
<?php }else{ ?>
					<!--
					<a href="javascript:void(0);" class="btn mini" data-hide="profile-balloon">5</a>
					-->
					<div class="balloon-container">
						<a href="javascript:void(0);" class="btn mini icon icon-user" data-toggle="profile-balloon" data-hide="notifications-balloon"><span class="hide-phone hide-tablet"><?php echo $currentUser["username"]; ?></span></a>
						<div id="profile-balloon" class="balloon-panel toggle-panel">
							<img src="<?php echo $currentUser->getAvatarUrl(); ?>" class="avatar medium" />
							<div class="profile-balloon-section">
								<span class="small">
									Ultimo accesso <b><?php echo date("H:i d/m",$currentUser["previous_login_timestamp"]); ?></b> da <b><?php echo $currentUser["last_login_ip"]; ?></b>
								</span>
							</div>
							<div class="profile-balloon-section last">
								<input type="button" value="Posta in arrivo" id="btn-view-inbox" onclick="location.href='/p/user/panels/messages/';" class="fill" />
							</div>

							<img id="logout-ajax-load" src="/images/ajax-loading.gif" alt="Loading" class="ajax-load" />
							<a href="javascript:void(0);" id="btn-logout" class="btn attention">Logout</a>
						</div>
					</div>
					<?php $currentUser->isMember(); ?>
<?php } ?>	
				</li>
			</ul>
		</div> <!-- /container -->
    </div><!-- /nav panel -->

    <div id="menu-panel" class="side-panel toggle-panel left">
		<ul class="nav-list">
			<li><a href="/">Home</a></li>
			<li><a href="/p/forum/">Forum</a></li>
            <?php echo GuideManager::getPublishedNavList(); ?>
			<li class="has-children">Guide</li>
			<!--
			<ul class="nav-list">
				<ul class="nav-list">
					<li>Programmi</li>
					<li>Articoli</li>
					<li>Canale forum</li>
					<li>Progetti</li>
				</ul>
				<li>C++</li>
				<li>Java</li>
				<li>Visual Basic .NET</li>
				<li>Ruby</li>
			</ul>
			<li>Sorgenti</li>
			<ul class="nav-list">
				<li>C++</li>
				<li>Java</li>
				<li>Visual Basic .NET</li>
				<li>Ruby</li>
			</ul>
			<li>Programmi</li> -->
			<li><a href="/p/about/about.php">About</a></li>
		</ul>
    </div>

<?php if (!$currentUser->isLogged()){ // non loggato ?>
    <div id="login-panel" class="side-panel toggle-panel right">
        <form name="frm-login" id="frm-login">
      		
      		<div class="formitem labeled">
	      		<label for="name">Username:</label>
	       		<input type="text" name="username" id="name" value="">
	       	</div>

      		<div class="formitem labeled">
	            <label for="password">Password:</label>
	            <input type="password" name="password" id="password" value="">
	        </div>

            <div id="login-status" class="panel-text-error"></div>

            <div id="login-buttons">
            	<div class="formitem">
	            	<input type="button" id="btn-login" value="Login" />
	            </div>
	            <p style="text-align: center;">Oppure</p>
            	<div class="formitem">
	            	<input type="button" id="btn-register" value="Registrati" />
	            </div>
            	<div class="formitem">
	            	<input type="button" id="btn-forgot-pwd" value="Dimenticato la password" />
	            </div>
	        </div>
	        <div class="center">
	        	<img id="login-ajax-load" src="/images/ajax-loading-panel.gif" alt="Loading" class="ajax-load" />
        	</div>
        </form>

        <form name="frm-forgot-pwd" id="frm-forgot-pwd" style="display: none;">

      		<div class="formitem labeled">
	      		<label for="name">Username:</label>
	       		<input type="text" name="username" id="name" value="">
	       	</div>

        	<div id="retrieve-pwd-status"></div>

      		<div id="retrieve-pwd-buttons">
	        	<div class="formitem">
	            	<input type="button" id="btn-retrieve-pwd" value="Recupera la password" />
	            </div>
	            <p style="text-align: center;" id="retrieve-pwd-otherwise">Oppure</p>
	        	<div class="formitem">
	            	<input type="button" id="btn-retrieve-pwd-back" value="Torna indietro" />
	            </div>
	        </div>
	        <div class="center">
	        	<img id="retrieve-pwd-ajax-load" src="/images/ajax-loading-panel.gif" alt="Loading" class="ajax-load" />
        	</div>
        </form>
	</div><!-- /login-panel -->

<script>
"use strict";
$("#frm-forgot-pwd input[name='username']").keypress(function(event){
	if ( event.which == 13 ) {
		$("#btn-retrieve-pwd").click();
	}else{
		$("#retrieve-pwd-status").hide();
	}
});

$("#btn-retrieve-pwd").click(function(){
	$("#retrieve-pwd-status").hide();

	Login.retrievePassword($("#frm-forgot-pwd input[name='username']").val(), 
		{
			onLoading: function(){
				$("#retrieve-pwd-ajax-load").show();
				$("#retrieve-pwd-buttons").hide();
			},
			onSuccess: function(data){
				$("#retrieve-pwd-status").show().html("Fatto! Controlla l'indirizzo e-mail associato con il tuo account.").removeClass("panel-text-error").addClass("panel-text-success");
				$("#btn-retrieve-pwd, #retrieve-pwd-otherwise, #retrieve-pwd-ajax-load").hide();
				$("#retrieve-pwd-buttons").show();
			},
			onFailure: function(data){
				$("#retrieve-pwd-status").show().html(data.error).addClass("panel-text-error").removeClass("panel-text-success");
				$("#retrieve-pwd-ajax-load").hide();
				$("#retrieve-pwd-buttons").show();
			}
		});
});

$("#btn-retrieve-pwd-back").click(function(){
	$("#frm-login").show();
	$("#frm-forgot-pwd").hide();
});

$("#btn-forgot-pwd").click(function(){
	$("#frm-login").hide();
	$("#frm-forgot-pwd, #retrieve-pwd-buttons, #btn-retrieve-pwd, #retrieve-pwd-otherwise").show();
	$("#retrieve-pwd-status").hide();
	$("#frm-forgot-pwd input[name='username']").val($("#frm-login input[name='username']").val());
});

$("#btn-login-panel").click(function(){
	// L'elemento non e' ancora visibile, esegui dopo il repaint
	setTimeout(function(){ $("form[name='frm-login'] input[name='username']").focus(); }, 0);

	$("#frm-login").show();
	$("#frm-forgot-pwd, #login-status").hide();
});

$("#btn-login").click(function(){
	$("#login-status").hide();
	Login.doLogin($("form[name='frm-login'] input[name='username']").val(), $("form[name='frm-login'] input[name='password']").val(), 
		{
			usecookie: true, // use cookie
			onLoading: function(){
				$('#login-buttons').hide();
				$('#login-ajax-load').show();
			},
			onSuccess: function(){
				location.reload(true);
			},
			onFailure: function(data){
				if (data.banned_message){
					$("form[name='frm-login'] input[name='username']").val("");
					$("form[name='frm-login'] input[name='password']").val("");
					Dialog.Show({text: data.banned_message, type: "warning"});
				}else{
					$("#login-status").show().addClass('error').html(data.error);
				}

				$('#login-buttons').show();
				$('#login-ajax-load').hide();
			}
		}
	);
});

$("form[name='frm-login'] input[name='username'], form[name='frm-login'] input[name='password']").keypress(function(event){
	if ( event.which == 13 ) {
		$("#btn-login").click();
	}else{
		$("#login-status").hide();
	}
});

$("#btn-register").click(function(){
	location.href = "/p/user/register.php";
});
</script>

<?php 
	}else{ // loggato
?>

<script>
$("#btn-logout").click(function(){
	Login.doLogout({
		onLoading: function(){
			$('#logout-ajax-load').show();
		},
		onSuccess: function(){
			location.reload(true);
		},
		onFailure: function(data){
			Dialog.Show({text: data.error, type: "warning"});

			$('#logout-ajax-load').hide();
		}
	});
});
</script>

<?php } ?>
	<div id="content">
		







