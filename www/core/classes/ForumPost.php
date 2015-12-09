<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */ 


/** Rappresenta un post (una risposta) nel forum. */
class ForumPost extends Entity{   

	const SELECT_SQL = "SELECT fp.id, fp.subject, fp.argument, fp.user_id, fp.message, fp.edit_date, fp.edit_by, fp.replies, fp.locked, fp.attachment_filename, fp.attachment_size, fp.attachment_type,
							us.user, us.date, us.mail, us.avatar, us.description, us.signature, us.banned, us.permission, us.forum_post_count, fp.post_date, fp.root_topic,
					(CASE fp.edit_by
						WHEN 0 THEN 
							''
						ELSE 
							(SELECT u.user FROM users u WHERE u.id = fp.edit_by)
					END) AS edit_user
					FROM forum_posts fp 
					LEFT OUTER JOIN users us 
					ON us.id = fp.user_id
			";

	// Nota sui campi
	// ========
	// subject = titolo del topic
	// id = id del topic
	// argument_title = titolo del forum di cui il topic fa parte
	// argument = id del forum di cui il topic fa parte

	// @param values la lista dei campi per rappresentare un post
	function ForumPost($values){
		parent::Entity($values);
	}

	public function getSelectSql(){
		return ForumPost::SELECT_SQL;
	}
 
	// Renderizza questo oggetto tramite un template
    // @param view_file nome del template da usare come template (in core/views/)
    // @param values hash contenente parametri da inviare alla view (in aggiunta a quelli gia' inclusi dall'Entity)
	public function render($view_file, $values = array()){
		global $currentUser;
		return Entity::render($view_file, array_merge($values, array(
								"avatar_url" => "/data/images/profiles/users/" . ($this['avatar'] ? $this['avatar'] : "default.png"),
								"parsed_message" => $this->getParsedMessage(),
								"parsed_signature" => Text::MessageToHtml($this['signature']),
								"view_profile_url" => "#", #TODO
								"formatted_post_date" => DateUtils::GetNice($this['post_date']),
								"edited" => $this['edit_by'] != '0',
								"edit_by" => $this['edit_by'],
								"edit_user" => $this['edit_user'],
								"edit_date" => DateUtils::GetNice($this['edit_date']),
								"is_mod" => $currentUser->isModOfForum($this['argument']),
								"can_edit" => $currentUser->isModOfForum($this['argument']) || $currentUser["id"] == $this['user_id']
							)));
	}

	// @return il messaggio del post, convertito per la visualizzazione all'utente
	public function getParsedMessage(){
		return Text::MessageToHtml($this['message']);
	}

	// @param userObj oggetto User rappresentante l'utente da verificare per i permessi 
	// @return true se il post puo' essere visto dall'utente passato come argomento
	function isViewableBy($userObj){
		$forum_info = Forum::GetForumInfo($this['argument']);
		return Forum::IsAccessGrantedTo($forum_info, $userObj);
	}

	// Ritorna la pagina dove questo post verra' visualizzato all'interno del forum
	// utile per sapere a quale pagina reindirizzare l'utente durante l'inserimento di una notifica (ad esempio)
	// @return pagina del post
	public function getPageNumber(){

		// Elenca tutti i posts nel thread fino a che non troviamo la nostra posizione...
		// Ci dev'essere un modo migliore...?

		$q = exequery("SELECT id FROM forum_posts 
		WHERE root_topic = (SELECT root_topic FROM forum_posts WHERE id = $this[id]) ORDER BY id");
		$position = 0;
		$c = 1;
		while($res = mysqli_fetch_array($q)){
			if ($res['id'] == $this['id']){
				$position = $c;  
				break;
			}
			$c++;
		}
		
		if ($position == 0) return 1;
		else{
			return floor((($position - 1) / Forum::POSTS_PER_PAGE) + 1);
		}
	}
	
  }
?>
