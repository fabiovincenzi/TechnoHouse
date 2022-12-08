import { Location } from './location'
import { User } from '../user/user';
class Post{
    /// Constructor for creating the Post
    constructor(images,description, location, user){
        this.images = images;
        this.description = description;
        this.location = location;
        this.user = user;
    }

    /// Return the descrption of the post
    getDescription(){
        return this.description;
    }
    /// Return all the images of the post
    getImages(){
        return this.images;
    }

    /// Return the coordinate of the post
    getLocation(){
        return this.location.getLocation();
    }

    /// Return the user of the post
    getUser(){
        return this.user;
    }
}
