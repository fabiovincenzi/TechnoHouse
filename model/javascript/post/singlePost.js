const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);
const postId = urlParams.get('idPost');
axios.get(`model/php/api/api-post.php?action=2`).then(posts => {
    const main = document.querySelector("main");
    let postHtml = createPost(post);
    main.innerHTML += postHtml;
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
        console.log(locationInfo.data)
        loadLocationInfoToPost(locationInfo.data[0], post);
    });
    updateSave(post["idPost"]);  
});     

function createPost(post){
    let postHtml = `
    <div class="justify-content-center row">
            <div class="col-10 col-md-10 bg-white shadow rounded overflow-hidden mt-2">

    <!--profile name-->
                <div class="d-flex flex-row px-2 border-bottom">
                    <div id="imgUser${post["idPost"]}"></div>
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
                                <button class="btn btn-primary col-6 m-2" onclick="save(${post["idPost"]})">Save</button>
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
    userContainer.innerHTML +=`<a href="./controller_otheruser.php?idUser=${user["idUser"]}"><span class="font-weight-bold">${user["name"]} ${user["surname"]}</span></a>`;
    const userImgContainer = document.getElementById(`imgUser${post["idPost"]}`);
    userImgContainer.innerHTML +=`<img class="rounded-circle" src="${user["userImage"]}" alt="image profile of :"width="45">`;
    
                    
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
    axios.get(`model/php/api/api-post-save.php?id=${postId}`).then(saved=>{
        loadSavedToPost(saved.data[0]["saved"], postId);
    });  
}

function save(postId){
    axios.get(`model/php/api/api-save-post.php?postId=${postId}`).then(val =>{
        updateSave(postId);
    });
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
        answer.value = "";
        updateAnswer(questionId);
    });
}