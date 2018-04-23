<?php
//permissions for every page that needs them
function getPermissionsArray(){
  return array(
    "newPost" => 5,
    "editPost" => 5,
    "newCampaign" => 3,
    "editCampaign" => 3,
    "newCategory" => 2,
    "editCategory" => 2,
    "newEvent" => 2,
    "editEvent" => 2,
  );
}

//decide whether or not the user is allowed to access $pageName
function grantAccess($roleID, $pageName){
  $permissionArray = getPermissionsArray();
  if($roleID > $permissionArray[$pageName]){
    //access denied
    return false;
  } else {
    //access granted
    return true;
  }
}
?>