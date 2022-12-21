export class User{
    /// Constructor of the User
    constructor(name, surname, username){
        this.name = name;
        this.surname = surname;
        this.username = username;
    }

    /// Return the name of the user
    getName(){
        return this.name;
    }

    /// Return the surname of the user
    getSurname(){
        return this.surname;
    }

    /// Return the username of the user
    getUsername(){
        return this.username;
    }

}