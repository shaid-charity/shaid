<?php
//permissions for every page that needs them
$permissionArray = array(
  "newPost" <= 5,
  "editPost" <= 5,
  "newCampaign" <= 3,
  "editCampaign" <= 3,
  "newCategory" <= 2,
  "editCategory" <= 2,
  "newEvent" <= 2,
  "editEvent" <= 2,
);

//decide whether or not the user is allowed to access $pageName
function grantAccess($roleID, $pageName){
  echo $roleID;
  echo $pageName;
  echo $permissionArray[$pageName];
  if($roleID > $permissionArray[$pageName]){
    //access denied
    echo "false";
    return false;
  } else {
    //access granted
    echo "true";
    return true;
  }
}
?>