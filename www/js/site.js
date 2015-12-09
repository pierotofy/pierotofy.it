/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */ 
"use strict";

var Login = {
	encrypt: function(username, password){
		var c = 0;
		var crypted = "";

		var salt = this.from10toradix(Math.floor(Math.random()*61439+4096),16);
		crypted += salt;

		var userlength = this.from10toradix(username.length,16);
		if (username.length <= 15) userlength = '0' + userlength;
		crypted += userlength;

		for (c=0; c<username.length; c++) crypted += this.from10toradix(username.charCodeAt(c) + 1,16);
		for (c=0; c<password.length; c++) crypted += this.from10toradix(password.charCodeAt(c) + 1,16);

		return crypted;
	},

	from10toradix: function(value, radix){
		function initArray() {
			this.length = arguments.length;
			for (var i = 0; i < this.length; i++)
				this[i] = arguments[i];
		}

		var retval = '';
		var ConvArray = new initArray(0,1,2,3,4,5,6,7,8,9,'a','b','c','d','e','f');
		var intnum;
		var tmpnum;
		var i = 0;

		intnum = parseInt(value,10);
		if (isNaN(intnum)){
			retval = 'NaN';
		}else{
			while (intnum > 0.9){
				i++;
				tmpnum = intnum;
				// cancatinate return string with new digit:
				retval = ConvArray[tmpnum % radix] + retval;  
				intnum = Math.floor(tmpnum / radix);
				if (i > 100){
					// break infinite loops
					retval = 'NaN';
					break;
				}
			}
		}
		return retval;
	},

	doLogin: function(username, password, params){
		var hash = this.encrypt(username, password);

		if (params.onLoading !== undefined) params.onLoading();

		$.ajax({
			type: "POST",
			url: "/restful/user/login.php",
			data: {"hash" : hash,
					"usecookie" : params.usecookie !== undefined ? params.usecookie : false
			},
			timeout: 10000,
			success: function(data) {
				if (data.success){
					if (params.onSuccess !== undefined) params.onSuccess(data);
				}else{
					if (params.onFailure !== undefined) params.onFailure(data);
				}
			},
			error: function(jqXHR, textStatus, errorThrown){
				if (params.onFailure !== undefined) params.onFailure({error: textStatus});
			},
			dataType: 'json'
		}); 
	},

	retrievePassword: function(username, params){
		if (username != ""){
			if (params.onLoading !== undefined) params.onLoading();

			$.ajax({
				type: "POST",
				url: "/restful/user/retrieve_pwd.php",
				data: { "user"  : username },
				timeout: 10000,
				success: function(data) {
					if (data.success){
						if (params.onSuccess !== undefined) params.onSuccess(data);
					}else{
						if (params.onFailure !== undefined) params.onFailure(data);
					}
				},
				error: function(jqXHR, textStatus, errorThrown){
					if (params.onFailure !== undefined) params.onFailure({error: textStatus});
				},
				dataType: 'json'
			}); 
		}
	},

	doLogout: function(params){
		if (params.onLoading !== undefined) params.onLoading();

		$.ajax({
			type: "POST",
			url: "/restful/user/logout.php",
			timeout: 10000,
			success: function(data) {
				if (data.success){
					if (params.onSuccess !== undefined) params.onSuccess(data);
				}else{
					if (params.onFailure !== undefined) params.onFailure(data);
				}
			},
			error: function(jqXHR, textStatus, errorThrown){
				if (params.onFailure !== undefined) params.onFailure({error: textStatus});
			},
			dataType: 'json'
		}); 
	}
};


var Dialog = {
		Show: function(params){
			/*
			var dlgElement = $("#g-dialog");

			var dlgHeader = dlgElement.children(".header");
			var dlgContent = dlgElement.children(".content");

			var type = params.type !== undefined ? params.type : "info";

			if (type == "warning"){
				dlgHeader.data("theme", "e");
			}else{
				dlgHeader.removeData("theme");
			}

			dlgContent.html(params.text);
			$.mobile.changePage(dlgElement, { role: "dialog" } );
			*/
			alert(params.text); // TODO!
		}
};

