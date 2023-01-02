<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/TechnoHouse/model/php/bootstrap.php';
$result[ERROR] = "";
if(isset($_FILES["images"]) && isset( $_POST["lastPostId"])){
    $post = $dbh->getPostById($_POST["lastPostId"]);
    $extensions = array("image/jpg", "image/jpeg", "image/png", "image/gif");

    $all_files = count($_FILES['images']['tmp_name']);
    $fileNames = [];
    for ($i = 0; $i < $all_files; $i++) {  
        $file_name = $_FILES['images']['name'][$i];
        $file_tmp = $_FILES['images']['tmp_name'][$i];
        $file_type = $_FILES['images']['type'][$i];
        $file_size = $_FILES['images']['size'][$i];
        $fileNames[] = $file_name;

        if ($file_size > 2097152) {
            $result[ERROR] = 'File size exceeds limit: ' . $file_name . ' ' . $file_type;
        }
        if(!in_array($file_type, $extensions)){
            $result[ERROR] = "Only the following extensions are accepted: ".implode(",", $extensions);
        }
        if (empty($errors)) {
            createDirUserPost($post[0]["User_idUser"],$post[0]["idPost"]);
            $dir = getDirUserPost($post[0]["User_idUser"],$post[0]["idPost"]);
            move_uploaded_file($file_tmp, $dir.$file_name);
            $dbh->addImage($file_name, $_POST["lastPostId"]);
        }
    }
}else{
    //file non caricato
    $result[ERROR]= "error on attributes";
}
header('Content-Type: application/json');
echo json_encode($result);
?>