<?php
/*
    :::::::::::::::::::::::::::::::::::::::::::::::
    DB CLASS FOR QUERIES,
    using mysqli
    :::::::::::::::::::::::::::::::::::::::::::::::
*/
class Database{
    private $db;                                            // Attribute that rappresent the Database
    // ======================================================
    private $PARAM_ADD_USER = 'iiii';                        // Values for the add of a new User
    private $PARAM_GET_USER_ID = 'i'; 
    // ======================================================
    /*
        Constructor of the class "Database"
        @param server_name : Name of the server to connect
        @param username    : The username for the connection
        @param password    : The password used for the connection
        @param dbname      : The port used for the connection
    */
    public function __construct($server_name, $username, $password, $dbname, $port)
    {
        $this->db = new mysqli($server_name, $username, $password, $dbname, $port);
        if($this->db->connect_error)
        {
            die("Connection failed : ".$this->db->connect_error);
        }
    }

    /*
        Add a new user
        @param name     : User's name
        @param surname  : User's surname
        @param birthdate: User's Birthdate
        @param residence: User's Residence
        @param password : User's password

        @return         : The execute query
    */
    public function addUser($name, $surname, $birthdate, $residence, $email, $password)
    {
        $query = "INSERT INTO User
                  (name,surname,email,phoneNumber,birthdate,password,biography)
                   VALUES (?, ?, ?, ?, ?, ?, ?)";
        $statement = $this->db->prepare($query);
        $statement->bind_param($this->PARAM_ADDUSER, $name, $surname, $birthdate, $residence, $email, $password);
        return $statement->execute();
    }

    /*
        Get a specific user by his ID
        @param id   : User's id
        @return the specific user if exists
    */
    public function getUserByID($id)
    {
        $query = "SELECT *
                  FROM User
                  WHERE idUser = ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param()    
    }
}
?>