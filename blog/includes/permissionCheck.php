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

function checkPermission($roleID, $pageName){
  if($roleID > $permissionArray[$pageName]){
    return false;
  } else {
    return true;
  }
}
?>