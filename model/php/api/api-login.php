<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/TechnoHouse/model/php/bootstrap.php';
$result["logged"] = false;

if(isset($_POST["email"]) && isset($_POST["password"])){
    $email = $_POST["email"];
    $password = $_POST["password"];
    if(count($dbh->checkEmail($email)) == 0){
        $result["errorMSG"] = "Error : The input email does not exists";
    } else {
        $login_result = $dbh->checkLogin($email, $password);
        //var_dump($login_result);
        if ($login_result) {
            registerLoggedUser(array("id"=>$, "email"=>$email));
        } else {
            $result["errorMSG"] = "Error : The password is not correct";
        }
    }
}
if(isUserLoggedIn()){
    $result["logged"] = true;
}
header('Content-Type: application/json');
echo json_encode($result);

?>