var Autocomplete = {

	// Connette un input a una sorgente dati e fornisce una funzione di autocompletamento
	// @param selector selettore CSS per l'input
	// @param datasource URL dove vengono richiesti i dati
	// @options (opzionale) permette di specificare:
	//		delay => quanto tempo deve passare prima che la richiesta alla sorgente venga inviata (calcolata dall'ultima battitura)
	//		params => parametri da passare alla sorgente
	//		timeout => numero di millisecondi prima che la richiesta ajax fallisca
	Bind: function(selector, datasource, options){
		if (options === undefined) options = {};

		var $item = $(selector);

		if ($item.length > 0){

			// Parametri di default
			var delay = options.delay || 500;
			var params = options.params || {};
			var timeout = options.timeout || 10000;
			var data = {
				"term" : ""
			};

			// Copia i parametri in options.param per la richiesta
			for(var p in params){
				data[p] = params[p];
			}

			// Wrappa l'elemento 
			if (!$item.parent().hasClass("absolute-container")){
				$item.wrap('<div class="absolute-container"></div>');
			}

			// Se non c'e' l'elemento nel DOM...
			if (!$item.$autocompleteList){
				var $autocompleteList = $('<ul class="autocomplete-list"></ul>');

				// Definiamo la nostra funzione per cancellare la lista (invece di usare empty)
				// siccome teniamo traccia dell'elemento selezionato al momento tramite tastiera KEY_UP|KEY_DOWN
				$autocompleteList.clear = function(){
					this.empty();
					this.currentItemIndex = null;
				};

				// inserisci la lista (e linkala all'oggetto jquery padre)
				$item.after($autocompleteList);
				$item.$autocompleteList = $autocompleteList;
				$item.$autocompleteList.clear(); // inizializza
			}               

			// non inviare le richieste subito
			var timeoutHandle = 0;

			$item.lastSearchedTerm = "";
			$item.keyup(function(event){
				if (event.which == 13){
					// Premuto il tasto invio
					var $selected = $item.$autocompleteList.children(".hover");
					if ($selected.length > 0){
	        			$item.val($selected.html());
	        			$item.lastSearchedTerm = $selected.html();
	        			$item.$autocompleteList.clear();
        			}
				}else{
					if ($item.val() != ""){
			            clearTimeout(timeoutHandle);
			            timeoutHandle = setTimeout(function(){ 
			            	var newTerm = $item.val();

			            	// Non mandare se l'utente non ha cambiato il termine di ricerca
			            	if ($item.lastSearchedTerm != newTerm){
				            	data["term"] = newTerm;
				                $.ajax({
				                    type: "POST",
				                    url: datasource,
				                    data: data,
				                    timeout: timeout,
				                    dataType: 'json'
				                }).done(function(data){
				                        if (data.success && $item.is(":focus")){
				                        	$item.lastSearchedTerm = newTerm;
				                        	$item.$autocompleteList.clear();

				                        	for (var i in data.results){
				                        		var $suggestion = $("<li>" + data.results[i] + "</li>");
				                        		$item.$autocompleteList.prepend($suggestion);

				                        		// On click
				                        		$suggestion.click(function(){
				                        			$item.val($(this).html());
				                        			$item.$autocompleteList.clear();
				                        		});
				                        	}
				                        }
				                    }
			                	);
				            }
			            }, delay);
					}else{
						$item.$autocompleteList.clear();
					}
				}
			});	
			
			// Gestione dell'input da tastiera. Gestisce se l'utente preme la freccia giu/su e ESC
			$item.keydown(function(event){
				
				var KEY_UP = 38;
				var KEY_DOWN = 40;
				var KEY_ESC = 27;

				if (event.which == KEY_UP || event.which == KEY_DOWN){

					// Andiamo su di uno o giu di uno?
					var delta = null;
					if (event.which == KEY_DOWN) delta = 1;
					else if (event.which == KEY_UP) delta = -1;

					var itemsCount = $item.$autocompleteList.children().length;
					
					// Primo evento? (Non abbiamo ancora selezionato un elemento tramite tastiera)
					if ($item.$autocompleteList.currentItemIndex == null){
						$item.$autocompleteList.currentItemIndex = (event.which == KEY_DOWN ? 0 : itemsCount - 1);
						delta = 0; // muovi di zero, usa il valore di inizio
					}

					// Ci sono elementi da selezionare?
					if (itemsCount > 0){
						// Trova il prossimo
						var selectItemIndex = $item.$autocompleteList.currentItemIndex + delta;
						if (selectItemIndex > itemsCount - 1) selectItemIndex = 0;
						else if (selectItemIndex < 0) selectItemIndex = itemsCount - 1;

						// Seleziona il nuovo elemento e tieni traccia del nuovo indice
						$item.$autocompleteList.children().removeClass("hover");
						$item.$autocompleteList.children(":nth-child(" + (selectItemIndex + 1) + ")").addClass("hover");
						$item.$autocompleteList.currentItemIndex = selectItemIndex;

						event.preventDefault();
					}
				}else if (event.which == KEY_ESC){
					$item.$autocompleteList.clear();
				}
			});
		}
	}
};

