const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);
const postId = urlParams.get('idPost');
axios.get(`model/php/api/api-post.php?action=3&idPost=${postId}`).then(post => {
    post = post.data[0];
    const main = document.querySelector("main");
    let postHtml = createPost(post);
    main.innerHTML += postHtml;
    loadMap(post);
    axios.get(`model/php/api/api-post-images.php?id=${post["idPost"]}`).then(images =>{
        loadImagesToPost(images.data, post);
    });
    axios.get(`model/php/api/api-post-tags.php?id=${post["idPost"]}`).then(tags =>{
        loadTagsToPost(tags.data, post);
    });
    updateQuestions(post["idPost"]);
    
    axios.get(`model/php/api/api-user.php?id=${post["User_idUser"]}`).then(user=>{
        loadUserToPost(user.data[0], post);
    });
    axios.get(`model/php/api/api-location-info.php?id=${post["idPost"]}`).then(locationInfo=>{
        loadLocationInfoToPost(locationInfo.data[0], post);
    });
    updateSave(post["idPost"]);  
    deleteButton(post);
});     

function createPost(post){
    let postHtml = `
    <div class="justify-content-center row">
            <div class="col-10 col-md-10 bg-white shadow rounded overflow-hidden mt-2">

    <!--profile name-->
                <div class="row px-2 border-bottom">
                    <div class="col-md-8 d-flex flex-row ">
                        <div id="imgUser${post["idPost"]}">
                        </div>
                        <div id="user${post["idPost"]}">
                        </div>
                        <br/>
                        <span class="text-black-50 time">published on  ${post["PublishTime"].split(' ')[0]} at ${post["PublishTime"].split(' ')[1]}</span>
                    </div>
                    <div class="text-right col-md-2 d-flex flex-column flex-wrap ml-2">
                        <div id="delete${post["idPost"]}">
                        </div>
                    </div>
                    <!--profile name-->
                </div>
                <!--post-->
                <div class="p-2">
                    <div class="row">
                        
                            <!--Title-->
                            <div class="row">
                                <h1 class="col-9 tag-title">${post["title"]}</h1>
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
                                <button id="saveBtn${post["idPost"]}" class="btn btn-primary col-6 m-2" onclick="save(${post["idPost"]})">Save</button>
                                <div id="saved${post["idPost"]}"></div>
                            </div>
                            <!--save-->
                            <!--tags-->
                            <div id="tags${post["idPost"]}">
                            </div>
                            <!--tags-->
                            <!--Location info-->
                            <span id="locationInfo${post["idPost"]}" class="font-weight-bold"></span>
                            <!--Location info-->



                            <!--price-->
                            <span class="font-weight-bold">Price: ${post["price"]}€</span>
                            <!--price-->

                            <!--map-->
                            <div id="map${post["idPost"]}" class="map-style"></div>
                            <!--map--> 
                            <!--questions-->
                            <div class="d-flex flex-row">
                                <div class="d-flex flex-column flex-wrap ml-2">
                                    <span class="font-weight-bold">Questions:</span>
                                    <ul id="questions${post["idPost"]}" class="dz-comments-list">
                                    </ul>
                                    </div>
                            </div>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#questionModal${post["idPost"]}">
                            New question
                            </button>
                            
                            <!-- New Question Modal -->
                            <div class="modal fade" id="questionModal${post["idPost"]}" tabindex="-1" role="dialog" aria-labelledby="questionModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="questionModalLabel">New question</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form>
                                                <div class="form-group">
                                                    <label for="exampleFormControlTextarea1">Insert the question here:</label>
                                                    <textarea class="form-control" id="newQuestion${post["idPost"]}" rows="3"></textarea>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                <button type="button" class="btn btn-primary" onclick="newQuestion(${post["idPost"]})" data-dismiss="modal">Send question</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--questions-->
                            <div id="modalContainer${post["idPost"]}">
                            </div>
                            
                        
                        <div class="row">
                        <!--description-->
                        <h2 class="font-14 mb-1 mt-2 tag-description">Descrizione</h2>
                        <p class="mb-2">${post["description"]}</p>
                        <!--description-->
                        </div>
                    </div>
                </div>
                <!--post-->
                </div>
        </div>
                `;
                return postHtml;
}

function deleteButton(post){
    axios.get(`model/php/api/api-actual-user.php`).then(user => {
        console.log(user);
        user= user.data["user"][0];
        if(user["idUser"]===post["User_idUser"]){
            const btnContainer = document.getElementById(`delete${post["idPost"]}`);
            btnContainer.innerHTML = `<button type="button" class="btn btn-danger" onclick="deletePost(${post["idPost"]})">Delete</button>`;
        }
    }); 
}

function deletePost(post){
    axios.get(`model/php/api/api-post.php?action=4&idPost=${post}`).then(res => {
        window.location.replace("./controller_profile.php");   
    });
}

function loadUserToPost(user, post){
    const userContainer = document.getElementById(`user${post["idPost"]}`);
    userContainer.innerHTML +=`<a class="text-dark text-decoration-none p-2" href="./controller_otheruser.php?idUser=${user["idUser"]}"><span class="font-weight-bold">${user["name"]} ${user["surname"]}</span></a>`;
    const userImgContainer = document.getElementById(`imgUser${post["idPost"]}`);
    userImgContainer.innerHTML +=`<img class="p-1 rounded-circle" src="${user["userImage"]}" alt="image profile of :"width="45">`;
    
                    
}

