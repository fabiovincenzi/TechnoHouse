<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/TechnoHouse/model/php/bootstrap.php';
$data[TAG_LOGGED] = false;

if(isUserLoggedIn()){
    $data[TAG_LOGGED] = true;
    $id = $_SESSION[TAG_USER_ID];
    if (!isset($_POST[TAG_USER_ID])) {
        $users = $dbh->getFollowing($id);
        $data[TAG_USER_FOLLOWING] = array();

        foreach($users as $info){
            $user = $dbh->getUserByID($info[TAG_USER_TO_FOLLOW])[0];
            array_push($data[TAG_USER_FOLLOWING],  array(TAG_USER_ID => $user[TAG_USER_ID], 
            TAG_USER_NAME => $user[TAG_USER_NAME], 
            TAG_USER_SURNAME => $user[TAG_USER_SURNAME]));
        }
    }else{
        //Add a new following inside the list of the user $id 
        $dbh->addFollowing($id, $_POST["target"]);
    }
}
header('Content-Type: application/json');
echo json_encode($data);
?>