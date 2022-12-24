function createPost(){
    
}
axios.get('model/php/api/api-post.php').then(response => {
    console.log(response);
    let post = createPost(response.data);
    const main = document.querySelector("main");
    main.innerHTML = post;
});