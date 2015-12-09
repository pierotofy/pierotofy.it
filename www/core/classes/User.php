<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */ 

/** Rappresenta un utente nel sito. */
class User extends Entity{
	const NOT_A_DEVELOPER = 0;
	const NORMAL_DEVELOPER = 1;
	const ADMIN_DEVELOPER = 2;

	const PERMISSION_USER = 9;
	const PERMISSION_MEMBER = 2;
	const PERMISSION_FOUNDER = 1;
	const PERMISSION_ADMIN = 0;

	const SELECT_SQL = "SELECT u.id, u.md5, u.user AS username, u.mail, u.last_login_ip, u.previous_login_timestamp, u.last_login_timestamp, 
						u.permission, u.avatar, u.signature, u.banned, u.banned_reason, u.requirepwdreset, u.developerpermission, 
						u.forum_post_count, u.is_teacher, u.webhuddle_password,
			          	m.id AS member_id, m.nickname AS member_nickname, m.description AS member_description, m.location AS member_location, 
			            m.employ AS member_employ, m.real_name AS member_firstname, m.real_surname AS member_lastname
			FROM users u
			LEFT OUTER JOIN members m
			ON m.user_id = u.id
	";

	function User($sql_where){
		parent::Entity($sql_where);
		if ($this['id']){
			// Imposta defaults su nulls
			if (!$this['avatar']) $this['avatar'] = "default.png";
			if (!$this['member_location']) $this['member_location'] = 'Località non disponibile';
			if (!$this['member_employ']) $this['member_employ'] = 'Impiego non disponibile';
		}
	}

	public function getSelectSql(){
		return User::SELECT_SQL;
	}

	function isMod(){
		if ($this->isMember()){

      		// Lazy loading
			if (!isset($this['is_mod'])){
				$q = exequery("SELECT id FROM forum_arguments WHERE moderators = \"" . $this['member_nickname'] . "\" AND root != 'Projects'");
				$this['is_mod'] = mysqli_num_rows($q) > 0;
			}

			return $this['is_mod'];
		}else return false;
	}

	// Ritorna l'URL dell'avatar dell'utente
	function getAvatarUrl(){
		return "/data/images/profiles/users/" . $this['avatar'];
	}

	function isModOfForum($id){
		validate_num($id);

		if ($this->isAdmin()) return true;

		if ($this->isMod()){

			// Lazy loading
			if (!isset($this['mod_of_forum'][$id])){
				$q = exequery("SELECT moderators FROM forum_arguments WHERE id = $id");
				$res = mysqli_fetch_array($q, MYSQLI_ASSOC);
				$this['mod_of_forum'][$id] = $res['moderators'] == $this['member_nickname'];
			}

			return $this['mod_of_forum'][$id];
		}else return false;
	}

	function forumPostsCount(){
		return $this['forum_post_count'];
	}

	function isBanned(){
		return isset($this['banned']) && ($this['banned'] > time());
	}

	function isTeacher(){
		return $this['is_teacher'];
	}

	function hasAWebHuddleAccount(){
		return $this['webhuddle_password'] != null && $this['webhuddle_password'] != "";
	}

	// @return se un utente e' valido (esiste nel database)
	function isValid(){
		return $this['id'] != null;
	}

	function isLogged(){
		return false; // Override per cambiare
	}

	function isGuest(){
		return false; // Override per cambiare
	}

	function isAdmin(){
		return (isset($this['permission']) && $this['permission'] == User::PERMISSION_ADMIN);
	}

	function isMember(){
		return ($this->isAdmin() || $this['permission'] == User::PERMISSION_FOUNDER || $this['permission'] == User::PERMISSION_MEMBER);
	}

	function getForumVotes(){
		if (!isset($this['forum_votes'])){
			$q = exequery("SELECT forum_votes_pro, forum_votes_cons FROM users WHERE id = $this[id]");
			$this['forum_votes'] = mysqli_fetch_array($q, MYSQLI_ASSOC);
		}
		return $this['forum_votes'];
	}

	function isDeveloper(){
		return $this['developerpermission'] ==  User::NORMAL_DEVELOPER || $this['developerpermission'] == User::ADMIN_DEVELOPER;
	}

	function getDeveloperDescription(){
		return $this['developerpermission'] == User::NORMAL_DEVELOPER ? "Sviluppatore" : "Maintainer";   
	}

	function getProfileUrl(){
		return "#"; //"/p/members/profile.php?uid=" . $this['id']; TODO!
	}

	function getProfileLink(){
		return "<a href='".$this->getProfileUrl()."'>".str_replace("_", " ",$this['member_nickname'])."</a>";
	}

	function getWebhuddleScriptIDs(){
		if ($this['webhuddle_script_ids'] == null){
      		// Lazy loading
			$q = exequery("SELECT webhuddle_script_ids FROM users WHERE id = " . $this['id']);
			$row = mysqli_fetch_array($q, MYSQLI_ASSOC);
			$this['webhuddle_script_ids'] = unserialize($row['webhuddle_script_ids']);
		} 

		return $this['webhuddle_script_ids'];
	}

  // TODO: 
	function getAboutBox(){
		$context = "
		<b>A proposito dell'autore</b><br><br/>
		
		<div class='avatarBox'>
		<a href='".$this->getProfileUrl()."'>
		<img src=\"/data/images/profiles/users/".$this['avatar']."\">
		</a>
		".$this->getProfileLink()."<br/>
		</div>
		<div class='descriptionBox'>
		".(($this['member_id']) ? $this['member_description'] : "Descrizione non disponibile. Questo membro non è più parte della Community.") ."
		</div>
		
		</div><div class='clear'></div>";

		return $context;

	}

}

require_once("CurrentUser.php");
require_once("GuestUser.php");
require_once("DeletedMemberUser.php");

?>
