<?php
  /** Si occupa di recuperare la password dell'utente
    method: POST
    params: 
      hash: obscured username and password (see /js/site.js Login.encrypt) 
      usecookie: "0" => do not set cookie, "1" => set cookie
    returns:
      success: "0" => error happened, "1" => OK
      banned_message (optional): a ban message if the user is currently banned
      
  */
  require_once("__inc__.php");

  $response = new RestfulResponse("json");
  
  $username = db_escape(Charset::Utf8ToDB($_POST['user']));
  $userObj = new User("user = \"$username\"");
  if ($userObj->isValid()){
    $ip = get_ip();
    $url = $site_url . "/p/login/resetPassword.php?token=$userObj[md5]&uid=$userObj[id]";

    $message = $userObj['username'] . ",<br/>
è stata inoltrata una richiesta da [$ip] per resettare la tua password su <a href=\"$site_url\">www.pierotofy.it</a>.<br/>
<br/>
Per continuare la procedura visita il link qui sotto riportato:<br/><br/>

<a href=\"$url\">$url</a>
";
    try{
      if (Mailer::SendEmail("recuperopassword@pierotofy.it", "admin@pierotofy.it", "Recupero password", $message)){
        $response->setSuccess(true);
      }else{
        $response->setError("E' successo un errore durante l'invio dell'e-mail.");
      }
    }catch(Exception $e){
      $response->setError("Eccezione: " . $e->getMessage());
    }
  }else{
    $response->setError("L'utente non e' valido.");
  }

  $response->send();

?>