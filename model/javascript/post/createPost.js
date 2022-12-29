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
                                <div id="map-container-google-2" class="z-depth-1-half map-container m-2" style="height: 200px">
                                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d11452.093538879488!2d12.2433589!3d44.1447625!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x132ca58ba97cf34f%3A0x9a4e66c64fd8978c!2sCampus%20di%20Cesena%20-%20Universit%C3%A0%20di%20Bologna%20-%20Alma%20Mater%20Studiorum!5e0!3m2!1sit!2sit!4v1670314646821!5m2!1sit!2sit" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                </div>
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
            axios.post('model/php/api/api-upload-post-images.php', formImages);
            axios.post('model/php/api/api-upload-post-tags.php', formTags).then(response =>{
                console.log(response);
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
    console.log(tags);
    let form = generateForm();
    main.innerHTML = form;
    addTags(tags.data);
    showCreatePostForm();
    loadRegions();
});