function loadLocationInfoToPost(locationInfo, post){
    const userContainer = document.getElementById(`locationInfo${post["idPost"]}`);
    userContainer.innerHTML +=`${locationInfo["Region"]}, ${locationInfo["Province"]}, ${locationInfo["City"]}(${locationInfo["PostCode"]}), ${post["Address"]}`;
}

function loadAnswersToQuestion(answers, questionId){
    const answersContainer = document.getElementById(`answers${questionId}`);
    
    answersContainer.innerHTML="";
    answers.forEach(el =>{
        answersContainer.innerHTML +=`
                    <li>
                        <div>
                            <h5 class="font-8 mb-1 tag-question">${el["name"]} ${el["surname"]}</h3>
                            <p class="mb-2">${el["text"]}</p>
                        </div>
                    </li>`;
    });
}

function loadQuestionsToPost(questions, postId){
    const questionsContainer = document.getElementById(`questions${postId}`);
    const modalContainer = document.getElementById(`modalContainer${postId}`);
    questionsContainer.innerHTML="";
    questions.forEach(el =>{
        questionsContainer.innerHTML +=`
                    <li>
                        <div>
                            <h5 class="font-8 mb-1 tag-question">${el["name"]} ${el["surname"]}</h3>
                            <p class="mb-2">${el["text"]} <a href="#answerModal${el["idQuestion"]}" data-toggle="modal" data-target="#answerModal${el["idQuestion"]}">Answer</a></p>
                        </div>
                        <ul id="answers${el["idQuestion"]}">
                        <ul>
                    </li>`;
        modalContainer.innerHTML += `<!-- New Answer Modal -->
        <div class="modal fade" id="answerModal${el["idQuestion"]}" tabindex="-1" role="dialog" aria-labelledby="questionModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id=answerModalLabel">New answer</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">${el["text"]}</label>
                                <textarea class="form-control" id="newAnswer${el["idQuestion"]}" rows="3"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary" onclick="newAnswer(${el["idQuestion"]})" data-dismiss="modal">Send answer</button>
                    </div>
                </div>
            </div>
        </div>`;
        updateAnswer(el["idQuestion"]);
    });
}

function loadTagsToPost(tags, post){
    const tagsContainer = document.getElementById(`tags${post["idPost"]}`);
    tags.forEach(el=>{
        tagsContainer.innerHTML += `<a href="#">#${el["tagName"]}</a>`;
    });
}

function loadImagesToPost(images, post){
    console.log(images);
    const imgContainer = document.getElementById(`images${post["idPost"]}`);
    let i = 0;
    images.forEach(el=>{
        if(i == 0){
            imgContainer.innerHTML += `<div class="carousel-item active">
            <img class="d-block w-100" src="${el["path"]}" alt="First slide">
        </div>`;
        }else{
            imgContainer.innerHTML += `<div class="carousel-item">
            <img class="d-block w-100" src="${el["path"]}" alt="First slide">
        </div>`;
        }
        i++;
    });
}

function loadSavedToPost(saved, postId){
    const savedContainer = document.getElementById(`saved${postId}`);
    savedContainer.innerHTML = `<span class="col-5 font-weight-bold"> ${saved} saved</span>`;
} 

function updateQuestions(postId){
    axios.get(`model/php/api/api-questions.php?id=${postId}`).then(questions => {
        loadQuestionsToPost(questions.data, postId);
    }); 
}

function updateAnswer(questionId){
    axios.get(`model/php/api/api-answer.php?id=${questionId}`).then(answer => {
        loadAnswersToQuestion(answer.data, questionId);
    }); 
}

function updateSave(postId){
    axios.get(`model/php/api/api-savedposts.php`).then(response=>{
        let savedPosts = response.data["saved"];
        let saved = false;
        savedPosts.forEach(post =>{
            if(post["idPost"] === postId){
                saved = true;
            }
        });
        const btn = document.getElementById(`saveBtn${postId}`);
        btn.textContent = saved?"Unsave":"Save";
    });
    axios.get(`model/php/api/api-post-save.php?id=${postId}`).then(saved=>{
        loadSavedToPost(saved.data[0]["saved"], postId);
    });  
}

function save(postId){
    axios.get(`model/php/api/api-savedposts.php`).then(response=>{
        let savedPosts = response.data["saved"];
        let saved = false;
        savedPosts.forEach(post =>{
            if(post["idPost"] === postId){
                saved = true;
            }
        });
        if(saved){
            axios.get(`model/php/api/api-save-post.php?action=2&postId=${postId}`).then(val =>{
                updateSave(postId);
            });
        }else{
            axios.get(`model/php/api/api-save-post.php?action=1&postId=${postId}`).then(val =>{
                updateSave(postId);
            });
        }
    });
}

function loadMap(post){
    let map = L.map(`map${post["idPost"]}`).setView([post["latitude"], post["LONGITUDE"]], 6);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);
    let marker = new L.marker([post["latitude"], post["LONGITUDE"]],{
    }).addTo(map);
}


function newQuestion(postId){
    const question = document.getElementById(`newQuestion${postId}`);
    const formQuestion = new FormData();
    formQuestion.append('postId', postId);
    formQuestion.append('question', question.value);
    axios.post('model/php/api/api-create-question.php', formQuestion).then(val =>{
        question.value = "";
        updateQuestions(postId);
    });
}
function newAnswer(questionId){
    const answer = document.getElementById(`newAnswer${questionId}`);
    const formAnswer = new FormData();
    formAnswer.append('questionId', questionId);
    formAnswer.append('answer', answer.value);
    axios.post('model/php/api/api-create-answer.php', formAnswer).then(val =>{
        console.log(val);
        answer.value = "";
        updateAnswer(questionId);
    });
}