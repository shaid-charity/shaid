<?php
function getPermissionArray(){
  return array(
    "/usermgmt.php" => 1,
    "/contactDB.php" => 2,
    "/viewEvents.php" => 3,
    "/event.php" => 3,
    "/campaign.php" => 2,
    "/viewCampaigns.php" => 2,
    "/post.php" => 5,
    "/viewPosts.php" => 5,
    "/createCategory.php" => 3,
    "/viewCategories.php" => 3,
    "/socialPost.php" => 2,
    "/socialTrends.php" => 2,
    "/profile.php" => 5,
  );
}

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
function getRepresenting($input){
  if(isset($input)){
    return "1";
  } else{
    return "0";
  }
}

//user details simple validation
//to be tested properly
function validateUser($email, $first_name, $lastName, $bio){
  //email regex, same as in JS
  $pattern = '/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/';
  
  $first_name_length = strlen(getValidData(trim($first_name)));
  $last_name_length = strlen(getValidData(trim($last_name)));
  $bio_length = strlen(getValidData(trim($bio)));

  if(preg_match($pattern, $email) === 0){
    return false;
  }

  if($first_name_length > 50 && $first_name_length < 1){
    return false;
  }

  if($last_name_length > 50 && $last_name_length < 1){
    return false;
  }
  
  if($bio_length > 1500){
    return false;
  }

  return true;
}
?>