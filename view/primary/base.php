<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous"/>
    <link href="style/style.css" rel="stylesheet"/>
    
    <title>
        <?php
        echo $viewBag["title"];
        ?>
    </title>
</head>
<body class="body-padding-bottom">
    <main>
    <div class="container">
    <?php
        if(isset($viewBag["page"])){
            require($viewBag["page"]);
        }
    ?>
    </div>
    </main>
    <!-- NAVBAR DA POPOLARE DINAMICAMENTE -->
    <nav class="navbar fixed-bottom navbar-expand bg-light justify-content-center">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="./index.php">
                <img class="px-2" src="./icons/house.svg" alt="home page"/>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="./controller_search.php">
                <img class="px-2" src="./icons/search.svg" alt="search page"/>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="./controller_notifications.php">
                <img class="px-2" src="./icons/bell.svg" alt="notification page"/>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="./controller_profile.php">
                <img class="px-2" src="./icons/person-circle.svg" alt="profile page"/>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="./controller_create_post.php">
                <img class="px-2" src="./icons/add.svg" alt="add a new post"/>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="./controller_chats.php">
                <img class="px-2" src="./icons/chat.svg" alt="chats page"/>
            </a>
        </li>
    </ul>
</nav>
<?php if(isset($viewBag["script"])):
        foreach($viewBag["script"] as $script):?>
    <script src="<?php echo $script; ?>"></script>
    <?php
        endforeach;
    endif;
    ?>
</body>
</html>

