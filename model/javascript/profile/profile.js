function generateProfile(user){
   console.log(user);
    let page = `
        <div class="justify-content-center row">
            <div class="col-10 col-md-10 bg-white shadow rounded overflow-hidden">
 
              <div class="p-4 bg-black row">
                    <div class="mr-3 col-5">
                        <img src="${user[0]["userImage"]}" alt="${user[0]["name"]} ${user[0]["surname"]} profile photo" width="130" class="rounded mb-2 img-thumbnail">
                    </div>
                    <div class="text-white col-7">
                        <h4 id="name-surname">${user[0]["name"]} ${user[0]["surname"]}</h4>
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
                    <li class="list-inline-item">
                        <a class="font-weight-bold mb-0 d-block" id="saved" data-bs-toggle="modal" data-bs-target="#modal-info">${user["saved"]}</a>
                        <small class="text-muted"> <em class="fas fa-user mr-1"></em>Saved</small> 
                     </li>
                 </ul>
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

function generatePosts(posts){
   const div_posts = document.getElementById("users-posts");
   posts.forEach(post => {
      axios.get(`model/php/api/api-post-images.php?id=${post["idPost"]}`).then(images =>{
         let single_post = `
         <a class="col-md-4 col-6 " id="${post["idPost"]}">
         <img src="${images.data[0]["path"]}" alt="${post["name"]} photo" class="img-fluid rounded shadow-sm">
         </a>`;
         div_posts.innerHTML+=single_post;
      });
   });
}

function populateList(users, list){
   console.log(users);
   users.forEach(user => {
      let list_item = `
      <li class="p-2 border-bottom bg-white">
         <a id="profile" href="./controller_otheruser.php?idUser=${user["idUser"]}" class="d-flex justify-content-between chatListLine">
            <div class="d-flex flex-row">
               <!--chat image-->
               <img src="${user["userImage"]}" alt="${user["name"]} ${user["surname"]} profile image"
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

function populateSaved(posts, list){
   console.log(posts.data);
   posts.forEach(post => {
      axios.get(`model/php/api/api-post-images.php?id=${post["idPost"]}`).then(images =>{
      let list_item = `
      <li class="p-2 border-bottom bg-white">
         <a id="profile" href="${post["idPost"]}" class="d-flex justify-content-between chatListLine">
            <div class="d-flex flex-row">
               <!--chat image-->
               <img src="${images.data[0]["path"]}" alt="${post["title"]} image"
               class="rounded-circle d-flex align-self-center me-3 shadow-1-strong chatListLine" width="60">
               <!--chat image-->
               <div class="pt-1">
                  <p class="fw-bold mb-0">${post["title"]}</p>
               </div>
            </div>
         </a>
      </li>`
      list.innerHTML+=list_item;
      });
   });
}

function addFollowers(list){
   axios.get('model/php/api/api-followers.php').then(response=>{
      let followers = response.data["followers"];
      populateList(followers, list);
   });
}

function addFollowing(list){
   axios.get('model/php/api/api-following.php').then(response=>{
      let following = response.data["following"];
      populateList(following, list);
   });
}

function addSavedPosts(list){
   axios.get('model/php/api/api-savedposts.php').then(response=>{
      console.log(response);
      let savedPosts = response.data["saved"];
      console.log(savedPosts);
      populateSaved(savedPosts, list);
   });
}

function clearList(list){
   list.innerHTML = "";
}

function addListeners(user_info){
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
   document.getElementById('saved').addEventListener("click", function(evenet){
      clearList(list);
      title.innerText = "Saved posts";
      addSavedPosts(list);
   });
}

function addUserInfo(user_infos){
   main.innerHTML = user_infos;
}

function visualizeProfile(){
   let posts = {};
   let user = {};
   
   axios.get('model/php/api/api-post.php?action=1').then(response => {
      if(response.data["logged"]){
         user = response.data["users-info"];
         posts = response.data["users-posts"];
         let content_profile = generateProfile(user);
         addUserInfo(content_profile);
         addListeners(user[0]);
         generatePosts(posts);
      }else{
         window.location.replace("./controller_login.php");   
      }
   });

}

const main = document.querySelector("main");
axios.get('model/php/api/api-profile.php').then(response => {
   if(response.data["logged"]){
      visualizeProfile();
   }else{
      window.location.replace("./controller_login.php");   
   }
});

