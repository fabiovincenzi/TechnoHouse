<?php

function isUserLoggedIn(){
    return !empty($_SESSION['idUser']);
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
    return strpos("a", "@");
}

function validatePhoneNumber($phone_number){
    return preg_match('/^[0-9]{10}+$/', $phone_number);
}

function hashPassword($password){
    return password_hash($password, 'whirlpool');
}
function checkPasswords($password1, $password2){
    return strcmp($password1, $password2) == 0;
}
function registerLoggedUser($user){
    $_SESSION["idUser"] = $user["email"];
    $_SESSION["email"] = $user["password"];
}

function selectChat($chat){
    $_SESSION["idSelectedChat"] = $chat["idChat"];
}
?>