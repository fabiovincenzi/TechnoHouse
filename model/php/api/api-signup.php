<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/TechnoHouse/model/php/bootstrap.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/model/php/util/functions.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/database/database.php';

$result["logged"] = false;
if(isset($_POST["name"]) && isset($_POST["surname"]) && isset($_POST["phone-number"]) && isset($_POST["birthdate"]) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["confirm-password"])){
    if (!isUserLoggedIn()) {
        $name = $_POST["name"];
        if (containsNumber($name)) {
            $result["errorMSG"] = "Error : The parameter NAME contains one or more numbers";
        } else {
            $surname = $_POST["surname"];
            if (containsNumber($surname)) {
                $result["errorMSG"] = "Error : The parameter SURNAME contains one or more numbers";
            } else {
                $phone_number = $_POST["phone-number"];
                if (!validatePhoneNumber($phone_number)) {
                    $result["errorMSG"] = "Error : The parameter PHONE-NUMBER must contains only numbers and It must be 10 values";
                } else {
                    $date = $_POST["birthdate"];
                    if (!checkBirthdate($date)) {
                        $result["errorMSG"] = "Error : In order to use this site you must be at least eighteen";
                    } else {
                        $email = $_POST["email"];
                        if (!checkEmail($email)) {
                            $result["errorMSG"] = "Error : The Email's format is wrong. Did you forgot the @ ?";
                        } else {
                            if (validatePassword($_POST["password"])) {
                                $result["errorMSG"] = "Error : Password should be at least 12 characters in lenght and should include at least one upper case letter, one number and one special character";
                            } else {
                                $password = $_POST["password"];
                                $conf_password = $_POST["confirm-password"];
                                if (!checkPasswords($password, $conf_password)) {
                                    $result["errorMSG"] = "Error : The passwords are not equal. Please insert again the passwords";
                                }else{
                                    $logged_user = $dbh->addUser($name, $surname, $date, $phone_number, $email, $password);
                                    var_dump($logged_user);
                                    if($logged_user){
                                        registerLoggedUser(array("email"=>$email,"password" => $password));
                                        $result["logged"] = true;
                                    }else{
                                        $result["errorMSG"] = "Error : The ".$dbh->getErrorString()." already exist";
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
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