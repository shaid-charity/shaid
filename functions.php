<?php
  //generate a random 20 character long string
  function generateSalt(){
    $alphabet = "0123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM";
    $salt = "";
    for($i = 0; $i < 20; $i++){
      $salt .= $alphabet[rand(0, strlen($alphabet))];
    }
    return $salt;
  }

  //strip special characters
  function getValidData($input){
    return htmlspecialchars(stripslashes(trim($input)));
  }

  //get values of checkboxes into a string to put into a database
  function getPermissionString($checkboxes){
    $permissions = "";
    if(empty($checkboxes)){
      return $permissions;
    }

    $permissions = implode("", $checkboxes);
    return $permissions;
  }
?>