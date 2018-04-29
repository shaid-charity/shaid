<?php
function getPermissionArray(){
  return array(
    "/usermgmt.php" => 1,
    "/companies.php" => 1,
    "/contactDB.php" => 2,
    "/viewEvents.php" => 3,
    "/newevent.php" => 3,
    "/campaign.php" => 2,
    "/viewCampaigns.php" => 2,
    "/newpost.php" => 5,
    "/viewPosts.php" => 5,
    "/createCategory.php" => 3,
    "/viewCategories.php" => 3,
    "/socialPost.php" => 2,
    "/socialTrends.php" => 2,
    "/profile.php" => 5,
    "/sendEmail.php" => 2,
    "/index.php" => 5
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

function checkIfEmailExists($con, $email, $user_id){
  $query = $con->prepare("SELECT COUNT(email) FROM users WHERE email=?");
  $query->bind_param("s", $email);
  $query->execute();
  $query->bind_result($count);
  $query->fetch();
  $query->close();

  if($user_id == -1){
    if($count == 0){
      return false;
    } else {
      return true;
    }
  } else {
    $query = $con->prepare("SELECT email FROM users WHERE user_id=?");
    $query->bind_param("s", $user_id);
    $query->execute();
    $query->bind_result($user_email);
    $query->fetch();
    $query->close();

    $threshold = 0;
    if($user_email == $email){
      $threshold = 1;
    } else {
      $threshold = 0;
    }

    if($count > $threshold){
      return true;
    } else {
      return false;
    }
  }


}
?>