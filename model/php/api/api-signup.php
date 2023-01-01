<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/TechnoHouse/model/php/bootstrap.php';


$result[TAG_LOGGED] = false;
if(isset($_POST["name"]) && isset($_POST["surname"]) && isset($_POST["phone-number"]) && isset($_POST["birthdate"]) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["confirm-password"])){
    if (!isUserLoggedIn()) {
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
                        if (!checkEmail($email)) {
                            $result[ERROR] = "Error : The Email's format is wrong. Did you forgot the @ ?";
                        } else {
                            if (validatePassword($_POST[TAG_USER_PASSWORD])) {
                                $result[ERROR] = "Error : Password should be at least 12 characters in lenght and at most 20 characters in lenght and should include at least one upper case letter, one number and one special character";
                            } else {
                                $password = $_POST[TAG_USER_PASSWORD];
                                $conf_password = $_POST[TAG_CONFIRM_PSW];
                                if (!checkPasswords($password, $conf_password)) {
                                    $result["errorMSG"] = "Error : The passwords are not equal. Please insert again the passwords";
                                }else{
                                    $login_result = $dbh->addUser($name, $surname, $date, $phone_number, $email, $password, DEFAULT_IMAGE);
                                    if($login_result){
                                        $id = $dbh->getUserInfo(TAG_USER_ID, $email);
                                        createDirUser($id);
                                        $dir = getUserDir($id);
                                        move_uploaded_file(DIR_DATA_DEFAULT . DEFAULT_IMAGE, $dir . $id);
                                        registerLoggedUser(array(TAG_USER_ID=>$id,TAG_USER_EMAIL => $email));
                                        $result[TAG_LOGGED] = true;
                                        sendEmail(MAIL_SOURCE, $email, WELCOME_SUBJECT, WELCOME_MESSAGE);
                                    }else{
                                        $result[ERROR] = "Error : The ".$dbh->getErrorString()." already exist";
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }else{
        $result[TAG_LOGGED] = true;
    }
}else{
    if(!isset($_POST[TAG_USER_NAME])){
        $result[ERROR] = "Error : You must put the NAME";
    }else if(!isset($_POST[TAG_USER_SURNAME])){
        $result[ERROR] = "Error : You must put the SURNAME";
    }else if(!isset($_POST[TAG_PHONE_NUMBER])){
        $result[ERROR] = "Error : You must put the PHONE-NUMBER";
    }else if(!isset($_POST[TAG_BIRTHDATE])){
        $result[ERROR] = "Error : You must put the BIRTHDATE";
    }else if(!isset($_POST[TAG_USER_EMAIL])){
        $result[ERROR] = "Error : You must put the EMAIL";
    }else if(!isset($_POST[TAG_USER_PASSWORD])){
        $result[ERROR] = "Error : You must put the PASSWORD";
    }else if(!isset($_POST[TAG_CONFIRM_PSW])){
        $result[ERROR] = "Error : You must confirm the PASSWORD";
    }
}
if(isUserLoggedIn()){
    $result[TAG_LOGGED] = true;
}
header('Content-Type: application/json');
echo json_encode($result);
?>