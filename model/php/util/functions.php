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
    $path = getDirUserPost($id_user, $id_post);
    if (!is_dir($path)) {
        mkdir($path, 0777, true);
    }
}

function getDirUserPost($id_user, $id_post){
    return DATA_DIR.DIR_SEPARATOR.strval($id_user).DIR_SEPARATOR.strval($id_post).DIR_SEPARATOR;
}

function getUserDir($id){
    return DATA_DIR.strval($id).DIR_SEPARATOR;
}

function getRelativeDirUser($id_user){
    return "data/".strval($id_user).DIR_SEPARATOR;
}

function getRelativeDirUserPost($id_user, $id_post){
    return "data/".strval($id_user).DIR_SEPARATOR.strval($id_post).DIR_SEPARATOR;
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
    return !$uppercase||!$lowercase||!$number||!$specialChars||strlen($password)< 12||strlen($password) > 20;
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

function newFollowerNotification($dbh, $targetUser, $sourceUser){
    echo TAG_USER_ID;
    date_default_timezone_set('Europe/Rome');
    $time = date('Y-m-d H:i:s', time());
    $dbh->createNewFollowerNotification($targetUser, $sourceUser, $time);
}
function newSaveNotification($dbh, $targetUser, $sourceUser, $post){
    date_default_timezone_set('Europe/Rome');
    $time = date('Y-m-d H:i:s', time());
    $dbh->createNewSaveNotification($targetUser, $sourceUser, $post, $time);
}
function newQuestionNotification($dbh, $targetUser, $sourceUser, $post){
    date_default_timezone_set('Europe/Rome');
    $time = date('Y-m-d H:i:s', time());
    $dbh->createNewQuestionNotification($targetUser, $sourceUser, $post, $time);
}
function newAnswerNotification($dbh, $targetUser, $sourceUser, $post){
    date_default_timezone_set('Europe/Rome');
    $time = date('Y-m-d H:i:s', time());
    $dbh->createNewAnswerNotification($targetUser, $sourceUser, $post, $time);
}
function newPostNotification($dbh, $sourceUser, $post){
    date_default_timezone_set('Europe/Rome');
    $time = date('Y-m-d H:i:s', time());
    $followers = $dbh->getFollowers($sourceUser);
    foreach ($followers as $follower) {
        $dbh->createNewPostNotification($follower["User_idUser"], $sourceUser, $post, $time);
    }
} 
function newMessageNotification($dbh, $chat){
    date_default_timezone_set('Europe/Rome');
    $time = date('Y-m-d H:i:s', time());
    $sourceUser = $_SESSION[TAG_USER_ID];
    $targetUser = $chat["User_idUser"]==$_SESSION[TAG_USER_ID]?$chat["User_idUser1"]:$chat["User_idUser"];
    $dbh->createNewMessageNotification($targetUser, $sourceUser, $chat["idChat"], $time);
} 

function sendEmail($from, $to, $subject,$message){
    $headers = 'From:'.'<'.$from.'>'. "\r\n" .
    'Reply-To:'.'<'.$to.'>';    
    return @mail("<".$to.">", $subject, $message, $headers);
}
function deleteAll($dir) {
    foreach(glob($dir . '/*') as $file) {
    if(is_dir($file))
    deleteAll($file);
    else
    unlink($file);
    }
    rmdir($dir);
}

function uploadImage($path, $image){
    $imageName = basename($image["name"]);
    $fullPath = $path.$imageName;
    
    $maxKB = 500;
    $acceptedExtensions = array("jpg", "jpeg", "png", "gif");
    $result = 0;
    $msg = "";
    //Controllo se immagine è veramente un'immagine
    $imageSize = getimagesize($image["tmp_name"]);
    if($imageSize === false) {
        $msg .= "File caricato non è un'immagine! ";
    }
    //Controllo dimensione dell'immagine < 500KB
    if ($image["size"] > $maxKB * 1024) {
        $msg .= "File caricato pesa troppo! Dimensione massima è $maxKB KB. ";
    }

    //Controllo estensione del file
    $imageFileType = strtolower(pathinfo($fullPath,PATHINFO_EXTENSION));
    if(!in_array($imageFileType, $acceptedExtensions)){
        $msg .= "Accettate solo le seguenti estensioni: ".implode(",", $acceptedExtensions);
    }

    //Controllo se esiste file con stesso nome ed eventualmente lo rinomino
    if (file_exists($fullPath)) {
        $i = 1;
        do{
            $i++;
            $imageName = pathinfo(basename($image["name"]), PATHINFO_FILENAME)."_$i.".$imageFileType;
        }
        while(file_exists($path.$imageName));
        $fullPath = $path.$imageName;
    }

    //Se non ci sono errori, sposto il file dalla posizione temporanea alla cartella di destinazione
    if(strlen($msg)==0){
        if(!move_uploaded_file($image["tmp_name"], $fullPath)){
            $msg.= "Errore nel caricamento dell'immagine.";
        }
        else{
            $result = 1;
            $msg = $imageName;
        }
    }
    return array($result, $msg);
}

?>