// Operazioni sul testo
var Text = {
	// Quando cursor_pullback non e' undefined,
	// porta il cursore indietro dopo l'inserimento del testo
	// di cursor_pullback caselle.
	AppendTo: function(elementId, text, cursor_pullback) {
		var element = document.getElementById(elementId);
		if (element !== null){
			if (document.selection) {
				element.focus();
				var sel = document.selection.createRange();
				sel.text = text;
				sel.select();
			} else if (element.selectionStart || element.selectionStart == '0') {
				var start = element.selectionStart;
				var end = element.selectionEnd;
				var scroll = element.scrollTop;
				var pullback = cursor_pullback !== undefined ? cursor_pullback : 0;
				element.value = element.value.substring(0, start) + text + element.value.substring(end, element.value.length);
				element.focus();
			element.selectionStart = start + text.length - pullback;
				element.selectionEnd = start + text.length - pullback;
				element.scrollTop = scroll;
			} else {
				element.value += text;
				element.focus();
			}
		}
	},

	// Converte &gt;, &lt; negli equivalenti > e <
	// Assieme ad altre entita' comuni nella lingua italiana
	// Questa lista non e' comprensiva
	HtmlEntitiesDecode : function (text){
		var replacements = {
			"&gt;" : ">",
			"&lt;" : "<",
			"&Agrave;" : "À",
			"&agrave;" : "à",
			"&Aacute;" : "Á",
			"&aacute;" : "á",
			"&Egrave;" : "È",
			"&egrave;" : "è",
			"&Eacute;" : "É",
			"&eacute;" : "é",
			"&Igrave;" : "Ì",
			"&igrave;" : "ì",
			"&Iacute;" : "Í",
			"&iacute;" : "í",
			"&Ograve;" : "Ò",
			"&ograve;" : "ò",
			"&Oacute;" : "Ó",
			"&oacute;" : "ó",
			"&Ugrave;" : "Ù",
			"&ugrave;" : "ù",
			"&Uacute;" : "Ú",
			"&uacute;" : "ú",
			"&laquo;" : "«",
			"&raquo;" : "»",
			"&euro;" : "€"
		}
		
		for (var r in replacements){
			text = text.replace(new RegExp(r, "g"), replacements[r]);
		}

		return text;
	}
};

var Events = {
	// Lancia un evento
	Raise: function(eventName, params){
		var evt = document.createEvent("Event");
		evt.initEvent(eventName, true, true);
		evt.params = params;
		document.dispatchEvent(evt);
	},

	// Cattura un evento
	Listen: function(eventName, fn){
		document.addEventListener(eventName, fn, false);		
	}
}

// Icona principale di caricamento
var LoadingIcon = {
	Show: function(){
		$("#title-bar-loading").show();
		$("#title-bar-loading").attr('src', '/images/ajax-loading-title-bar.gif'); // Lazy loading

		$("#pag-section").hide();
	},

	Hide: function(){
		$("#title-bar-loading").hide();
		$("#pag-section").show();
	}
}

