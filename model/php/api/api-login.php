<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/TechnoHouse/model/php/bootstrap.php';
$result["logged"] = false;

if(isset($_POST[TAG_USER_EMAIL]) && isset($_POST[TAG_USER_PASSWORD])){
    $email = $_POST[TAG_USER_EMAIL];
    $password = $_POST[TAG_USER_PASSWORD];
    $login_result = $dbh->checkLogin($email, $password);
    //var_dump($_SESSION);
    //var_dump($login_result);
    if (count($login_result) > 0) {
        registerLoggedUser(array(TAG_USER_ID=>$login_result[0][TAG_USER_ID], TAG_USER_EMAIL=>$email));
    } else {
        $result[ERROR] = "Error : The ".$dbh->getErrorString()." is not correct";
    }
    
}
if(isUserLoggedIn()){
    $result["logged"] = true;
}
header('Content-Type: application/json');
echo json_encode($result);

?>