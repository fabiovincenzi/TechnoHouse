function generateForm(){
    let form = `
    <div class="justify-content-center row">
                <div class="col-10 col-md-10 bg-white shadow rounded overflow-hidden mt-2">
                    <form action="#" method="POST">
                        <div class="row m-2">

                            <div class="col-md-6">
                                <label for="title">Title</label>
                                <input type="text" class="form-control mb-2" id="title" placeholder="Title">
                                <!--images-->
                                <label for="images">Post images</label><input type="file" name="images" id="images" />
                                <!--images-->

                                <button class="btn btn-primary btn-lg btn-block w-100 mt-2">Load Images</button>
                                <label for="tags">Tags</label>
                                <select id="tags" class="form-select mt-2" multiple aria-label="Tags">
                                    <option selected>Garden</option>
                                    <option value="1">Garage</option>
                                    <option value="2">Attic</option>
                                    <option value="3">Fireplace</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <!--description-->
                                <label for="description" id="lbl-description">Description</label>
                                <textarea class="form-control" id="description" title="post description" rows="3"></textarea>
                                <!--description-->
                                <label for="price">Price</label>
                                <input type="number" class="form-control" id="price" placeholder="Price">                    
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

function createPost(title, images, tags, description, price, location){
    const formPost = new FormData();
    const formImages = new FormData();
    const formTags = new FormData();
    formPost.append('title', title);
    /*images.forEach(image => {
        formImages.append("image", image);
    });
    tags.forEach(tag => {
        formTags.append('tag', tag);
    });*/
    formPost.append('tags', tags);
    formPost.append('description', description);
    formPost.append('price', price);
    formPost.append('location', location);
    axios.post('model/php/api/api-create-post.php', formPost)
    //axios.post('model/php/api/api-upload-post-images.php', formImages)
    //axios.post('model/php/api/api-upload-post-tags.php', formTags)
}

function showCreatePostForm(){
    let form = generateForm();
    main.innerHTML = form;
    document.querySelector("form").addEventListener("submit", function (event) {
        event.preventDefault();
        const title = document.querySelector("#title").value;
        const images = document.querySelector("#images").files;
        const options = document.querySelector("#tags").selectedOptions;
        const tags = Array.from(options).map(({ value }) => value);
        const description = document.querySelector("#description").value;
        const price = document.querySelector("#price").value;
        //const location = document.querySelector("#location").value;
        createPost(title, images, tags, description, price, 10);
    });
    
}

const main = document.querySelector("main");
showCreatePostForm();