function createPost(post){
    let postHtml = `
    <div class="justify-content-center row">
            <div class="col-10 col-md-10 bg-white shadow rounded overflow-hidden mt-2">

    <!--profile name-->
                <div class="d-flex flex-row px-2 border-bottom">
                    <img class="rounded-circle" src="https://i.imgur.com/aoKusnD.jpg" alt="image profile of :"width="45">
                    <div class="d-flex flex-column flex-wrap ml-2">
                    <div id="user${post["idPost"]}"></div>
                        <span class="text-black-50 time">pubblicato il ${post["PublishTime"].split(' ')[0]} alle ${post["PublishTime"].split(' ')[1]}</span>
                    </div>
                </div>
                <!--profile name-->
                
                <!--post-->
                <div class="p-2">
                    <div class="row">
                        
                        <div class="col-md-6">
                            <!--Title-->
                            <div class="row">
                                <h1 class="col-9 tag-title">${post["title"]}</h1>
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
                                <div id="images${post["idPost"]}" class="carousel-inner">
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
                            <div id="tags${post["idPost"]}">
                            </div>
                            <!--tags-->
                        </div>

                        <div class="col-md-6">
                            <!--description-->
                            <h2 class="font-14 mb-1 mt-2 tag-description">Descrizione</h2>
                            <p class="mb-2">${post["description"]}</p>
                            <!--description-->

                            <!--price-->
                            <span class="font-weight-bold">Price: ${post["price"]}€</span>
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
                                    <ul id="questions${post["idPost"]}" class="dz-comments-list">
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
                `;
                return postHtml;
}

function loadUserToPost(user, post){
    const userContainer = document.getElementById(`user${post["idPost"]}`);
    userContainer.innerHTML +=`<span class="font-weight-bold">${user["name"]} ${user["surname"]}</span>`;
}

function loadQuestionsToPost(questions, post){
    const questionsContainer = document.getElementById(`questions${post["idPost"]}`);
    questions.forEach(el =>{
        questionsContainer.innerHTML +=`
                    <li>
                        <div>
                            <h5 class="font-8 mb-1 tag-question">${el["name"]} ${el["surname"]}</h3>
                            <p class="mb-2">${el["text"]}</p>
                        </div>
                    </li>`;
    });
}

function loadTagsToPost(tags, post){
    const tagsContainer = document.getElementById(`tags${post["idPost"]}`);
    tags.forEach(el=>{
        tagsContainer.innerHTML += `<a href="#">#${el["tagName"]}</a>`;
    });
}

function loadImagesToPost(images, post){
    const imgContainer = document.getElementById(`images${post["idPost"]}`);
    let i = 0;
    images.forEach(el=>{
        if(i == 0){
            imgContainer.innerHTML += `<div class="carousel-item active">
            <img class="d-block w-100" src="upload/${el["path"]}" alt="First slide">
        </div>`;
        }else{
            imgContainer.innerHTML += `<div class="carousel-item">
            <img class="d-block w-100" src="upload/${el["path"]}" alt="First slide">
        </div>`;
        }
        i++;
    });
}

axios.get(`model/php/api/api-post.php?action=2`).then(posts => {
    posts.data.forEach(post => {                
        const main = document.querySelector("main");
        let postHtml = createPost(post);
        main.innerHTML += postHtml;
        axios.get(`model/php/api/api-post-images.php?id=${post["idPost"]}`).then(images =>{
            loadImagesToPost(images.data, post);
        });
        axios.get(`model/php/api/api-post-tags.php?id=${post["idPost"]}`).then(tags =>{
            loadTagsToPost(tags.data, post);
        });
        axios.get(`model/php/api/api-questions.php?id=${post["idPost"]}`).then(questions => {
            loadQuestionsToPost(questions.data, post);
        }); 
        axios.get(`model/php/api/api-user.php?id=${post["User_idUser"]}`).then(user=>{
            loadUserToPost(user.data[0], post);
        });       
    });
});

