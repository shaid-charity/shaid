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
  if($roleID > $permissionArray[$pageName]){
    //access denied if role id is greater than what is required by the page
    return false;
  } else {
    //access granted
    return true;
  }
}
?>