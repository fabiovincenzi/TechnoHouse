const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);
const userId = urlParams.get('idUser');
const main = document.querySelector("main");
main.innerHTML = generateForm();
axios.get(`model/php/api/api-user-info.php?idUser=${userId}`).then(response=>{
    if(response.data["logged"]){
        if(response.data["me"]){
            console.log(response.data['users-info']);
            addUserIMG(response.data['users-info']);
            addListener();
        }else{
            window.location.replace("./index.php");   
        }
    }else{
        window.location.replace("./controller_login.php");   
    }
});

function addUserIMG(user){
    document.getElementById("user-image").innerHTML = `<img src="${user["userImage"]}" alt="${user["name"]} ${user["surname"]} profile image" />`
}

function generateForm(){
    let form = `
    <section class="vh-100" style="background-color: #508bfc;">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
          <div class="card shadow-2-strong" style="border-radius: 1rem;">
            <div class="card-body p-5 text-center">
              <form action="#" method="POST">
                <h3 class="mb-5">Change Photo</h3>
                <p></p>
                <div>
                <div id ="user-image" class="mb-4">
                    
                 </div>
                <div class="mb-4">
                    <label for="image" class="form-label">Load Image</label>
                    <input class="form-control" type="file" id="image">
                </div>
                  <input id ="change" class="btn btn-primary btn-lg btn-block w-100" name="submit" value="Change" type="submit"/>
                  <span>
                  <br/>
              </div>
              </form>
          </div>
        </div>
      </div>
    </div>
  </section>
    `
    return form;
}

function addListener(){
    document.querySelector("form").addEventListener("submit", function (event) {
        console.log("ciao");
        event.preventDefault();
        const image = document.querySelector("#image").files;
        console.log(image[0]);
        submit(image[0]);
    });
}

function submit(image){
    const formData = new FormData();
    formData.append('images', image);
    axios.post("model/php/api/api-user-image.php", formData).then(response => {
        console.log(response);
    });
}
