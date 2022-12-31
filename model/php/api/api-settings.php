<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/TechnoHouse/model/php/bootstrap.php';


$result["logged"] = false;

if(isUserLoggedIn()){
$id = $_SESSION[TAG_USER_ID];
$result["logged"] = true;
$result["error"] = true;
if(isset($_POST["name"]) && isset($_POST["surname"]) && isset($_POST["phone-number"]) && isset($_POST["birthdate"]) && isset($_POST["email"]) && isset($_POST["old-password"]) && isset($_POST["new-password"]) && isset($_POST["confirm-password"])){
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
                        if (!checkEmail($email) ) {
                            $result["errorMSG"] = "Error : The Email's format is wrong. Did you forgot the @ ?";
                        } else {
                            //controllo numero telefono
                            //controllo email
                            if($dbh->userCheckEmail($id, $email)){
                                if($dbh->userCheckPhone($id, $phone_number)){
                                    if($_POST[TAG_OLD_PSW] == "" && $_POST[TAG_NEW_PSW] == "" && $_POST[TAG_CONFIRM_PSW] == ""){

                                        if($dbh->updateUser($id, $name, $surname, $phone_number, $date, $email)){
                                            $result["error"] = false;
                                        }else{
                                            $result["errorMSG"] = "Error : The email already exist";
                                        }
                                    }else{
                                        $old_psw = $_POST[TAG_OLD_PSW];
                                        $new_psw = $_POST[TAG_NEW_PSW];
                                        $conf_psw = $_POST[TAG_CONFIRM_PSW];
                                        if(validatePassword($new_psw)){
                                            $result["errorMSG"] = "Error : Password should be at least 12 characters in lenght and should include at least one upper case letter, one number and one special character";
                                        }else{
                                            if(!checkPasswords($new_psw, $conf_psw)){
                                                $result["errorMSG"] = "Error : The passwords are not equal. Please insert again the passwords";
                                            }else{
                                                if(password_verify($old_psw, $dbh->getUserByID($id)[0][TAG_USER_PASSWORD])){
                                                    $dbh->updateTotalUser($id, $name, $surname, $phone_number, $date, $email, $new_psw);
                                                    $result["error"] = false;
                                                }else{
                                                    $result["errorMSG"] = "Error : The old password does not exists";   
                                                }
                                            }
                                        }
                                    }
                                }else{
                                    $result["errorMSG"] = "Error : The phone number already exits";   
                                }
                            }else{
                                $result["errorMSG"] = "Error : The email already exits";
                            }
                           
                        }
                    }
                }
            }
        }
    }
}

header('Content-Type: application/json');
echo json_encode($result);
?>