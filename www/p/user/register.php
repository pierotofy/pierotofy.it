<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */ 
 
	$pagTitle = "Registrati";
	
	require_once("__inc__.php");
	require_once(ROOT_PATH . "header.php");

?>

<p class="hide-phone">
	La registrazione su PieroTofy.it ti permette di:
</p>
<ul class="hide-phone normal-list">
	<li>Postare messaggi sul forum</li>
	<li>Scambiare e ricevere messaggi con altri utenti</li>
	<li>Utilizzare il sistema di copy paste per condividere velocemente i tuoi codici con altre persone (da non confondere con la possibilità di poter pubblicare programmi sul sito)</li>
	<li>Aggiungere commenti a programmi, articoli, news</li>
	<li>Accedere all'esclusiva newsletter dedicata alla programmazione</li>
</ul>

<div class="center">


	<?php
		$formBuilder = new FormBuilder("frm-register", "/restful/user/register.php");
        $fields[] = array(
            "id" => "username",
            "type" => "textinput",
            "label" => "Username:",
            "validation" => "required,Devi scegliere un username",
            "send" => false // username non viene inviato in chiaro
        );
        $fields[] = array(
            "id" => "password",
            "type" => "textpassword",
            "label" => "Password:",
            "validation" => "required,Devi specificare una password",
            "send" => false  // password viene offuscata
        );
        $fields[] = array(
            "id" => "hash",
            "type" => "hidden"
        );        
        $fields[] = array(
            "id" => "email",
            "type" => "textinput",
            "label" => "Email:",
            "validation" => array("valid_email,Devi specificare un'email valida",
            					  "required,Devi specificare un'email")
        );
        $fields[] = array(
            "id" => "question",
            "type" => "telinput",
            "label" => "Sette piu' tre?",
            "attrs" => "maxlength='2' size='2' style='width: auto;'",
            "validation" => "required,Devi rispondere alla domanda"
        );
        $formBuilder->addFields($fields);
        $formBuilder->setDefaultSubmit("Registrati");
        
        echo $formBuilder->render();
	?>
</div>
<p>
	<b>Nota: </b> come utente normale <u>non</u> potrai pubblicare programmi sul sito. Per pubblicare programmi sul sito consulta la sezione <a href="javascript:void(0);">Join Us</a><br><br>
</p>
<script>
"use strict";
// Prima dell'invio del form, offusca username e password
FormBuilder.On("frm-register", "PreSubmit", function(e){
	var username = $("form[id='frm-register'] input[name='username']").val();
	var password = $("form[id='frm-register'] input[name='password']").val();

    var hash = Login.encrypt(username, password);

    $("form[id='frm-register'] input[name='hash']").val(hash);
    e.stopPropagation();
});

FormBuilder.On("frm-register", "Submit", function(e){
	if (e.params.success) location.href = "/";
});
</script>

<?php
	require_once(ROOT_PATH . "footer.php");
?>