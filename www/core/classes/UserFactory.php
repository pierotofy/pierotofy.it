<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */ 
 
	require_once("User.php");
	require_once("LoginUtils.php");

	/** Questa classe si occupa di creare utenti in base a diversi metodi */
	class UserFactory{

		// @return un utente (non necessariamente loggato)
		public static function CreateFromLoginHash($hash){
			$creds = LoginUtils::HashToCredentials($hash);

		    //et voila! user e pass pronti all'uso
		    return UserFactory::CreateFromCredentials($creds['username'], $creds['password']);
		}

		// @return un utente (non necessariamente loggato)
		public static function CreateFromCredentials($username, $password){
		    $md5 = LoginUtils::Md5FromCredentials($username, $password);

		    // CurrentUser controlla che l'utente sia verificato
		    return new CurrentUser($md5);
		}

		// @return un utente (non loggato e non necessariamente valido)
		public static function CreateFromId($id){
			validate_num($id);
			return new User("id = $id");
		}

		// @return l'utente corrente (non necessariamente loggato)
		public static function CreateCurrentUser(){
			$currentUser = null;

			if (isset($_COOKIE['login_hash']) && $_COOKIE['login_hash'] != '') $currentUser = new CurrentUser($_COOKIE['login_hash']);
			else if (isset($_SESSION['login_hash']) && $_SESSION['login_hash'] != "") $currentUser = new CurrentUser($_SESSION['login_hash']);
			else $currentUser = new GuestUser();

			if ($currentUser->isLogged()){
			 	if ($currentUser->isBanned()){
					$_SESSION['login_hash'] = null;
					setcookie('login_hash','',0,'/');
				}
			}else{
				$_SESSION['login_hash'] = null;
			}

			return $currentUser;
		}
	}

?>
