const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);
const userId = urlParams.get('idUser');
const main = document.querySelector("main");
main.innerHTML = generateForm();
axios.get(`model/php/api/api-user-info.php?idUser=${userId}`).then(response=>{
    if(response.data["logged"]){
        if(response.data["me"]){
            console.log(response.data['users-info']);
        }else{
            window.location.replace("./index.php");   
        }
    }else{
        window.location.replace("./controller_login.php");   
    }
});


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
                <div id="user-image" class="mr-3 col-5">
                </div>
                <div class="mb-4">
                    <label for="profile-image" class="form-label">Load Image</label>
                    <input class="form-control image" type="file" id="profile-image">
                </div>
                  
              </div>
              </form>
          </div>
        </div>
      </div>
    </div>
  </section>
  <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="modalLabel">Crop image</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
              </button>
          </div>
          <div class="modal-body">
              <div class="img-container">
                  <div class="row">
                      <div class="col-md-8">  
                          <!--  default image where we will set the src via jquery-->
                          <img id="image">
                      </div>
                      <div class="col-md-4">
                          <div class="preview"></div>
                      </div>
                  </div>
              </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              <button type="button" class="btn btn-primary" id="crop">Set new Image</button>
          </div>
      </div>
  </div>
</div>

</div>
</div>
    `
    return form;
}


function submit(image){
    const formData = new FormData();
    formData.append('images', image);
    axios.post("model/php/api/api-user-image.php", formData).then(response => {
        window.location.replace("./controller_profile.php");   
    });
}

var bs_modal = $('#modal');
    var image = document.getElementById('image');
    var cropper,reader,file;
   

    $("body").on("change", ".image", function(e) {
        var files = e.target.files;
        var done = function(url) {
            image.src = url;
            bs_modal.modal('show');
        };


        if (files && files.length > 0) {
            file = files[0];

            if (URL) {
                done(URL.createObjectURL(file));
            } else if (FileReader) {
                reader = new FileReader();
                reader.onload = function(e) {
                    done(reader.result);
                };
                reader.readAsDataURL(file);
            }
        }
    });

    bs_modal.on('shown.bs.modal', function() {
        cropper = new Cropper(image, {
            aspectRatio: 1,
            viewMode: 3,
            preview: '.preview'
        });
    }).on('hidden.bs.modal', function() {
        cropper.destroy();
        cropper = null;
    });

    $("#crop").click(function() {
        canvas = cropper.getCroppedCanvas({
            width: 160,
            height: 160,
        });
        canvas.toBlob(function(blob) {
            let file = new File([blob], "user.jpg", { type: "image/jpeg" })
            submit(file);
        });
    });