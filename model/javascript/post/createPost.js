function generateForm(){
    let form = `
    <div class="justify-content-center row">
                <div class="col-10 col-md-10 bg-white shadow rounded overflow-hidden mt-2">
                    <form action="#" method="POST">
                        <div class="row m-2">

                            <div class="col-md-6">
                                <label for="title">Title</label>
                                <input type="text" class="form-control mb-2" id="title" placeholder="Title" required>
                                
                                <div class="mb-3">
                                    <label for="images" class="form-label">Load Images</label>
                                    <input class="form-control" type="file" id="images" multiple required>
                                </div>
                                <label for="tags">Tags</label>
                                <select id="tags" class="form-select mt-2" multiple aria-label="Tags">
                                </select>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tagModal">
                                New Tag
                                </button>
                                <!-- New Tag Modal -->
            <div class="modal fade" id="tagModal" tabindex="-1" role="dialog" aria-labelledby="tagModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="tagModalLabel">New tag</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">Insert the new Tag here:</label>
                                    <input class="form-control" id="newTag" rows="3"></input>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-primary" onclick="addTag()" data-dismiss="modal">Save Tag</button>
                        </div>
                    </div>
                </div>
            </div>
                                <!--description-->
                                <label for="description" id="lbl-description">Description</label>
                                <textarea class="form-control" id="description" title="post description" rows="3"></textarea>
                                <!--description-->
                                <label for="price">Price</label>
                                <input type="number" step="any" class="form-control" id="price" placeholder="Price" required>  
                            </div> 
                            <div class="col-md-6">
                                <label for="region">Region</label>
                                <select onchange="loadProvincies();" class="form-select" id="region" aria-label="Region"required>
                                <option selected>Select a region</option>
                                </select>      
                                <label for="province">Province</label>
                                <select onchange="loadCities();" class="form-select" id="province" aria-label="Province"required>
                                    <option selected>Select a region first</option>
                                </select>         
                                <label for="city">City</label>
                                <select class="form-select" id="city" aria-label="City"required>
                                    <option selected>Select a province first</option>
                                </select>        
                                <label for="address">Address</label>
                                <input type="text" class="form-control" id="address" placeholder="Address" required>  
                                <!--map-->
                                <div id="map" class="map-style"></div>
                                <!--map-->
                            </div>
                            <div class="justify-content-center row mt-2">
                                <input type="submit" value="Create" class="btn btn-primary col-6 col-md-2">
                            </div>
                        </div>
                    </form>  
                            
                </div>
            </div>
    `;
    return form;
}

function addTag(){
    const tag = document.getElementById(`newTag`);
    const formTag = new FormData();
    formTag.append('tagName', tag.value);
    axios.post('model/php/api/api-create-tag.php', formTag).then(val =>{
        console.log(val);
        tag.value = "";
        addTags();
    });
}

function addTags(){
    axios.get(`model/php/api/api-tags.php`).then(tags =>{
        tags = tags.data;
        const tagSelect = document.getElementById("tags");
        tagSelect.innerHTML ="";
        tags.forEach(el=>{
            tagSelect.innerHTML += `<option value="${el["idTag"]}">${el["tagName"]}</option>`;
        });
    });
}

function createPost(title, description, price, latitude, longitude, city_id, address, formImages, formTags){
    const formPost = new FormData();
    formPost.append('title', title);
    formPost.append('description', description);
    formPost.append('price', price);
    formPost.append('latitude', latitude);
    formPost.append('longitude', longitude);
    formPost.append('city_id', city_id);
    formPost.append('address', address);
    console.log(latitude);
    axios.post('model/php/api/api-create-post.php', formPost).then(response=>{
        console.log(response);
        axios.get(`model/php/api/api-last-user-post.php`).then(lastPost=>{
            formImages.append('lastPostId', lastPost.data[0]['idPost']);
            formTags.append('lastPostId', lastPost.data[0]['idPost']);
            axios.post('model/php/api/api-upload-post-images.php', formImages).then(res =>{
                console.log(res);
                if(res["errorMSG"]){
                    axios.get(`model/php/api/api-post.php?action=4&idPost=${lastPost.data[0]["idPost"]}`).then(res => {
                        //window.location.replace("./controller_profile.php");   
                    });
                }else{
                    axios.post('model/php/api/api-upload-post-tags.php', formTags).then(response =>{
                        //window.location.replace("./controller_profile.php");  
                    });
                }
            });
        });
    });
}

function loadRegions(){
    const regionSelect = document.getElementById("region");
    axios.get(`model/php/api/api-region.php`).then(regions =>{
        regions.data.forEach(region =>{
            const opt = document.createElement("option");
            opt.value = region["idRegion"];
            opt.innerHTML = region["regionName"];
            regionSelect.appendChild(opt);
        });
    });
}

function loadProvincies(){
    const regionSelect = document.getElementById("region");
    const provinceSelect = document.getElementById("province");
    const region_id = regionSelect.value;
    axios.get(`model/php/api/api-province.php?region_id=${region_id}`).then(provincies =>{
        provinceSelect.innerHTML = '';
        provincies.data.forEach(province =>{
            const opt = document.createElement("option");
            opt.value = province["initials"];
            opt.innerHTML = province["initials"] + "-" + province["provinceName"];
            provinceSelect.appendChild(opt);
        });
    });
}

function loadCities(){
    const provinceSelect = document.getElementById("province");
    const citySelect = document.getElementById("city");
    const province_id = provinceSelect.value;
    axios.get(`model/php/api/api-city.php?province_id=${province_id}`).then(cities =>{
        cities.data.forEach(city =>{
            const opt = document.createElement("option");
            opt.value = city["idCity"];
            opt.innerHTML = city["postCode"] + "-" + city["cityName"];
            citySelect.appendChild(opt);
        });
    });
}

function showCreatePostForm(){
            document.querySelector("form").addEventListener("submit", function (event) {
                event.preventDefault();
            const title = document.querySelector("#title").value;
            const description = document.querySelector("#description").value;
            const price = document.querySelector("#price").value;
            const position = marker.getLatLng();
            const latitude = position.lat;
            const longitude = position.lng;
            const city_id = document.querySelector("#city").value;
            const address = document.querySelector("#address").value;
            const options = document.querySelector("#tags").selectedOptions;
            const tags = Array.from(options).map(({ value }) => value);
            const images = document.querySelector("#images").files;
            const formImage = new FormData();

            for (let i = 0; i < images.length; i++) {
                let file = images[i];
                formImage.append('images[]', file);
            }

            const formTags = new FormData();
            for (let i = 0; i < tags.length; i++) {
                let tag = tags[i];
                formTags.append('tags[]', tag);
            }
            console.log(formTags);
            //const location = document.querySelector("#location").value;
            createPost(title, description, price, latitude, longitude, city_id, address, formImage, formTags);
    });
}


const main = document.querySelector("main");
    let form = generateForm();
    main.innerHTML = form;
    //initMap();
    addTags();
    showCreatePostForm();
    loadRegions();
    let map = L.map('map').setView([44, 12], 13);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);
let marker = new L.marker([44, 12],{
    draggable: true
}).addTo(map);

marker.on("drag", function(e) {
    let marker = e.target;
    let position = marker.getLatLng();
    map.panTo(new L.LatLng(position.lat, position.lng));
});