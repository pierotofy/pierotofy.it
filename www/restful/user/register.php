<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */ 

  /** Si occupa di registrare un nuovo utente
    method: POST
    params: 
      hash: username e password oscurati (vedi /js/site.js Login.encrypt) 
    returns:
      success: false => errore, true => OK
      error: messaggio di errore se success e' false
  */

  require_once("__inc__.php");
  
  $response = new RestfulResponse("json");

  $av = new AutoValidator("frm-register", $_POST);
  if ($av->validate()){
    if (isset($_POST['question']) && $_POST['question'] == "10"){
      $email = db_escape(purify(trim(Charset::Utf8ToDB($_POST['email']))));

      $creds = LoginUtils::HashToCredentials(db_escape($_POST['hash']));
      $username = db_escape(purify(trim(Charset::Utf8ToDB($creds['username']))));
      $password = db_escape(purify(trim(Charset::Utf8ToDB($creds['password']))));

      // Username libero?
      if (!DB::FindOne("SELECT 1 FROM users WHERE user = \"$username\"")){

        // Legacy: Un timestamp sarebbe stato meglio, ma non dobbiamo fare nulla con questo dato, quindi va bene cosi'
        $data = date("d/m/Y G:i");

        $description = "Normal User";

        $md5 = LoginUtils::Md5FromCredentials($username, $password);

        // Tutto a posto
        exequery(sprintf('INSERT INTO users (user, mail, ip, os_browser, date, description, permission, verified, md5, last_login_timestamp, last_login_ip, newsletter)
                  VALUES ("%s", "%s", "%s", "%s", "%s", "%s", %s, %s, "%s", %s, "%s", %s)',
                  $username, $email, get_ip(), db_escape(purify($_SERVER["HTTP_USER_AGENT"])), $data, $description, User::PERMISSION_USER, 1, $md5, time(), get_ip(), 1));

        // Logga l'utente
        $currentUser = UserFactory::CreateFromCredentials($username, $password);
        if ($currentUser->isLogged()){
          $response->setSuccess(true);
          
          // Logga
          Log::Info(sprintf("%s si e' registrato", $currentUser['username']));

          $_SESSION['login_hash'] = $currentUser['md5'];
          setcookie('login_hash', $currentUser['md5'], time() + (60*60*24*7), '/');
        }else{
          // Questo non dovrebbe succedere
          $response->setError("E' successo un imprevisto durante la registrazione. Per favore segnala questo incidente ad un amministratore.");
        }
      }else{
        $response->setError("L'username e' stato gia' preso. Scegline un'altro.");
      }
    }else{
      $response->setError("Captcha non valido.");
    }
  }else{
    $response->setError($av->getLastError());
  }

  $response->send();
?>
