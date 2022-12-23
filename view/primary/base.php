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
<body>
    <div class="container">
        <div class="justify-content-center row">
            <div class="col-10 col-md-10 bg-white shadow rounded overflow-hidden mt-2">


                <!--profile name-->
                <div class="d-flex flex-row px-2 border-bottom">
                    <img class="rounded-circle" src="https://i.imgur.com/aoKusnD.jpg" alt="image profile of :"width="45">
                    <div class="d-flex flex-column flex-wrap ml-2">
                        <span class="font-weight-bold">Thomson ben</span>
                        <span class="text-black-50 time">40 minutes ago</span>
                    </div>
                </div>
                <!--profile name-->
                
                <!--post-->
                <div class="p-2">
                    <div class="row">
                        
                        <div class="col-md-6">
                            <!--Title-->
                            <div class="row">
                                <h1 class="col-9 tag-title">Casa Familiare</h1>
                                <span class="font-weight-bold col-3">Stato</span>
                            </div>
                             <!--Title-->

                            <!--images-->
                            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                                <ol class="carousel-indicators">
                                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                                </ol>
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <img class="d-block w-100" src="https://i.imgur.com/aoKusnD.jpg" alt="First slide">
                                    </div>
                                    <div class="carousel-item">
                                        <img class="d-block w-100" src="https://i.imgur.com/rSnSOKD.jpeg" alt="Second slide">
                                    </div>
                                    <div class="carousel-item">
                                        <img class="d-block w-100" src="https://i.imgur.com/0feWrAk.jpeg" alt="Third slide">
                                    </div>
                                </div>
                                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                                    prev
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                </a>
                                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                                    next
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                </a>
                            </div>
                            <!--images-->
                    
                            <!--save-->
                            <div class="row mt-2">
                                <button class="btn btn-primary col-6 m-2">Save</button>
                                <span class="col-5 font-weight-bold"> 7 saved</span>
                            </div>
                            <!--save-->

                            <!--tags-->
                            <a href="#">#giardino</a>
                            <a href="#">#garage</a>
                            <!--tags-->
                        </div>

                        <div class="col-md-6">
                            <!--description-->
                            <h2 class="font-14 mb-1 mt-2 tag-description">Descrizione</h2>
                            <p class="mb-2">Lorem ipsum dolor sit amet consectetur adipisicing elit. Unde fugit incidunt eum provident praesentium nulla impedit. Earum similique suscipit dolorum dolore possimus, numquam ab ipsum nemo tempore in? Iure, expedita.</p>
                            <!--description-->

                            <!--price-->
                            <span class="font-weight-bold">Price: 10€</span>
                            <!--price-->

                            <!--map-->
                            <div id="map-container-google-2" class="z-depth-1-half map-container m-2" style="height: 200px">
                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d11452.093538879488!2d12.2433589!3d44.1447625!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x132ca58ba97cf34f%3A0x9a4e66c64fd8978c!2sCampus%20di%20Cesena%20-%20Universit%C3%A0%20di%20Bologna%20-%20Alma%20Mater%20Studiorum!5e0!3m2!1sit!2sit!4v1670314646821!5m2!1sit!2sit" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                            </div>
                            <!--map-->

                            <!--questions-->
                            <div class="d-flex flex-row">
                                <div class="d-flex flex-column flex-wrap ml-2">
                                    <span class="font-weight-bold">Questions:</span>
                                    <ul class="dz-comments-list">
                                        <li>
                                            <div>
                                                <h3 class="font-14 mb-1 tag-question">Lucas Mokmana</h3>
                                                <p class="mb-2">Awesome app i ever used. great structure, and customizable for multipurpose. 😀😀</p>
                                            </div>
                                        </li>
                                        <li>
                                            <div>
                                                <h3 class="font-14 mb-1 tag-response">Lucas</h3>
                                                    <p class="mb-2">Yes I am also use this.🙂</p>
                                                </div>			
                                            </li>
                                        </ul>
                                    </div>
                            </div>
                            <!--questions-->
                        
                        </div>
                    </div>
                </div>
                <!--post-->
            </div>
        </div>
    </div>
    
    
    <nav class="navbar fixed-bottom navbar-expand bg-light justify-content-center">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="./home.php">
                <img class="px-2" src="./icons/house.svg" alt="home page"/>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="./search.php">
                <img class="px-2" src="./icons/search.svg" alt="search page"/>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="./notification.php">
                <img class="px-2" src="./icons/bell.svg" alt="notification page"/>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="./profile.php">
                <img class="px-2" src="./icons/person-circle.svg" alt="profile page"/>
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

