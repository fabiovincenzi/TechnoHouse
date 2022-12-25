<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/TechnoHouse/model/php/bootstrap.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/model/php/util/functions.php';
$result["logged"] = false;

if(isset($_POST["name"]) && isset($_POST["surname"]) && isset($_POST["residence"]) && isset($_POST["birthdate"]) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["confirm-password"])){
    $name = $_POST["name"];
    $surname = $_POST["surname"];
    if(containsNumber($name)){
        $result["errorMSG"] = "Error : The parameter NAME contains one or more numbers";
    }
    if(containsNumber($surname)){
        $result["errorMSG"] = "Error : The parameter SURNAME contains one or more numbers";
    }
    $date = $_POST["birthdate"];
    if(!checkBirthdate($date)){
        $result["errorMSG"] = "Error : In order to use this site you must be at least eighteen";
    }
    $email = $_POST["email"];
    if(!checkEmail($email)){
        $result["errorMSG"] = "Error : The Email's format is wrong. Did you forgot the @ ?";
    }
    $password = hash('whirlpool', $_POST["password"]);
    $conf_password = hash('whirpool', $_POST["confirm-password"]);
    if(!checkPasswords($password, $conf_password)){
        $result["errorMSG"] = "Error : The passwords are not equal. Please insert again the passwords".$conf_password;
    }
    //$password = hash('sha512', $password.$salt); // codifica la password usando una chiave univoca.

}else{
    //Controllo quale parametro manca
}
header('Content-Type: application/json');
echo json_encode($result);
?>