<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/TechnoHouse/model/php/bootstrap.php';
$data[TAG_LOGGED] = false;

if(isUserLoggedIn()){
    $data[TAG_LOGGED] = true;
    if (!isset($_POST[TAG_USER_ID])) {
        $users = $dbh->getFollowing($_SESSION[TAG_USER_ID]);
        $data[TAG_USER_FOLLOWING] = array();

        foreach($users as $info){
            $user = $dbh->getUserByID($info["User_idUser1"]);
            array_push($data[TAG_USER_FOLLOWING], $user);
        }
    }else{
        var_dump($_POST);
        $dbh->addFollowing($_SESSION[TAG_USER_ID], $_POST["target"]);
    }
}
header('Content-Type: application/json');
echo json_encode($data);
?>