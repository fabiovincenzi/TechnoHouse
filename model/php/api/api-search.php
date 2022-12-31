<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/TechnoHouse/model/php/bootstrap.php';
$result[TAG_LOGGED] = false;

if(isUserLoggedIn()){
    $result[TAG_LOGGED] = true;
    $id = $_SESSION[TAG_USER_ID];
    if(isset($_GET[TAG_SEARCH])){
        $str_searched = $_GET[TAG_SEARCH];
        if ($str_searched != "") {
            $result[TAG_SEARCH] = array();
            $users = $dbh->getAllUsers();

            foreach($users as $user){
                $name_surname = $user[TAG_USER_NAME].TAG_SEPARATOR.$user[TAG_USER_SURNAME];
                if (preg_match("/{$str_searched}/i", $name_surname)) {
                    array_push(
                        $result[TAG_SEARCH],
                        array(
                            TAG_USER_ID => $user[TAG_USER_ID],
                            TAG_USER_NAME => $user[TAG_USER_NAME],
                            TAG_USER_SURNAME => $user[TAG_USER_SURNAME],
                            TAG_USER_IMAGE => (getRelativeDirUser($user[TAG_USER_ID])).$user[TAG_USER_IMAGE]
                        )
                    );
                }
            }
            
        }
    }
}
header('Content-Type: application/json');
echo json_encode($result);
?>