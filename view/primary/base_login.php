<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous"/>
    <link href="style/style.css" rel="stylesheet"/>
    <title>Document</title>
</head>
<body>
<main>
<?php
        if(isset($viewBag["page"])){
            require($viewBag["page"]);
        }
    ?>
</main>
<?php
if (isset($viewBag["script"])):
        foreach($viewBag["script"] as $script):?>
            <script src="<?php echo $script; ?>"></script>
<?php
        endforeach;
    endif;
?>
</body>
</html>

