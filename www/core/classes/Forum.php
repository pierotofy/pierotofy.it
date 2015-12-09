<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */ 

	/** Helpers per interagire con il forum */
	class Forum{
		const TYPE_TOPIC = 0;
		const TYPE_POST = 1;

		const NORMAL_POST = 0;
		const IMPORTANT_LOCAL_POST = 1;
		const IMPORTANT_PUBLIC_POST = 2;

		// Quanti secondi tra un post e l'altro
		const FLOOD_SECONDS_LIMIT = 15;

		// Quanti posts vengono visualizzati nello stesso thread per pagina
		const POSTS_PER_PAGE = 8;

		// Quanti topics vengono visualizzati in un forum per pagina
		const TOPICS_PER_PAGE = 16;

		// Ritorna le informazioni di un particolare forum
		public static function GetForumInfo($forum_id){
			validate_num($forum_id);
			
			return DB::FindOne("SELECT title, developers_only, private FROM forum_arguments WHERE id = $forum_id");
		} 

		// Controlla se l'utente passato come $userObj ha accesso al forum
		// $forum_info e' l'oggetto ritornato da Forum::GetForumInfo
		public static function IsAccessGrantedTo($forum_info, $userObject){
			// Controlla i permessi
			if ($forum_info['private'] && !$userObject->isMember()){
				return false;
			}

			if ($forum_info['developers_only'] && !$userObject->isDeveloper()){
				return false;
			}

			return true;
		}

		// Controlla se l'utente sta floddando il forum
		public static function IsUserFlooding($userObj){
		    $res = DB::FindOne("SELECT post_date FROM forum_posts 
                        			WHERE user_id = $userObj[id] ORDER BY id DESC");
    		return !DEBUG && (time() - $res['post_date'] < self::FLOOD_SECONDS_LIMIT);
		}

		// Incrementa il conto dei posts per l'utente specificato
		public static function IncPostCountForUser($userObj){
			exequery("UPDATE users SET forum_post_count = forum_post_count + 1 WHERE id = $userObj[id]");
		}

		// Si occupa di aggiornare le informazioni del topic (base) dopo che gli e' stata aggiunta
		// una risposta
		public static function UpdateTopicAfterReply($topic_id){
			validate_num($topic_id);

			// Aggiorna:
			// - Il conto dei posts
			// - La data dell'ultimo post 
			exequery("UPDATE forum_posts SET replies = replies + 1, 
											last_post_date = " . time() . "
					WHERE id = $topic_id");
		}

		// Aggiunge le notifiche di risposta quando un utente risponde 
		// @param post_id id del post che e' appena stato inserito
		public static function AddReplyNotifications($post_id){
			global $currentUser;

			$post = new ForumPost($post_id);

			// Lista di utenti che hanno risposto al topic, ma che non 
			// sono all'interno della skip list
			$q = exequery("SELECT p.user_id as user_id, s.user_id as skip_user_id FROM forum_posts p 
							LEFT OUTER JOIN forum_notifications_skip_list s ON (s.user_id = p.user_id AND s.topic_id = $post[root_topic]) 
							WHERE p.root_topic = $post[root_topic] OR p.id = $post[root_topic] GROUP BY user_id
							UNION SELECT a.user_id AS user_id, NULL AS skip_user_id
							FROM forum_notifications_add_list a WHERE a.topic_id = $post[root_topic]
			");

			// Una notifica a ciascuno, non fa male a nessuno
			while($values = mysqli_fetch_array($q)){
			   if ($values['user_id'] == $currentUser['id']) continue; //Skip noi stessi
			   if ($values['skip_user_id'] != null) continue; //Skippa se richiesto

			   exequery("INSERT INTO forum_notifications (topic_id, user_id, notify_tm, post_id, page_num) 
			   	VALUES ('$post[root_topic]','$values[user_id]',".time().", $post_id, " . $post->getPageNumber() . ")");
			}
			 
			 
			//Rimuovi dalla lista di skip_notifications l'user che ha postato
			exequery("DELETE FROM forum_notifications_skip_list 
			 			WHERE user_id = $currentUser[id] AND topic_id = $post[root_topic]");
		}
	}

?>
