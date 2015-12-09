<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */ 
 
	$pagTitle = "Messaggi";
	
    require_once("__inc__.php");
	require_once(ROOT_PATH . "header.php");

?>

  
<div id="messages" class="center">
    <?php 
        if($currentUser->isLogged()){?>
            <div id="message-top-buttons-container" style="text-align: left; margin-bottom: 0.5em;">
                
                <a id="btn-trash-messages" style="float: right;" class="btn disabled icon icon-trash_can" href="javascript:Messages.deleteChecked();"><span class="hide-phone">Cestina<span class="hide-tablet"> messaggi</span></span></a>
                <a style="float: right; margin-right: 0.5em;" class="btn icon icon-sheet" href="javascript:Messages.write();"><span class="hide-phone">Nuovo<span class="hide-tablet"> messaggio</span></span></a>


                <!-- naviga cartelle -->
                <div class="hide-desktop">
                    <div class="absolute-container">
                        <ul id="folders-list" class="drop-down-list down" style="width: 200px;">
                            <li data-hide="folders-list" onclick="javascript:Messages.viewFolder('inbox',1);">Posta in arrivo</li>
                            <li data-hide="folders-list" onclick="javascript:Messages.viewFolder('sent',1);">Posta inviata</li>
                            <li data-hide="folders-list" onclick="javascript:Messages.viewFolder('trash',1);">Cestino</li>
                        </ul>
                        <input style="margin-top: 0;" type="button" id="btn-view-folders" value="Cartelle" data-toggle="folders-list" />
                    </div>
                </div>

                <div class="hide-phone hide-tablet">
                    <input style="margin-top: 0;" type="button" value="Posta in arrivo" onclick="javascript:Messages.viewFolder('inbox',1);">
                    <input style="margin-top: 0;" type="button" value="Posta inviata" onclick="javascript:Messages.viewFolder('sent',1);">
                    <input style="margin-top: 0;" type="button" value="Cestino" onclick="javascript:Messages.viewFolder('trash',1);">
                </div>

                <!-- /naviga cartelle -->
            </div>

            <div id="messages-container" style="text-align: left;"> 
                <ul class="nav-list">
                </ul>
            </div>

            <div class="center">
                <?php 
                    $formBuilder = new FormBuilder("message-write", "/restful/user/panels/messages/send.php");
                    $fields[] = array(
                        "id" => "to",
                        "type" => "textinput",
                        "label" => "A:",
                        "validation" => "required,Specifica a chi inviare il messaggio"
                    );
                    $fields[] = array(
                        "id" => "subject",
                        "type" => "textinput",
                        "label" => "Oggetto:",
                        "validation" => "required, Specifica l'oggetto"
                    );

                    // Aggiungi multiplo e importante solo se l'utente e' admin
                    if ($currentUser->isAdmin()){
                        $fields[] = array(
                            "id" => "multiple",
                            "type" => "checkbox",
                            "label" => "Invia a tutti i membri:"
                        );
                        $fields[] = array(
                            "id" => "important",
                            "type" => "checkbox",
                            "label" => "Importante:",
                            "value" => true
                        );
                    }

                    $fields[] = array(
                        "id" => "message",
                        "type" => "textarea",
                        "validation" => "required,Devi scrivere un messaggio"
                    );

                    $formBuilder->addFields($fields);
                    $formBuilder->setCloseable(true);
                    $formBuilder->setDefaultSubmit("Invia");
                    $formBuilder->setVisible(false);
                    $formBuilder->addWidget(new BbButtonWidget($formBuilder->getDOMId("message"), "code|quote|g|c|s"));
                    $formBuilder->addWidget(new SmilesWidget($formBuilder->getDOMId("message")));
                    
                    echo $formBuilder->render();

                ?>
            </div>

<script language='javascript'>
"use strict";
var Messages = (function(){
    var p = {
        order : "date_desc",
        folder : "",
        folder_name : "",
        important : false,
        page : 1,
        sending : false,
        
        date_asc : false,
        subject_asc : false,
        from_asc : false,

        last_message : null // Riferimento all'ultimo messaggio visualizzato
    };


    // @return una lista di ID corrispondenti ai messaggi selezionati
    function getCheckedMessages(){
        var result = [];
        $('div#messages-container div.checkbox[data-value="checked"]').each(function(){
            result.push($(this).parent().data('id'));
        });
        return result;
    }

    function loadFolder(){
        LoadingIcon.Show();
        $.ajax({
            type: "POST",
            url: "/restful/user/panels/messages/get_list.php",
            data: {
                "folder" : p.folder,
                "order" : p.order,
                "p" : p.page
                },
            timeout: 10000,
            success: function(json){
                var $container = $("div#messages-container");
                $container.empty();
                var $message_list = $("<ul class='nav-list'></ul>");
                $message_list.appendTo($container);

                for(var i = 0; i < json['value']['messages'].length; i++){
                    var message = json['value']['messages'][i];
                    var icon = "icon-newspaper";
                    if (message['important']) icon = "icon-warning_alt";

                    var del_res_checkbox = '<div class="checkbox white right"></div>';

                    // Lasciamo eliminare solamente per la posta in arrivo
                    if (p.folder != 'inbox') del_res_checkbox = '';

                    // Restore non e' supportato al momento
                    if (message['delete_restore'] == "R") del_res_checkbox = '';

                    var messageHtml = ['<li data-id="' + message['id'] + '">',
                        del_res_checkbox,
                        '<a class="nowrap icon ' + icon + ' ' + (!message['viewed'] ? 'new' : '') + '"', 
                        '    href="javascript:Messages.viewMessage(' + message['id'] + ')">',
                        message['subject'] + '<br>',
                        '<div class="subtitle">' + message['date'] + ' - ' + message['to_from'] + '</div>',
                        '</a>',
                    '</li>'].join("\n");

                    $(messageHtml).appendTo($message_list);
                }

                $container.append(json['value']['pagination']);

                AutoFuncs.ApplyTo($container); // Assicurati che le checkbox funzionino
                $container.find("div.checkbox").click(function(){
                    var $btn = $("#btn-trash-messages");
                    getCheckedMessages().length > 0 ? $btn.removeClass("disabled") : $btn.addClass("disabled");         
                });
                
                LoadingIcon.Hide();

                Header.SetTitle(p.folder_name);
            },
            error: function(){ LoadingIcon.Hide(); },
            dataType: 'json'
        });
    }

    function getViewHTML(message){
      var m = message; // Piu' veloce da scrivere
      var h = '<div class="bordered">';

      h += "<div style='float: right' class='small'>" + m['date'] + "</div>";
      h += "<b>Oggetto:</b> " + m['subject'] + "<br/>";
      h += "<b>" + m['from_or_to'] + ':</b> <a href="javascript:void(0);">' + m['from_to_user'] + "</a><br/><br/>";
      
      h += m['message_html'] + '<br/>';

      if(m['reply']){
        h += ['<div align="right"><input type="button" value="Rispondi" ',
              'onclick="javascript:Messages.write(true);"></div>'].join("\n");
      }

      h += '</div>';

      return h;
    }

    return {
    
        write : function(reply){
            FormBuilder.Reset("message-write");

            $("div#messages-container").hide();
            $("#message-top-buttons-container").hide();
            $("input#btn-write-message").hide();
            $("form#message-write").show();

            // Popula i campi in automatico se stiamo rispondendo
            if (reply !== undefined && p.last_message !== null){
                var subject = Text.HtmlEntitiesDecode(p.last_message['subject']);
                if (subject.indexOf("Re:") != 0) subject = "Re: " + subject;

                $("form#message-write input[name='to']").val(p.last_message['from_to_user']);
                $("form#message-write input[name='subject']").val(subject);

                var lines = Text.HtmlEntitiesDecode(p.last_message['message_plain']).split("\n");
                lines.unshift("");
                var quotation = lines.join("\n>> ");
                quotation = "\n\nIl " + p.last_message['discursive_date'] + " " + p.last_message['from_to_user'] + " ha scritto:" + quotation;

                $("form#message-write textarea[name='message']").val(quotation).focus();
            }
        },

        deleteChecked : function(){
            if ($("#btn-trash-messages").hasClass('disabled')) return;

            if (window.confirm("Spostare questi messaggi nel cestino?")){ // TODO: finestra di dialogo migliore
                LoadingIcon.Show();

                // Crea lista di ID
                var id_list = getCheckedMessages();

                $.ajax({
                    type: "POST",
                    url: "/restful/user/panels/messages/delete.php",
                    data: {
                        "id_list" : id_list
                    },
                    timeout: 10000,
                    success: function(data){
                        if(data.success){
                            for(var i in id_list) $('div#messages-container li[data-id="' + id_list[i] + '"]').remove();
                        }else{
                            alert("Errore: " + data.error); // TODO: migliore finestra di dialogo
                        }
                        loadFolder();
                    },
                    error: function(){ 
                        alert("Errore, messaggio non cancellato."); // TODO: migliore finestra di dialogo
                        LoadingIcon.Hide();
                    },
                    dataType: 'json'
                });
            }
        },
    
        viewMessage : function(id){
            LoadingIcon.Show();
            $.ajax({
                type: "POST",
                url: "/restful/user/panels/messages/view.php",
                data: { "id" : id },
                timeout: 10000,
                success: function(json){
                        p.last_message = json['value'];

                        var html = getViewHTML(p.last_message);

                        $("div#messages-container").empty();
                        $(html).appendTo("div#messages-container");
                        prettyPrint();
                        LoadingIcon.Hide(); 
                    },
                error: function(){ LoadingIcon.Hide(); },
                dataType: 'json'
            }); 
        },

        viewFolder : function(folder, page){
            $("form#message-write").hide();
            $("div#messages-container").show();
            $("#btn-write-message").show();
            p.folder = folder;
            p.page = page;
            if(p.folder == 'inbox') p.folder_name = "Posta in arrivo";
            else if(p.folder == 'sent') p.folder_name = "Posta inviata";
            else p.folder_name = "Cestino";
            loadFolder();
        },

        goToPage : function(page){
            p.page = page;
            loadFolder();
        },

        sort : function(order){
            if (order == "date"){
                p.order = p.date_asc ? "date_desc" : "date_asc";
                p.date_asc = !p.date_asc;
            }else if (order == "subject"){
                p.order = p.subject_asc ? "subject_desc" : "subject_asc";
                p.subject_asc = !p.subject_asc;
            }else if (p.order == "from"){
                p.order = p.from_asc ? "from_desc" : "from_asc";
                p.from_asc = !p.from_asc;
            }
            loadFolder();
        }
    };
})();


    FormBuilder.On("message-write", "Closed", function(e){
        $("#messages-container, #btn-write-message, #message-top-buttons-container").show();
        e.stopPropagation();
    });


    FormBuilder.On("message-write", "Submit", function(e){
        if (e.params.success == true){
            $("#messages-container, #btn-write-message, #message-top-buttons-container").show();
            $("#message-write").hide();
            e.stopPropagation();

            Messages.viewFolder('sent', 1);
            // TODO: notifica l'utente che il messaggio e' stato inviato
        }
    });
    
    $(function(){
        // Autocomplete
        Autocomplete.Bind("div#messages input[name='to']", "/restful/user/search.php", {
            params: {"num_records" : 5}
        });

        // Visualizza la cartella in arrivo
        Messages.viewFolder('inbox', 1);
    });
</script>

    <?php 
        }else{ 
            $error_message = 'Devi effettuare il login per vedere questa pagina!';
            AlertMessage::Show($error_message, AlertMessage::WARN);
        }
    ?>
</div>
    

<?php
	require_once(ROOT_PATH . "footer.php");
?>