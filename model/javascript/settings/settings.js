const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);
const userId = urlParams.get('idUser');
const main = document.querySelector("main");
main.innerHTML = generateForm();
axios.get(`model/php/api/api-user-info.php?idUser=${userId}`).then(response=>{
    if(response.data["logged"]){
        if(response.data["me"]){
            console.log(response.data['users-info']);
            populateValues(response.data['users-info']);
        }else{
            //window.location.replace("./index.php");   
        }
    }else{
        //window.location.replace("./index.php");   
    }
});
addListener();

function populateValues(user_info){
    console.log(user_info);
    document.getElementById("name").value = user_info["name"];
    document.getElementById("surname").value = user_info["surname"];
    document.getElementById("phone-number").value = user_info["phoneNumber"];
    document.getElementById("birthdate").value = user_info["birthDate"];
    document.getElementById("email").value = user_info["email"];
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
                <h3 class="mb-5">Settings</h3>
                <p></p>
                <div class="form-outline mb-4">
                  <label for="name">Name</label>
                  <input type="text" id="name" placeholder="Name" class="form-control form-control-lg" />
                </div>
                <div class="form-outline mb-4">
                  <label for="surname">Surname</label>
                  <input type="text" id="surname" placeholder="Surname" class="form-control form-control-lg" />
                </div>

                <div class="form-outline mb-4">
                  <label for="phone-number">Phone number</label>
                  <input type="text" id="phone-number" placeholder="Phone number" class="form-control form-control-lg" />
                </div>

                <div class="form-outline mb-4">
                  <label for="birthdate">Birthdate</label>
                <input type="date" id="birthdate" name="trip-start" value="2018-07-22" min="1910-01-01">
                </div>

                <div class="form-outline mb-4">
                  <label for="email">Email</label>
                  <input type="email" id="email" placeholder="Email" class="form-control form-control-lg" />
                </div>

                <div class="form-outline mb-4">
                    <label for="confirm-password">Old Password</label>
                    <input type="password" id="old-password" placeholder="Old Password" class="form-control form-control-lg" />
                </div>
    
                <div class="form-outline mb-4">
                  <label for="password">Password</label>
                  <input type="password" id="new-password" placeholder="New Password" class="form-control form-control-lg" />
                </div>

                <div class="form-outline mb-4">
                  <label for="confirm-password">Confirm New Password</label>
                  <input type="password" id="confirm-new-password" placeholder="Confirm New Password" class="form-control form-control-lg" />
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
        event.preventDefault();
        const name = document.querySelector("#name").value;
        const surname = document.querySelector("#surname").value;
        const phone_number = document.querySelector("#phone-number").value;
        const birthdate = document.querySelector("#birthdate").value;
        const email = document.querySelector("#email").value;
        const old_password = document.querySelector("#old-password").value;
        const new_password = document.querySelector("#new-password").value;
        const conf_password = document.querySelector("#confirm-new-password").value;
        //console.log(name + " " + surname + " " + residence + " " + birthdate + " " + email + " " + password + " " + conf_password);
        submit(name, surname, phone_number, birthdate, email, old_password, new_password, conf_password);
    });
}

function submit(name, surname, phone_number, birthdate, email, old_password, new_password, conf_password){
    const formData = new FormData();
    formData.append('name', name);
    formData.append('surname', surname);
    formData.append('phone-number', phone_number);
    formData.append('birthdate', birthdate);
    formData.append('email', email);
    formData.append('old-password', old_password);
    formData.append('new-password', new_password);
    formData.append('confirm-password', conf_password);
    axios.post('model/php/api/api-settings.php', formData).then(response => {
        console.log(response);
        if (response.data["logged"]) {
          if(!response.data["error"]){
            window.location.replace("./index.php");               
          }else{
            document.querySelector("p").innerText = response.data["errorMSG"];
          }
        } else {
            //window.location.replace("./controller_login.php");               
        }
    });
}