var FormBuilder = (function(){
	var _raiseEvent = function(form_id, event, params){
		Events.Raise("_formbuilder_" + form_id + "_" + event, params);
	};

	return {
		On: function(form_id, event, fn){
			Events.Listen("_formbuilder_" + form_id + "_" + event, fn);
		},
		Close: function(form_id){
			$("#" + form_id).hide();
			_raiseEvent(form_id, "Closed");
		},
		Submit: function(form_id){
			// import rsv from /js/rsv-2.5.2.js

			var $form = $("#" + form_id);
			var post_url = $form.data('post-url');
			var showError = function(error){
				var $msgbox = $("#" + form_id + "-warning-msg");
				var $panel = $("#" + form_id + "-bottom-panel");
				$panel.hide();
				$msgbox.show();

				if (error !== undefined){
					$msgbox.html(error);
				}

				$panel.delay(3505).fadeIn(1);
				$msgbox.delay(3000).fadeOut(500);
			};

			// Trova le regole di validazione
			var rules = [];
			$form.find("[data-validate]").each(function(){
				var parts = $(this).data('validate').split("|");
				for (var i = 0; i < parts.length; i++) rules.push(parts[i]);
			});

			rsv.errorTargetElementId = form_id + "-warning-msg";

			if (rsv.validate($form[0], rules)){
				_raiseEvent(form_id, "PreSubmit", {'form_id' : form_id});

				var $ajax_load = $("#" + form_id + "-submit-ajax-load");
				var $control_buttons = $("#" + form_id + " .control-button");
				$ajax_load.show();
				$control_buttons.hide();

				// Trova i dati da inviare
				var post_data = {};
				$form.find("[data-formfield]").each(function(){
					var $f = $(this);
					var key = $f.attr('name');

					// Ignora i campi marcati per non invio
					if ($f.data('dontsend') !== undefined) return;

					// Qui puoi gestire diversi tipi di campi
					if ($f.attr('type') == "checkbox"){
						post_data[key] = $f.is(':checked');
					}else{
						// textarea, textinput, ..
						post_data[key] = $f.val();
					}
					
				});

				$.ajax({
					type: "POST",
					url: post_url,
					data: post_data,
					timeout: 15000,
					dataType: 'json'
				}).done(function(data) {
					if (data.success){
						_raiseEvent(form_id, "Submit", {'success' : true, 
												'data' : data
												});
					}else{
						showError(data.error);
					}
				}).fail(function(jqXHR, textStatus, errorThrown){
					$control_buttons.show();
					showError(textStatus);
				}).always(function(){
					$ajax_load.hide();
					$control_buttons.show();
				});
			}else{
				showError();
			}
		},

		// Ripristina gli elementi di questo form ai suoi valori originali
		Reset: function(form_id){
			var $form = $("#" + form_id);

			$form.find("[data-formfield]").each(function(){
				var $f = $(this);

				// Qui puoi gestire diversi tipi di campi
				if ($f.attr('type') == "checkbox"){
					$f.prop('checked', $f.data('reset-value') == "1");
				}else{
					// textarea, textinput, ..
					$f.val($f.data('reset-value'));
				}
			});
		},

		// Ritorna un elemento jQuery corrispondente al campo specificato da "name" all'interno di "form_id"
		GetField: function(form_id, name){
			return $("#form-" + form_id + "-field-" + name);
		},


		// Ritorna un elemento jQuery corrispondente al contenitore del campo specificato da "name" all'interno di "form_id"
		GetFieldContainer: function(form_id, name){
			return FormBuilder.GetField(form_id, name).parent(); // container <div>
		}
	};
})();

