<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/TechnoHouse/model/php/bootstrap.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/model/php/util/functions.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/database/database.php';

$result["logged"] = false;
$error_occurred = false;
if(isset($_POST["name"]) && isset($_POST["surname"]) && isset($_POST["phone-number"]) && isset($_POST["birthdate"]) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["confirm-password"])){
    if (!isUserLoggedIn()) {
        $name = $_POST["name"];
        $surname = $_POST["surname"];
        if (containsNumber($name) && !$error_occurred) {
            $result["errorMSG"] = "Error : The parameter NAME contains one or more numbers";
            $error_occurred = true;
        }
        if (containsNumber($surname) && !$error_occurred) {
            $result["errorMSG"] = "Error : The parameter SURNAME contains one or more numbers";
            $error_occurred = true;
        }
        $phone_number = $_POST["phone-number"];
        if(!validatePhoneNumber($phone_number) && !$error_occurred){
            $result["errorMSG"] = "Error : The parameter SURNAME contains one or more numbers";
            $error_occurred = true;
        }
        $date = $_POST["birthdate"];
        if (!checkBirthdate($date) && !$error_occurred) {
            $result["errorMSG"] = "Error : In order to use this site you must be at least eighteen";
            $error_occurred = true;
        }
        $email = $_POST["email"];
        if (!checkEmail($email) && !$error_occurred) {
            $result["errorMSG"] = "Error : The Email's format is wrong. Did you forgot the @ ?";
            $error_occurred = true;
        }
        $password = hashPassword($_POST["password"]);
        $conf_password = hashPassword($_POST["confirm-password"]);
        if (!checkPasswords($password, $conf_password) && !$error_occurred) {
            $result["errorMSG"] = "Error : The passwords are not equal. Please insert again the passwords";
            $error_occurred = true;
        }
        //$dbh->addUser();
    }else{
        //Carico il feed
    }
    //$password = hash('sha512', $password.$salt); // codifica la password usando una chiave univoca.

}else{
    //Controllo quale parametro manca
}
header('Content-Type: application/json');
echo json_encode($result);
?>