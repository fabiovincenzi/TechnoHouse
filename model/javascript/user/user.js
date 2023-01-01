const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);
const userId = urlParams.get('idUser');
const main = document.querySelector('main');

if(userId !== null){
    axios.get(`model/php/api/api-profile.php?idUser=${userId}`).then(response => {
        if(response.data["logged"]){
            if(!response.data["me"]){
               let users_info = response.data["users-info"];
               axios.get(`model/php/api/api-follow.php?idUser=${userId}`).then(response=>{
                  console.log(response);
                  let info = response.data["follow"];
                  main.innerHTML = generateProfile(users_info, info);
                  addListeners(info);
                  addPosts();
               })
            }else{
               window.location.replace("./controller_profile.php");   
            }
        }else{
            window.location.replace("./controller_login.php");   
        }
    });
}

function addPosts(){
   const div_posts = document.getElementById("users-posts");
   axios.get(`model/php/api/api-post.php?idUser=${userId}`).then(response => {
      let posts = response.data["users-posts"];
      generatePosts(div_posts, posts);
   });
}

function generateProfile(user, info){
   let value = info === true ? "Unfollow" : "Follow";
    let page = `
        <div class="justify-content-center row">
            <div class="col-10 col-md-10 bg-white shadow rounded overflow-hidden">
 
              <div class="p-4 bg-black row">
                    <div class="mr-3 col-5">
                        <img src="${user["userImage"]}" alt="${user["name"]} ${user["surname"]} profile photo" width="130" class="rounded mb-2 img-thumbnail">
                    </div>
                    <div class="text-white col-7">
                        <h4 id="name-surname">${user["name"]} ${user["surname"]}</h4>
                    </div>
              </div>
              <div class="border-bottom p-4 justify-content-end text-center">
                 <ul class="list-inline mb-0">
                    <li class="list-inline-item">
                           <h5 class="font-weight-bold mb-0 d-block" id="n-photo">${user["n-photo"]}</h5>
                           <small class="text-muted">Photos</small> 
                    </li>
                    <li class="list-inline-item">
                     <a class="text-dark text-decoration-none cursor font-weight-bold" id="followers" data-bs-toggle="modal" data-bs-target="#modal-info">
                       <h5 class="font-weight-bold mb-0 d-block">${user["followers"]}</h5> 
                        <small class="text-muted">Followers</small> 
                       </a>
                    </li>
                    <li class="list-inline-item">
                        <a class="text-dark text-decoration-none cursor font-weight-bold" id="following" data-bs-toggle="modal" data-bs-target="#modal-info">
                           <h5 class="font-weight-bold mb-0 d-block">${user["following"]}</h5> 
                           <small class="text-muted">Following</small> 
                       </a>
                    </li>
                 </ul>
                 
                 <div class="row">
                  <div class="col-md-6">
                     <button id="action" class="btn btn-secondary m-2 btn-lg btn-block w-100" name="${value}" type="submit">${value}</button>
                  </div>
                  <div class="col-md-6">
                     <button id="send-message" class="m-2 btn btn-secondary btn-lg btn-block w-100" name="Send a Message" type="submit" >Send a message</button>
                  </div>
                 </div>
                 </div>
              <div class="py-4 px-4">
                 <div class="row" id="users-posts">
                 </div>
              </div>
           </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="modal-info" tabindex="-1" aria-labelledby="modal-title" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="modal-title"></h5>
                <button id="button-close-up" type="button" class="button-close btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <ul id="modal-list" class="list-unstyled mb-0">
                </ul>
              </div>
              <div class="modal-footer">
                <button id="button-close-down" type="button" class="button-close btn btn-secondary" data-bs-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
    `
    return page;
}

function addFollowers(list){
   axios.get(`model/php/api/api-followers.php?idUser=${userId}`).then(response=>{
      let followers = response.data["followers"];
      populateList(followers, list);
   });
}

function addFollowing(list){
   axios.get(`model/php/api/api-following.php?idUser=${userId}`).then(response=>{
      let following = response.data["following"];
      populateList(following, list);
   });
}

function populateList(users, list){
   users.forEach(user => {
      let list_item = `
      <li class="p-2 border m-2 rounded bg-white">
         <a id="profile" href="./controller_otheruser.php?idUser=${user["idUser"]}" class="d-flex justify-content-between chatListLine">
            <div class="d-flex flex-row">
               <!--chat image-->
               <img src="${user["userImage"]}" alt="${user["name"]} ${user["surname"]} profile image"
               class="rounded-circle d-flex align-self-center me-3 shadow-1-strong chatListLine" width="50"/>
               <!--chat image-->
               <div class="pt-1">
                     <!--Name-->
                     <p class="fw-bold mb-0">${user["name"]} ${user["surname"]}</p>
                     <!--Name-->
               </div>
            </div>
         </a>
      </li>
      `
      list.innerHTML+=list_item;
   });
}

function generatePosts(div_posts, posts){
   let content = "";
   posts.forEach(post => {
      axios.get(`model/php/api/api-post-images.php?id=${post["idPost"]}`).then(images =>{
         if(images.data.length > 0){
            let single_post = `
            <div class="col-md-4 col-6 p-2">
               <a id="${post["idPost"]}" href="./controller_single_post.php?idPost=${post["idPost"]}">
               <img src="${images.data[0]["path"]}" alt="${post["name"]} photo" class="img-fluid rounded shadow-sm">
               </a>
            </div>`;
            div_posts.innerHTML += single_post;
         }
      });
   });
}

function clearList(list){
   list.innerHTML = "";
}

function addListeners(info){
   const title = document.getElementById("modal-title");
   const list = document.getElementById("modal-list");
   document.getElementById('followers').addEventListener("click", function(evenet){
      clearList(list);
      title.innerText = "Followers";
      addFollowers(list);
   });
   document.getElementById('following').addEventListener("click", function(evenet){
      clearList(list);
      title.innerText = "Following";
      addFollowing(list);
   });
   let input = document.getElementById('action');
   input.addEventListener("click", function(event){
      axios.get(`model/php/api/api-follow.php?idUser=${userId}&action=${info===true?1:2}`).then(response => {
         if(info === true){
            input.value = "Follow";
            info = false;
         }else{
            input.value = "Unfollow";
            info = true;
         }
         location.reload()
      });

   });
   document.getElementById('send-message').addEventListener("click", function(event){
      axios.get(`model/php/api/api-create-chat.php?idUser=${userId}`).then(response=>{
         if(response.data["logged"]){
            window.location.replace(`./controller_chat.php?idChat=${response.data["idChat"]}`);
         }
      });
   });
}