var InlineEditor = {
	// Crea una casella di editing per l'oggetto specificato
	// @param selector selettore CSS per l'elemento che deve essere modificato
	// @param post URL dove inviare il contenuto editato
	// @param options (opzionale) oggetto contenente:	
	//			type --> "textarea"|"text" (default text)
	//			load --> URL da cui prelevare il contenuto dell'oggetto
	//			loadDataType --> "text" (default)|"json" tipo di risposta ritornata da load
	//			loadCallback --> funzione che permette di interpretare il risultato
	//							tornato da load (ad esempio, selezionare un particolare campo json)
	//
	//			loading --> callback chiamata mentre il contenuto viene caricato
	//			loaded --> callback chiamata quando il conteuto e' stato caricato
	//			success --> callback da chiamare una volta che il contenuto e' stato editato con successo
	//			failure --> callback da chiamare se il tentativo di modificare il contenuto e' fallito
	//			always --> callback chiamata ogni volta che l'operazione di modifica e' terminata

	Edit: function(selector, post, options){
		// Inizio dichiarazioni funzioni helpers
		
		// Da chiamare SEMPRE prima di uscire l'operazione di edit
		function exitEditor(){
			$element.data('editing', false);
			options.always();
		}
		
		// Una volta che il contenuto dell'editor e' stato caricato
		function contentLoaded(){
			// Da chiamare quando si vuole cancellare l'operazione di edit
			function cancelCloseEditor(){
				$element.html(content_bkp);
				exitEditor();
			}

			// Hack per trovare il numero di colonne di una textarea
			// anche se non sono state specificate
			function findTextareaCols($textarea){
				if ($textarea._computedCols === undefined){
					var $tmp = $("<textarea cols='1' rows='1'></textarea>");
					var targetWidth = $textarea.width();
					var cols = 1;

					$tmp.appendTo("body");
					while($tmp.width() < targetWidth){
						$tmp.attr('cols', cols++);
					}
					$tmp.remove();
					$textarea._computedCols = cols;
				}
				return $textarea._computedCols;				
			}

			// Ridimensiona una textarea verticalmente in base al contenuto
			function autoResize($textarea){
				var content = $textarea.val();
				var cols = findTextareaCols($textarea);
				var count = 0;
				var lines = content.split("\n");
				for (var line in lines){
					count += Math.ceil((lines[line].length + 1) / cols);
				}
				$textarea.attr('rows', count + 1);
			}

			// Carica la casella di editing
			var content_bkp = $element.html();
			$element.html($editor);	

			// Carica il bottone per annullare
			// Nota: text-decoration e' none perche' le pseudo classi non vengono applicate correttamente
			// 		per elementi dinamici
			var $btn_cancel = $('<a href="javascript:void(0);" class="btn mini icon icon-cancel_circle" style="text-decoration: none;"><span class="hide-phone">Annulla</span></a>');
			var cancelling = false;
			$btn_cancel.click(function(){
				cancelCloseEditor();
				cancelling = true;
			});

			if (options.type == "textarea"){
				var $btn_cancel_container = $("<div style='text-align: right;'></div>");
				$btn_cancel_container.append($btn_cancel);
				$editor.after($btn_cancel_container);

				// Imposta le dimensioni della textarea
				autoResize($editor);
				findTextareaCols($editor);

				// Aggiunsta automaticamente le dimensioni della textarea quando l'utente
				// aggiunge/toglie una riga riga
				$editor.keyup(function(event){
					autoResize($editor);
				});
			}else if (options.type == "text"){
				$editor.after($btn_cancel);
			}

			// Salva il valore originale
			var val_bkp = $editor.val();

			// Imposta l'evento per salvare il contenuto
			$editor.blur(function(){

				// Ritarda l'evento per permettere al sistema
				// di vedere se e' stato premuto il pulsante per annullare
				setTimeout(function(){
					if (!cancelling){
						var val_new = $editor.val();
						if (val_bkp != val_new){
							$editor.prop('disabled', true);
							$.ajax({
			                    type: "POST",
			                    url: post,
			                    data: {value: val_new},
			                    timeout: 10000,
			                    dataType: 'json'
			                }).done(function(data){
								if (data.success && data.value){
									$element.html(data.value);
									options.success();
								}else{
									options.failure();
								}
			              	}).fail(function(){
			              		options.failure();
			                }).always(function(){
			        			exitEditor();
			        			$editor.prop('disabled', false);
			            	});
						}else{
							cancelCloseEditor();
						}
					}
				}, 200);
			});

			$editor.focus();
		} 

		// fine dichiarazioni funzioni helpers

		if (options === undefined) options = {};

		// Carica i valori di default
		var defaults = {
			type : "text",
			load : "",
			loadDataType : "text",
			loadCallback : function(response){ return response; },
			loading : function(){},
			loaded: function(){},
			success: function(){},
			failure: function(){},
			always: function(){}
		};

		for (var i in defaults){
			if (options[i] === undefined) options[i] = defaults[i];
		}

		var $element = $(selector);
		if ($element.length > 0){
			// Imposta un lock
			if (!$element.data('editing')){
				$element.data('editing', true);

				// Crea l'editor
				var $editor;
				if (options.type == "text") $editor = $("<input type='text' />");
				else if (options.type == "textarea") $editor = $("<textarea style='width: 100%;'></textarea>");
				
				// Prende il contenuto (tramite URL oppure tramite contenuto)
				if (options.load !== ""){
					options.loading();
					$.ajax({
	                    type: "GET",
	                    url: options.load,
	                    timeout: 10000,
	                    dataType: options.loadDataType
	                }).done(function(data){
						$editor.val(options.loadCallback(data));              	   	
	              	   	contentLoaded();
	              	}).fail(function(){
	              		options.failure();
	              		exitEditor();
	                }).always(function(){
	        			options.loaded();        			
	            	});
				}else{
					$editor.val($element.html());
					contentLoaded();
				}
			}
		}
	}
};

