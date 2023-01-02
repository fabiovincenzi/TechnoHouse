<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/TechnoHouse/model/php/bootstrap.php';
$result[ERROR] = false;
if(isset($_FILES["images"]) && isset( $_POST["lastPostId"])){
    $post = $dbh->getPostById($_POST["lastPostId"]);
    var_dump($post);
    $extensions = ['jpg', 'jpeg', 'png', 'gif'];

    $all_files = count($_FILES['images']['tmp_name']);
    print_r($all_files);
    $fileNames = [];
    for ($i = 0; $i < $all_files; $i++) {  
        $file_name = $_FILES['images']['name'][$i];
        $file_tmp = $_FILES['images']['tmp_name'][$i];
        $file_type = $_FILES['images']['type'][$i];
        $file_size = $_FILES['images']['size'][$i];
        $fileNames[] = $file_name;

        
        if ($file_size > 2097152) {
            $errors = 'File size exceeds limit: ' . $file_name . ' ' . $file_type;
        }
        if(!in_array($file_type, $extensions)){
            $errors ="Accettate solo le seguenti estensioni: ".implode(",", $extensions);
        }
        if (empty($errors)) {
            createDirUserPost($post[0]["User_idUser"],$post[0]["idPost"]);
            $dir = getDirUserPost($post[0]["User_idUser"],$post[0]["idPost"]);
            move_uploaded_file($file_tmp, $dir.$file_name);
            $dbh->addImage($file_name, $_POST["lastPostId"]);
        }else{
            $data[ERROR]= true;
        }
    }
}else{
    //file non caricato
    $data[ERROR]= true;
}
header('Content-Type: application/json');
echo json_encode(data);
?>