const main = document.querySelector('main');
axios.get('model/php/api/api-random-posts.php').then(response => {
    console.log(response.data);
    if(response.data["logged"]){
        main.innerHTML = generateBase();
        addListener();
        addPosts(response.data["search-post"]);
    }else{
       //window.location.replace("./controller_login.php");
    }
});


function generateBase(){
    let base = `
        <div class="justify-content-center row">
            <div class="col-10 col-md-10 bg-white shadow rounded overflow-hidden">
            <nav class="navbar fixed-top navbar-light bg-blur p-3">
                <label for="search-bar" type="">Search</label>
                <input type="search" id="search-bar" class="form-control" placeholder="Search" aria-label="Search" />
            </nav>
        <div>

        <ul id="content-search" class="search-margin-top list-unstyled">
           
        </ul>
        </div>`;
        return base;
}

function addListener(){
    let input = document.getElementById("search-bar");
    input.addEventListener('input', function (evt) {
        let value = input.value;
        if(!value){
            randomPosts();
        }else{
            addSearched(value);
        }
    });
}

function randomPosts(){
    axios.get('model/php/api/api-random-posts.php').then(response => {
        if(response.data["logged"]){
            addPosts(response.data["search-post"]);
        }else{
           //window.location.replace("./controller_login.php");
        }
    });
}

function addSearched(value){
    axios.get(`model/php/api/api-search.php?search=${value}`).then(response => {
        if(response.data["logged"]){
            addUsers(response.data["search"]);
        }else{
           //window.location.replace("./controller_login.php");
        }
    });
}

function addUsers(users){
    const ul = document.getElementById('content-search');
    ul.innerHTML = "";
    users.forEach(element => {
            let list_item = `
            <li>
                <div class="container">
                    <div class="row">
                    <div class="col-sm">
                        <img src="${element["userImage"]}" alt="${element["name"]} ${element["surname"]} profile picture" width="100">
                        <a href ="./controller_otheruser.php?idUser=${element["idUser"]}">
                            <p>${element["name"]} ${element["surname"]} </p>
                        </a>
                    </div>
                </div>
            </li>`;
        ul.innerHTML += list_item;
    });
}

function addPosts(elements){
    const ul = document.getElementById('content-search');
    ul.innerHTML = "";
    elements.forEach(element => {
        let list_item = `
            <li>
                <div class="container">
                    <div class="row">
                    <div class="col-sm">
                        <img src="${element["path"]}" alt="${element["title"]} profile picture" width="100">
                        <a href ="./controller_single_post.php?idPost=${element["idPost"]}">
                            <p>${element["title"]}</p>
                            <p>${element["description"]}</p>
                        </a>
                    </div>
                </div>
            </li>`;
            ul.innerHTML +=list_item;
    });
}

/*

            <li>
                <div class="container">
                    <div class="row">
                        <div class="col-sm">
                        <img src="https://i.imgur.com/aoKusnD.jpg" alt="profile's picture of : NAME" width="100">
                        </div>
                        <div class="col-sm">
                        <img src="https://i.imgur.com/aoKusnD.jpg" alt="profile's picture of : NAME" width="100">
                        </div>
                        <div class="col-sm">
                        <img src="https://i.imgur.com/aoKusnD.jpg" alt="profile's picture of : NAME" width="100">
                        </div>
                    </div>
                    </div>
            </li>
*/