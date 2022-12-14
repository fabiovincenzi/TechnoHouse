<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/TechnoHouse/model/php/bootstrap.php';
$data[TAG_LOGGED] = false;

if (isUserLoggedIn()) {
    $data[TAG_LOGGED] = true;
    $id = $_SESSION[TAG_USER_ID];
    $file_name = $_FILES['images']['name'];
    $file_tmp = $_FILES['images']['tmp_name'];
    $file_type = $_FILES['images']['type'];
    $file_size = $_FILES['images']['size'];
    if ($file_size > 2097152) {
        $data[ERROR] = 'File size exceeds limit: ' . $file_name . ' ' . $file_type;
    }
    if (empty($data["errorMSG"])) {
        $dir = getUserDir($id);
        move_uploaded_file($file_tmp, $dir.$file_name);
        if($dbh->uploadUserIMG($id, $file_name)){
            $email = $dbh->getUserByID($id)[0][TAG_USER_EMAIL];
            sendEmail(MAIL_SOURCE, $email, SETTINGS_SUBJECT, IMAGE_MESSGAGE);
        }
    }
}
header('Content-Type: application/json');
echo json_encode($data);
?>