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
      console.log(response);
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
                        <img src="" alt="${user["name"]} ${user["surname"]} profile photo" width="130" class="rounded mb-2 img-thumbnail">
                    </div>
                    <div class="text-white col-7">
                        <h4 id="name-surname">${user["name"]} ${user["surname"]}</h4>
                    </div>
              </div>
              <div class="border-bottom p-4 justify-content-end text-center">
                 <ul class="list-inline mb-0">
                    <li class="list-inline-item">
                       <h5 class="font-weight-bold mb-0 d-block" id="n-photo">${user["n-photo"]}</h5>
                       <small class="text-muted"> <em class="fas fa-image mr-1"></em>Photos</small> 
                    </li>
                    <li class="list-inline-item">
                       <a class="font-weight-bold mb-0 d-block" id="followers" data-bs-toggle="modal" data-bs-target="#modal-info">
                        ${user["followers"]}
                       </a>
                       <small class="text-muted"> <em class="fas fa-user mr-1"></em>Followers</small> 
                    </li>
                    <li class="list-inline-item">
                       <a class="font-weight-bold mb-0 d-block" id="following" data-bs-toggle="modal" data-bs-target="#modal-info">${user["following"]}</a>
                       <small class="text-muted"> <em class="fas fa-user mr-1"></em>Following</small> 
                    </li>
                 </ul>
                 <input id="action" class="btn btn-primary btn-lg btn-block w-100" name="${value}" type="submit" value="${value}"/>
                 </div>
              <div class="px-4 py-3">
                 <h5 class="mb-0">About</h5>
                 <div class="p-4 rounded shadow-sm bg-light">
                    <p class="font-italic mb-0">Web Developer</p>
                    <p class="font-italic mb-0">Lives in New York</p>
                    <p class="font-italic mb-0">Photographer</p>
                 </div>
              </div>
              <div class="py-4 px-4">
                 <div class="d-flex align-items-center justify-content-between mb-3">
                    <h5 class="mb-0">Recent photos</h5>
                    <a href="#" class="btn btn-link text-muted">Show all</a> 
                 </div>
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
      console.log(response);
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
      <li class="p-2 border-bottom bg-white">
         <a id="profile" href="./controller_otheruser.php?idUser=${user["idUser"]}" class="d-flex justify-content-between chatListLine">
            <div class="d-flex flex-row">
               <!--chat image-->
               <img src="" alt="${user["name"]} ${user["surname"]} profile image"
               class="rounded-circle d-flex align-self-center me-3 shadow-1-strong chatListLine" width="60">
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
         console.log(images.data);
         console.log(post["idPost"]);
         let single_post = `
         <img src="upload/${images.data[0]["path"]}" alt="${post["name"]} photo" class="col-md-4 col-6 img-fluid rounded shadow-sm">
        `;
         div_posts.innerHTML += single_post;
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
      console.log(info);
      axios.get(`model/php/api/api-follow.php?idUser=${userId}&action=${info===true?1:2}`).then(response => {
         console.log(response);
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
}