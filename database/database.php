<?php
/*
    :::::::::::::::::::::::::::::::::::::::::::::::
    DB CLASS FOR QUERIES,
    using mysqli
    :::::::::::::::::::::::::::::::::::::::::::::::
*/
/**
 * Summary of Database, class to manage the entire db
 */
class Database{
    private $db;                                            // Attribute that rappresent the Database
    private $statement;
    // ======================================================
    private $PARAM_ADD_USER = 'iiii';                       // Values for the add of a new User
    private $PARAM_UPDATE_USER_BIOGRAPHY = 's';
    private $PARAM_GET_USER_ID = 'i';                       // Value used to get the User from his ID
    private $PARAM_GET_USER_EMAIL = 'si';
    private $PARAM_DELETE_USER = 'i';
    // ======================================================
    /**
     * Summary of __construct
     * @param mixed server_name : Name of the server to connect
     * @param mixed username    : The username for the connection
     * @param mixed password    : The password used for the connection
     * @param mixed dbname      : The port used for the connection
    */
    public function __construct($server_name, $username, $password, $dbname, $port)
    {
        $this->db = new mysqli($server_name, $username, $password, $dbname, $port);
        if($this->db->connect_error)
        {
            die("Connection failed : ".$this->db->connect_error);
        }
    }
    /**
     * Summary of addUser
     * @param mixed $name           : User's name
     * @param mixed $surname        : User's surname
     * @param mixed $birthdate      : User's birthdate     
     * @param mixed $email          : User's email
     * @param mixed $password       : User's password
     * @return bool                 : State of the Add
     */
    public function addUser($name, $surname, $birthdate, $email, $password)
    {
        $query = "INSERT INTO User
                  (name,surname,email,phoneNumber,birthdate,password,biography)
                   VALUES (?, ?, ?, ?, ?, ?, ?)";
        $statement = $this->db->prepare($query);
        $statement->bind_param($this->PARAM_ADD_USER, $name, $surname, $birthdate, $email, $password);
        return $statement->execute();
    }

    /**
     * Summary of updateBiography : Update the User's biography
     * @param mixed $user_id      : User's id
     * @param mixed $biography    : new User's biography 
     * @return bool
     */
    public function updateBiography($user_id, $biography)
    {
        $query = "UPDATE User SET biography = ? WHERE idUser = ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param($this->PARAM_UPDATE_USER_BIOGRAPHY, $biography, $user_id);
        return $statement->execute();
    }

    /**
     * Summary of getUserByID
     * @param mixed $user_id    : User's ID
     * @return array            : The specific user with the Input Id
     */
    public function getUserByID($user_id)
    {
        $query = "SELECT *
                  FROM User
                  WHERE idUser = ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param($this->PARAM_GET_USER_ID, $user_id);
        $statement->execute();
        $result = $statement->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Summary of getUserByEMAIL
     * @param mixed $email : User's email
     * @return array rappresenting the User
     */
    public function getUserByEmail($email)
    {
        $query = "SELECT *
                  FROM User
                  WHERE email like ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param($this->PARAM_GET_USER_EMAIL, $email);
        $statement->execute();
        $result = $statement->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Summary of deleteUser : Delete the User, all his posts and all reference from other Users 
     * @param mixed $user_id : User's Id
     * @return bool          : Satet of the deletion 
     */
    public function deleteUser($user_id)
    {
        // Delete all the posts from the specific user
        // Remove all the User that saved that post
        $query = "DELETE FROM User WHERE idUser = ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param($this->PARAM_DELETE_USER, $user_id);
        return $statement->execute();
    }
}
?>