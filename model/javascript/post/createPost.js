function generateForm(){
    let form = `
    <div class="justify-content-center row">
                <div class="col-10 col-md-10 bg-white shadow rounded overflow-hidden mt-2">
                    <form action="#" method="POST">
                        <div class="row m-2">

                            <div class="col-md-6">
                                <label for="title">Title</label>
                                <input type="text" class="form-control mb-2" id="title" placeholder="Title">
                                
                                <div class="mb-3">
                                    <label for="images" class="form-label">Load Images</label>
                                    <input class="form-control" type="file" id="images" multiple>
                                </div>
                                <label for="tags">Tags</label>
                                <select id="tags" class="form-select mt-2" multiple aria-label="Tags">
                                </select>
                                <!--description-->
                                <label for="description" id="lbl-description">Description</label>
                                <textarea class="form-control" id="description" title="post description" rows="3"></textarea>
                                <!--description-->
                                <label for="price">Price</label>
                                <input type="number" class="form-control" id="price" placeholder="Price">  
                            </div>
                            <div class="col-md-6">
                                <label for="region">Region</label>
                                <select onchange="loadProvincies();" class="form-select" id="region" aria-label="Region">
                                <option selected>Select a region</option>
                                </select>      
                                <label for="province">Province</label>
                                <select onchange="loadCities();" class="form-select" id="province" aria-label="Province">
                                    <option selected>Select a region first</option>
                                </select>         
                                <label for="city">City</label>
                                <select class="form-select" id="city" aria-label="City">
                                    <option selected>Select a province first</option>
                                </select>        
                                <label for="address">Address</label>
                                <input type="text" class="form-control" id="address" placeholder="Address">  
                                <!--map-->
                                <div id="map"></div>
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
var map;
function initMap() {    
    map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: -34.397, lng: 150.644},
        zoom: 9
    });
    
    var marker = new google.maps.Marker({
    position: {lat: -34.397, lng: 150.644},
    map: map,
    title: 'Hello World!',
    animation: google.maps.Animation.BOUNCE,
    draggable: true
    });

}
function addTags(tags){
    const tagSelect = document.getElementById("tags");
    tags.forEach(el=>{
        tagSelect.innerHTML += `<option value="${el["idTag"]}">${el["tagName"]}</option>`;
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
    axios.post('model/php/api/api-create-post.php', formPost).then(response=>{
        axios.get(`model/php/api/api-last-user-post.php`).then(lastPost=>{
            formImages.append('lastPostId', lastPost.data[0]['idPost']);
            formTags.append('lastPostId', lastPost.data[0]['idPost']);
            axios.post('model/php/api/api-upload-post-images.php', formImages).then(res =>{
                console.log(res);
            });
            axios.post('model/php/api/api-upload-post-tags.php', formTags).then(response =>{
                //console.log(response);
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
            const latitude = 10;
            const longitude = 20;
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
axios.get(`model/php/api/api-tags.php`).then(tags =>{
    let form = generateForm();
    main.innerHTML = form;
    initMap();
    addTags(tags.data);
    showCreatePostForm();
    loadRegions();
});