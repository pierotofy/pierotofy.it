<?php
  /** Si occupa di fare il logout dell'utente 
    method: POST
    params: 
      (none)
    returns:
      success: "1"
  */
  require_once("__inc__.php");
  

  $response = new RestfulResponse("json");
  $_SESSION['login_hash'] = "";
  setcookie('login_hash', '', 0, '/');
  $response->setSuccess(true);
  $response->send();

?>