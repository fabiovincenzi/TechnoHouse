<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/TechnoHouse/model/php/bootstrap.php';


$result["logged"] = false;

if(isUserLoggedIn()){
$id = $_SESSION[TAG_USER_ID];
$result["logged"] = true;
$result["error"] = true;
if(isset($_POST[TAG_USER_NAME]) && isset($_POST[TAG_USER_SURNAME]) && isset($_POST[TAG_PHONE_NUMBER]) && isset($_POST[TAG_BIRTHDATE]) && isset($_POST[TAG_USER_EMAIL]) && isset($_POST[TAG_OLD_PSW]) && isset($_POST[TAG_NEW_PSW]) && isset($_POST[TAG_CONFIRM_PSW])){
        $name = $_POST[TAG_USER_NAME];
        if (containsNumber($name)) {
            $result[ERROR] = "Error : The parameter NAME contains one or more numbers";
        } else {
            $surname = $_POST[TAG_USER_SURNAME];
            if (containsNumber($surname)) {
                $result[ERROR] = "Error : The parameter SURNAME contains one or more numbers";
            } else {
                $phone_number = $_POST[TAG_PHONE_NUMBER];
                if (!validatePhoneNumber($phone_number)) {
                    $result[ERROR] = "Error : The parameter PHONE-NUMBER must contains only numbers and It must be 10 values";
                } else {
                    $date = $_POST[TAG_BIRTHDATE];
                    if (!checkBirthdate($date)) {
                        $result[ERROR] = "Error : In order to use this site you must be at least eighteen";
                    } else {
                        $email = $_POST[TAG_USER_EMAIL];
                        if (!checkEmail($email) ) {
                            $result[ERROR] = "Error : The Email's format is wrong. Did you forgot the @ ?";
                        } else {
                            //controllo numero telefono
                            //controllo email
                            if($dbh->userCheckEmail($id, $email)){
                                if($dbh->userCheckPhone($id, $phone_number)){
                                    if($_POST[TAG_OLD_PSW] == "" && $_POST[TAG_NEW_PSW] == "" && $_POST[TAG_CONFIRM_PSW] == ""){

                                        if($dbh->updateUser($id, $name, $surname, $phone_number, $date, $email)){
                                            $result["error"] = false;
                                            $email = $dbh->getUserByID($id)[0][TAG_USER_EMAIL];
                                            sendEmail(MAIL_SOURCE, $email, SETTINGS_SUBJECT, USER_MESSGAGE);
                                        }else{
                                            $result[ERROR] = "Error : The email already exist";
                                        }
                                    }else{
                                        $old_psw = $_POST[TAG_OLD_PSW];
                                        $new_psw = $_POST[TAG_NEW_PSW];
                                        $conf_psw = $_POST[TAG_CONFIRM_PSW];
                                        if(validatePassword($new_psw)){
                                            $result[ERROR] = "Error : Password should be at least 12 characters in lenght and at most 20 characters in lenght and should include at least one upper case letter, one number and one special character";
                                        }else{
                                            if(!checkPasswords($new_psw, $conf_psw)){
                                                $result[ERROR] = "Error : The passwords are not equal. Please insert again the passwords";
                                            }else{
                                                if(password_verify($old_psw, $dbh->getUserByID($id)[0][TAG_USER_PASSWORD])){
                                                    $email = $dbh->getUserByID($id)[0][TAG_USER_EMAIL];
                                                    sendEmail(MAIL_SOURCE, $email, SETTINGS_SUBJECT, PASSWORD_MESSGAGE);
                                                    $dbh->updateTotalUser($id, $name, $surname, $phone_number, $date, $email, $new_psw);
                                                    $result["error"] = false;
                                                }else{
                                                    $result[ERROR] = "Error : The old password does not exists";   
                                                }
                                            }
                                        }
                                    }
                                }else{
                                    $result[ERROR] = "Error : The phone number already exits";   
                                }
                            }else{
                                $result[ERROR] = "Error : The email already exits";
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