var AutoFuncs = {
	// Applica una serie di funzionalita' aggiuntive agli elementi
	// contenuti in elemento specificato da selector
	// Questa funzione e' da chiamare:
	//    1. Sull'evento onLoad della pagina
	//	  2. Quando nuovo contenuto viene caricato dinamicamente tramite javascript
	// @param selector selettore CSS (*, div#test, ecc.) oppure un oggetto jQuery ( $("div#test") )
	ApplyTo: function(selector){
		var $ctx;

		if (typeof selector == "string") $ctx = $(selector);
		else $ctx = selector;

		// Aggiunge automaticamente le classi .active e .hover ai bottoni quando necessario
		$ctx.find(".btn").mouseenter(function(){
			$(this).addClass("hover");
		}).mouseleave(function(){
			$(this).removeClass("hover").removeClass("active");
		}).mousedown(function(){
			$(this).addClass("active");
		}).mouseup(function(){
			$(this).removeClass("active");
		});

		// Ogni elemento che ha un data-toggle
		// Fa comparire e sparire l'elemento con l'ID specificato nell'attributo
		$ctx.find("[data-toggle]").each(function(){
			$(this).click(function(event){
				var e = "#" + $(this).data('toggle');
				if ($(e).is(":visible")) $(e).hide();
				else $(e).show();

				event.stopPropagation();
			});
		});

		// Ogni elemento che ha un data-hide
		// Fa scomparire la lista di elementi con gli ID (seperati da uno spazio)
		// specificati nell'attributo
		$ctx.find("[data-hide]").each(function(){
			$(this).click(function(event){
				var id_list = $(this).data('hide').split(" ");
				var i, e;
				for (var i = 0; i < id_list.length; i++){
					e = "#" + id_list[i];
					$(e).hide();
				}

				event.stopPropagation();
			});
		});

		// Ogni elemento che ha un data-show
		// Fa scomparire la lista di elementi con gli ID (seperati da uno spazio)
		// specificati nell'attributo
		$ctx.find("[data-show]").each(function(){
			$(this).click(function(event){
				var id_list = $(this).data('show').split(" ");
				var i, e;
				for (var i = 0; i < id_list.length; i++){
					e = "#" + id_list[i];
					$(e).show();
				}

				event.stopPropagation();
			});
		});

		// Chiudi automaticamente i pannelli/drop-down/etc... quando si clicca 
		// Al di fuori della loro area
		(function(){
			var classes = ["toggle-panel", "drop-down-list", "multi-cell-drop-down"];

			// Chiudi tutti i pannelli (tranne l'ultimo che e' stato cliccato/toccato)
			// usando il tag body ci assicuriamo che questa funzione viene chiamata una sola volta
			// su page_load quando $ctx = $("html")
			$ctx.find("body").click(function(){
				for (var i = 0; i < classes.length; i++){
					$("." + classes[i] + ":not(._prevent-hide)").hide();
					$("." + classes[i]).removeClass("_prevent-hide");
				}
			});

			// Sul click di un elemento, impostalo come ultimo cliccato
			for (var i = 0; i < classes.length; i++){
				$ctx.find("." + classes[i]).click(function(event){
					$(this).addClass("_prevent-hide");
				});
			}
		})();

		// Liste
		$ctx.find("ul.nav-list > ul + li").each(function(){
			// Aggiungi la classe "has-children" per gli elementi
			// delle liste nidificate e aggiungi un pulsante indietro
			$(this).addClass("has-children");
			$(this).prev().prepend('<li class="nav-back">..</li>');
			
			// Aggiungi la possibilita' di navigare in sotto-liste
			$(this).click(function(){
				$(this).siblings().hide();
				$(this).hide();
				$(this).prev().show();
			});
		});

		// Permetti di navigare indietro nella lista
		$ctx.find("ul.nav-list li.nav-back").click(function(){
			$(this).parent().hide();
			$(this).parent().siblings("li").show();
		});

		// Rimuovi il padding per gli elementi che hanno un anchor tag
		$ctx.find("ul.nav-list li a").each(function(){
			$(this).parent().css('padding', '0');
		});

		// Checkbox custom, imposta l'evento onclick per cambiare il loro valore
		$ctx.find("div.checkbox").each(function(){
			$(this).click(function(){
				if ($(this).attr('data-value') == 'checked'){
					$(this).attr('data-value', '');
				}else{
					$(this).attr('data-value', 'checked');
				}
			});

			// Previene una selezione (fastidiosa) quando l'utente clicca in velocita'
			$(this).mousedown(function(){ return false; });
		});
	}
};

var Header = {
	// Imposta il titolo della finestra corrente
	// @param title titolo della finestra
	SetTitle: function(title){
		$("h1#pag-section").text(title);
	}
};

// Vedi header.php per CurrentUser

$(function(){
	AutoFuncs.ApplyTo("html");

	prettyPrint();
});
