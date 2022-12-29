<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/model/php/bootstrap.php';

function isUserLoggedIn(){
    return !empty($_SESSION[TAG_USER_ID]);
}

function createDirUser($id_user){
    $path = DATA_DIR.DIR_SEPARATOR.strval($id_user);
    if (!is_dir($path)) {
        mkdir($path, 0777, true);
    }
}

function createDirUserPost($id_user, $id_post){
    $path = DATA_DIR.DIR_SEPARATOR.strval($id_user).DIR_SEPARATOR.strval($id_post);
    if (!is_dir($path)) {
        mkdir($path, 0777, true);
    }
}

function containsNumber($input){
    return (preg_match('~[0-9]+~', $input));
}

function checkBirthdate($date){
    $input_date = date_create_from_format('Y-m-d', $date);
    $now = new DateTime();
    return ($now->diff($input_date))->y >= 18;
}

function checkEmail($email){
    return strpos($email, "@");
}

function validatePhoneNumber($phone_number){
    return preg_match('/^[0-9]{10}+$/', $phone_number); 
}

function validatePassword($password){
    // Validate password strength
    $uppercase=preg_match('@[A-Z]@',$password);
    $lowercase=preg_match('@[a-z]@',$password);
    $number=preg_match('@[0-9]@',$password);
    $specialChars=preg_match('@[^\w]@',$password);
    return !$uppercase||!$lowercase||!$number||!$specialChars||strlen($password)< 12;
}

function hashPassword($password){
    return password_hash($password, PASSWORD_DEFAULT);
}
function checkPasswords($password1, $password2){
    return strcmp($password1, $password2) == 0;
}
function registerLoggedUser($user){
    $_SESSION[TAG_USER_ID] = $user[TAG_USER_ID];
    $_SESSION[TAG_USER_EMAIL] = $user[TAG_USER_EMAIL];
}

function selectChat($chat){
    $_SESSION["idSelectedChat"] = $chat["idChat"];
}
?>