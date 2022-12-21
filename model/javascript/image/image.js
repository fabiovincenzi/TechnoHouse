class Image{
    constructor(path, name){
        this,path = path;
        this.name = name;
    }

    /// Return the path of the image
    getPath(){
        return this.path;
    }

    /// Return the name of the image
    getName(){
        return this.name;
    }
}