<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/TechnoHouse/model/php/bootstrap.php';
$data[TAG_LOGGED] = false;

if(isUserLoggedIn()){
    $id = $_SESSION[TAG_USER_ID];
    $data[TAG_LOGGED] = true;
    $users_id = $dbh->getFollowers($id);
    $data[TAG_USER_FOLLOWERS] = array();
    foreach($users_id as $info){
        $user = $dbh->getUserByID($info[TAG_USER_THAT_FOLLOWS])[0];
        array_push($data[TAG_USER_FOLLOWERS], array(TAG_USER_ID => $user[TAG_USER_ID], 
        TAG_USER_NAME => $user[TAG_USER_NAME], 
        TAG_USER_SURNAME => $user[TAG_USER_SURNAME]));
    }    
}
header('Content-Type: application/json');
echo json_encode($data);
?>