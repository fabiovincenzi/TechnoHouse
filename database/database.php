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
    private $error_string;
    /**
     * Summary of __construct
     * @param mixed server_name : Name of the server to connect
     * @param mixed username    : The username for the connection
     * @param mixed password    : The password used for the connection
     * @param mixed dbname      : The port used for the connection
    */
    public function __construct($server_name, $username, $password, $dbname, $port)
    {
        $this->error_string = "";
        $this->db = new mysqli($server_name, $username, $password, $dbname, $port);
        if($this->db->connect_error)
        {
            die("Connection failed : ".$this->db->connect_error);
        }
    }

    public function getErrorString(){
        return $this->error_string;
    }

     /**
     * Summary of updateBiography : Checks if the credentials are correct
     * @param mixed $email        : User's email
     * @param mixed $password     : User's password 
     * @return mixed
     */
    public function checkLogin($email, $password)
    {
        if(count($this->checkEmail($email)) == 0){
            return array();
        }
        $PARAM_CHECK_LOGIN = 's';
        $query = "SELECT idUser, password
                  FROM User 
                  WHERE email like ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param($PARAM_CHECK_LOGIN,$email);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $saved_password = $result[0]["password"];
        $result_psw = password_verify($password, $saved_password);
        if($result_psw){
            return $result;
        }else{
            $this->error_string = $result_psw == false ? "PASSWORD" : "";
            return array();
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
    public function addUser($name, $surname, $birthdate, $phone_number, $email, $password)
    {
        if(count($this->checkEmail($email))>0 || count($this->checkPhoneNumber($phone_number)) > 0){
            return false;
        }

        $PARAM_ADD_USER = 'sssisss';                       // Values for the add of a new User
        $query = "INSERT INTO User
                  (name,surname,email,phoneNumber,birthdate,password,biography)
                   VALUES (?, ?, ?, ?, ?, ?, ?)";
        $statement = $this->db->prepare($query);
        //password_hash($password, PASSWORD_DEFAULT);
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $biography = "";
        $statement->bind_param($PARAM_ADD_USER, $name, $surname, $email,$phone_number, $birthdate, $hashed_password, $biography);
        return $statement->execute();
    }

    public function checkPhoneNumber($phone_number){
        $PARAM_CHECK_EMAIL = 'i';                       // Values for the add of a new User
        $query = "SELECT *
                  FROM User
                  WHERE phoneNumber like ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param($PARAM_CHECK_EMAIL, $phone_number);
        $this->error_string = $statement->execute() ? "PHONE" : "";
        $result = $statement->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);    
    }

    public function checkEmail($email){
        $PARAM_CHECK_EMAIL = 's';                       // Values for the add of a new User
        $query = "SELECT *
                  FROM User
                  WHERE email like ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param($PARAM_CHECK_EMAIL, $email);
        $this->error_string = $statement->execute() ? "EMAIL" : "";
        $result = $statement->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Summary of updateBiography : Update the User's biography
     * @param mixed $user_id      : User's id
     * @param mixed $biography    : new User's biography 
     * @return bool
     */
    public function updateBiography($user_id, $biography)
    {
        $PARAM_UPDATE_USER_BIOGRAPHY = 's';             // Value for the add of the User's biography
        $query = "UPDATE User SET biography = ? WHERE idUser = ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param($PARAM_UPDATE_USER_BIOGRAPHY, $biography, $user_id);
        return $statement->execute();
    }

    public function getUserInfo($info, $email){
        if (is_string($info)) {
            return $this->getUserByEmail($email)[0][$info];
        }else{
            return array();
        }
    }

    /**
     * Summary of getUserByID
     * @param mixed $user_id    : User's ID
     * @return array            : The specific user with the Input Id
     */
    public function getUserByID($user_id)
    {
        $PARAM_GET_USER_ID = 'i';                       // Valu used to get the User by his ID
        $query = "SELECT *
                  FROM User
                  WHERE idUser = ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param($PARAM_GET_USER_ID, $user_id);
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
        if(count($this->checkEmail($email)) == 0){
            return array();
        }
        $PARAM_GET_USER_EMAIL = 's';                    // Value used to get tbe User by his Emeail               
        $query = "SELECT *
                  FROM User
                  WHERE email like ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param($PARAM_GET_USER_EMAIL, $email);
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
        $PARAM_DELETE_USER = 'i';                       // Value used to delete the USer by his Id
        // Delete all the posts from the specific user
        // Remove all the User that saved that post
        $query = "DELETE FROM User WHERE idUser = ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param($PARAM_DELETE_USER, $user_id);
        return $statement->execute();
    }

    /**
     * Summary of getRegions : Get all the Regions inside the Db
     * @return array    : All the regions saved inside the Database
     */
    public function getRegions()
    {
        $query = "SELECT *
                  FROM Region";
        $statement = $this->db->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Summary of getProvincies : Get all the Provincies inside the Db
     * @return array    : All the provincies saved inside the Database
     */
    public function getProvincies()
    {
        $query = "SELECT *
                  FROM Provicne";
        $statement = $this->db->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Summary of getCities : Get all the Cities inside the Db
     * @return array    : All the cities saved inside the Database
     */
    public function getCities()
    {
        $query = "SELECT *
                  FROM City";
        $statement = $this->db->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Summary of addBuilding
     * @param mixed $latitude
     * @param mixed $longitude
     * @param mixed $postcode
     * @return bool
     */
    public function addBuilding($latitude, $longitude, $postcode)
    {
        $PARAM_ADD_BUILDING = 'ddi';                    // Values used to add a new Building
        $query = ("INSERT INTO Building
                  (POINT(latitude,longitude), City_postCode)
                  VALUES(?,?,?)");
        $statement = $this->db->prepare($query);
        $statement->bind_param($PARAM_ADD_BUILDING, $latitude, $longitude, $postcode);
        return $statement->execute();
    }
    
    /**
     * Summary of getBuilding Get a specific Building from the Database
     * @param mixed $building_id the Building's Id
     * @return array, contains the specific building
     */
    public function getBuilding($building_id)
    {
        $PARAM_GET_BUILDING = 'i';                      // Value used to get a specific Building from its id
        $query = "SELECT *
                  FROM Building
                  WHERE idBuilding = ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param($PARAM_GET_BUILDING, $building_id);
        $statement->execute();
        $result = $statement->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);    
    }

    /**
     * Summary of deleteBuilding, delete a specific Building 
     * @param mixed $building_id
     * @return bool, result of query
     */
    public function deleteBuilding($building_id)
    {
        $PARAM_DELETE_BUILDING = 'i';                   // Value used to delete a specific Building from its id
        $query = "DELETE FROM Building WHERE idBuilding = ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param($PARAM_DELETE_BUILDING, $building_id);
        return $statement->execute();
    }

    /**
     * Summary of addPost Adding a new post inside the database
     * @param mixed $title
     * @param mixed $description
     * @param mixed $price
     * @param mixed $user_id
     * @param mixed $building_id
     * @return void
     */
    public function  addPost($title, $description, $price, $user_id, $building_id)
    {
        $PARAM_ADD_POST = 'ssdii';
        $query = ("INSERT INTO Post
                (POINT(title,description,price,User_idUser,Building_idBuilding)
                VALUES(?,?,?,?,?)");
        $statement = $this->db->prepare($query);
        $statement->bind_param($PARAM_ADD_POST, $title, $description, $price, $user_id, $building_id);
    }

    /**
     * Summary of getUsersPosts get all the post from a specific user
     * @param mixed $user_id
     * @return array
     */
    public function getUsersPosts($user_id)
    {
        $PARAM_GET_USER_POSTS = 'i';
        $query = "SELECT *
                  FROM Post
                  WHERE User_idUser = ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param($PARAM_GET_USER_POSTS, $user_id);
        $statement->execute();
        $result = $statement->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Summary of getUsersFeed get all the posts to be shown in the feed of a specific user (posts of the users that you follow)
     * @param mixed $user_id
     * @return array
     */
    public function getUsersFeed($user_id)
    {
        
        $PARAM_GET_USER_POSTS = 'i';
        $query = "SELECT *
                  FROM post
                  WHERE post.User_idUser IN(
                    SELECT User_idUser1
                    FROM following, post
                    WHERE following.User_idUser = ?
                  )";
        $statement = $this->db->prepare($query);
        $statement->bind_param($PARAM_GET_USER_POSTS, $user_id);
        $statement->execute();
        $result = $statement->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Summary of updatePost update a specific Post
     * @param mixed $title
     * @param mixed $description
     * @param mixed $price
     * @param mixed $post_id
     * @return bool : state of the query
     */
    public function updatePost($title, $description, $price, $post_id)
    {
        $PARAM_UPDATE_POST = 'ssdi';
        $query = "UPDATE Post
                  SET title = ?, description = ?, price = ?
                  WHERE idPost = ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param($PARAM_UPDATE_POST, $title, $description, $price, $post_id);
        return $statement->execute();
    }

    /**
     * Summary of getTagsByPost
     * @return array : All the tags of a post
     */
    public function getTagsByPost($post_id)
    {
        $PARAM_GET_TAGS_BY_POST = 'i';
        $query = "SELECT *
                  FROM tag
                  WHERE idTag IN(SELECT Tag_idTag
                  FROM post_has_tag
                  WHERE Post_idPost = ?)";
        $statement = $this->db->prepare($query);
        $statement->bind_param($PARAM_GET_TAGS_BY_POST, $post_id);
        $statement->execute();
        $result = $statement->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);        
    }

    /**
     * Summary of getTags
     * @return array : All the tags inside the Database
     */
    public function getTags()
    {
        $query = "SELECT *
                  FROM Tag";
        $statement = $this->db->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);        
    }

    /**
     * Summary of savePost, save a new post for the User "user_id"
     * @param mixed $post_id
     * @param mixed $user_id
     * @return bool : state of the query 
     */
    public function savePost($post_id, $user_id)
    {
        $PARAM_ADD_SAVE = 'ii';
        $query = "INSERT INTO SavedPosts
                  (Post_idPost,User_idUser)
                  VALUES(?,?)";
        $statement = $this->db->prepare($query);
        $statement->bind_param($PARAM_ADD_SAVE, $post_id, $user_id);
        return $statement->execute();
    }

    /**
     * Summary of getAllSaved
     * @param mixed $user_id
     * @return array : All saved posts from a specific User
     */
    public function getAllSaved($user_id)
    {
        $PARAM_GET_SAVED = 'i';
        $query = "SELECT *
                  FROM SavedPosts
                  WHERE User_idUser = ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param($PARAM_GET_SAVED, $user_id);
        $statement->execute();
        $result = $statement->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Summary of removeFromSaved : Remove a saved post from the User's list
     * @param mixed $post_id
     * @param mixed $user_id
     * @return bool : State of the remove
     */
    public function removeFromSaved($post_id, $user_id)
    {
        $PARAM_DELETE_SAVED = 'ii';
        $query = "DELETE FROM SavedPosts
                  WHERE Post_idPost = ? AND User_idUser = ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param($PARAM_DELETE_SAVED, $post_id, $user_id);
        return $statement->execute();
    }

    public function addQuestion($user_id, $post_id, $question)
    {
        $PARAM_ADD_QUESTION = 'iis';
        $query = "INSERT INTO Question
                  (User_idUsER,Post_idPost,question)
                  VALUES(?,?,?)";
        $statement = $this->db->prepare($query);
        $statement->bind_param($PARAM_ADD_QUESTION, $user_id, $post_id, $question);
        return $statement->execute();
    }

    public function getPostsQuestions($post_id)
    {
        $PARAM_GET_QUESTIONS = 'i';
        $query = "SELECT *
                  FROM Question
                  WHERE Post_idPost = ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param($PARAM_GET_QUESTIONS, $post_id);
        $statement->execute();
        $result = $statement->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function deleteQuestion($question_id)
    {
        $PARAM_DELETE_QUESTION = 'i';
        $query = "DELETE FROM Question
                  WHERE idQuestion = ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param($PARAM_DELETE_QUESTION, $question_id);
        return $statement->execute();
    }

    public function addAnswer($user_id, $question_id, $answer)
    {
        $PARAM_ADD_ANSWER = 'iis';
        $query = "INSERT INTO Answer
                     (User_idUser, Question_idQuestion,answer)
                     VALUES(?,?,?)";
        $statement = $this->db->prepare($query);
        $statement->bind_param($PARAM_ADD_ANSWER, $user_id, $question_id, $answer);
        return $statement->execute();
    }

    public function getAnswerOf($question_id)
    {
        $PREPARE_GET_ANSWER = 'i';
        $query = "SELECT *
                  FROM Answer 
                  WHERE Question_idQuestion = ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param($PREPARE_GET_ANSWER, $question_id);
        $statement->execute();
        $result = $statement->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function deleteAnswer($answer_id)
    {
        $PARAM_DELETE_ANSWER = 'i';
        $query = "DELETE FROM Answer
                  WHERE idAnswer = ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param($PARAM_DELETE_ANSWER, $answer_id);
        return $statement->execute();
    }

    public function addImage()
    {

    }

    public function getPostsImages()
    {

    }

    public function removeImage()
    {

    }

    public function addFollower($source_user, $target_user)
    {
        // user1 start following user. User has a new follower 
        $PARAM_ADD_FOLLOWER = 'ii';
        $query = "INSERT INTO Follower
                  (User_idUser,User_idUser1)
                  VALUES(?,?)";
        $statement = $this->db->prepare($query);
        $statement->bind_param($PARAM_ADD_FOLLOWER, $source_user, $target_user);
        return $statement->execute();
    }

    public function getFollowers($user_id)
    {
        $PARAM_GET_FOLLOWERS = 'i';
        $query = "SELECT *
                  FROM Follower
                  WHERE User_idUser = ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param($PARAM_GET_FOLLOWERS, $user_id);
        $statement->execute();
        $result = $statement->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function removeFollower($source_user, $target_user)
    {
        $PARAM_REMOVE_FOLLOWER = 'ii';
        $query = "DELETE FROM Follower
                  WHERE User_idUser = ? AND User_idUser1 = ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param($PARAM_REMOVE_FOLLOWER, $source_user, $target_user);
        return $statement->execute();
    }

    public function addFollowing($source_id, $target_id)
    {

        $PARAM_ADD_FOLLOWING = 'ii';
        $query = "INSERT INTO Following 
                  (User_idUser, User_idUser1)
                  VALUES(?,?)";
        $statement = $this->db->prepare($query);
        $statement->bind_param($PARAM_ADD_FOLLOWING, $source_id, $target_id);
        return $statement->execute();
    }

    public function getFollowing($user_id)
    {
        $PARAM_GET_FOLLOWING = 'i';
        $query = "SELECT *
                  FROM Following
                  WHERE User_idUser = ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param($PARAM_GET_FOLLOWING, $user_id);
        $statement->execute();
        $result = $statement->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function removeFollowing($source_id, $target_id)
    {
        $PARAM_REMOVE_FOLLOWING = 'ii';
        $query = "DELETE FROM Following
                  WHERE User_idUser = ? AND User_idUser1 = ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param($PARAM_REMOVE_FOLLOWING, $source_user, $target_user);
        return $statement->execute();
    }
}
?>