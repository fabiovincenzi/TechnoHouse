function generateForm(){
    let form = `
    <section class="vh-100" style="background-color: #508bfc;">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
          <div class="card shadow-2-strong" style="border-radius: 1rem;">
            <div class="card-body p-5 text-center">
              <form action="#" method="POST">
                <h3 class="mb-5">Sign up</h3>
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
                  <label for="password">Password</label>
                  <input type="password" id="password" placeholder="Password" class="form-control form-control-lg" />
                </div>

                <div class="form-outline mb-4">
                  <label for="confirm-password">Confirm Password</label>
                  <input type="password" id="confirm-password" placeholder="Confirm Password" class="form-control form-control-lg" />
                </div>
    
                <!-- Checkbox -->
                <div class="form-check d-flex justify-content-start mb-4">
                  <input class="form-check-input" type="checkbox" value="" id="form1Example3" />
                  <label class="form-check-label" for="form1Example3"> Remember password </label>
                </div>
                  <input class="btn btn-primary btn-lg btn-block w-100" name="submit" value="sign up" type="submit"/>
                  <span>Or </span><a href="./controller_login.php">Login</a>
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

function signup(name, surname, phone_number, birthdate, email, password, confirm_password){
    const formData = new FormData();
    formData.append('name', name);
    formData.append('surname', surname);
    formData.append('phone-number', phone_number);
    formData.append('birthdate', birthdate);
    formData.append('email', email);
    formData.append('password', password);
    formData.append('confirm-password', confirm_password);
    axios.post('model/php/api/api-signup.php', formData).then(response => {
        console.log(response);
        if (response.data["logged"]) {
            //visualizzaArticoli(response.data["articoliautore"]);
            //Caricare il feed
        } else {
            document.querySelector("p").innerText = response.data["errorMSG"];
        }
    });
}

function visualizeSignupForm(){
    let form = generateForm();
    main.innerHTML = form;
    document.querySelector("form").addEventListener("submit", function (event) {
        event.preventDefault();
        const name = document.querySelector("#name").value;
        const surname = document.querySelector("#surname").value;
        const phone_number = document.querySelector("#phone-number").value;
        const birthdate = document.querySelector("#birthdate").value;
        const email = document.querySelector("#email").value;
        const password = document.querySelector("#password").value;
        const conf_password = document.querySelector("#confirm-password");
        //console.log(name + " " + surname + " " + residence + " " + birthdate + " " + email + " " + password + " " + conf_password);
        signup(name, surname, phone_number, birthdate, email, password, conf_password);
    });
    
}

const main = document.querySelector("main");
const input = document.getElementById("submit-form");
axios.get('model/php/api/api-signup.php').then(response => {
    console.log(response);
    if (response.data["logged"]) {
        // Utente loggato
        // redirect to another page
        //visualizzaArticoli(response.data["articoliautore"]);
    } else {
        // Utente NON loggato
        visualizeSignupForm();
    }
});