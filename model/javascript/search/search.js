const main = document.querySelector('main');
axios.get('model/php/api/api-search.php').then(response => {
    console.log(response.data);
    if(response.data["logged"]){
        main.innerHTML = generateBase();
        addPosts(response.data["search-post"]);
    }else{
        window.location.replace("./controller_login.php");
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
                <nav class="navbar fixed-top navbar-light bg-blur p-3">
                    <label for="search-bar" type="">Search</label>
                    <input type="search" id="search-bar" class="form-control" placeholder="Search" aria-label="Search" />
                </nav>
        <div>

        <ul id="content-search">
           
        </ul>
        </div>`;
        return base;
}

function addPosts(posts){
    const ul = document.getElementById('content-search');
    let cont = 0;
    let content = "";
    posts.forEach(element => {
        let div_item = `
            <div class="col-sm">
                    <a href="./controller_single-post.php?idPost=${element["idPost"]}">
                        <img src="${element["path"]}" alt="${element["title"]} post image" width="100"/>
                    </a>
            </div>`;

        if(cont % 3 == 0){
            let list_item = `
                <li>
                    <div class="container">
                        <div class="row">
                            ${content};
                        </div>
                    </div>
                </li>`;
            ul.innerHTML +=list_item;
            content = "";
            cont = 0;
        }else{
            content += div_item;
            cont +=1;
        }
    });
    if(cont > 0){
        let list_item = `
        <li>
            <div class="container">
                <div class="row">
                    ${content};
                </div>
            </div>
        </li>`;
        ul.innerHTML +=list_item;
    }
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