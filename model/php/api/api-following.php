<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/TechnoHouse/model/php/bootstrap.php';
$data[TAG_LOGGED] = false;

if(isUserLoggedIn()){
    $data[TAG_LOGGED] = true;
    $id = $_SESSION[TAG_USER_ID];
    if (!isset($_POST[TAG_USER_ID]) && !isset($_GET[TAG_USER_ID])) {
        $users = $dbh->getFollowing($id);
        $data[TAG_USER_FOLLOWING] = array();
        foreach($users as $info){
            $user = $dbh->getUserByID($info[TAG_USER_TO_FOLLOW])[0];
            
            array_push($data[TAG_USER_FOLLOWING],  array(TAG_USER_ID => $user[TAG_USER_ID], 
            TAG_USER_NAME => $user[TAG_USER_NAME], 
            TAG_USER_SURNAME => $user[TAG_USER_SURNAME],
            TAG_USER_IMAGE => getRelativeDirUser($user[TAG_USER_ID]).$user[TAG_USER_IMAGE]));
        }
    }else if(isset($_GET[TAG_USER_ID])){
        $user_id = $_GET[TAG_USER_ID];
        $data[TAG_ME] = false;
        if ($user_id != $id) {
            $users = $dbh->getFollowing($user_id);
            $data[TAG_USER_FOLLOWING] = array();

            foreach ($users as $info) {
                $user = $dbh->getUserByID($info[TAG_USER_TO_FOLLOW])[0];
                array_push($data[TAG_USER_FOLLOWING], array(
                TAG_USER_ID => $user[TAG_USER_ID],
                TAG_USER_NAME => $user[TAG_USER_NAME],
                TAG_USER_SURNAME => $user[TAG_USER_SURNAME],
                TAG_USER_IMAGE => getRelativeDirUser($user[TAG_USER_ID]).$user[TAG_USER_IMAGE]
                )
                );
            }
        }else{
            $data[TAG_ME] = true;
        }
    }else{
        $dbh->addFollowing($id, $_POST["target"]);
    }
}
header('Content-Type: application/json');
echo json_encode($data);
?>