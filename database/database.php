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

    /**
     * Summary of getLastIndex
     * @return mixed
     */
    public function getLastIndex($table){
        $PARAM_LAST_INDEX = 's';
        $query = "SELECT MAX(id) FROM ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param($PARAM_LAST_INDEX, $table);
        $statement->execute();
        $result = $statement->get_result();
        return $result->fetch_all(MYSQLI_NUM);
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
    public function addUser($name, $surname, $birthdate, $phone_number, $email, $password, $image)
    {
        if(count($this->checkEmail($email))>0 || count($this->checkPhoneNumber($phone_number)) > 0){
            return false;
        }

        $PARAM_ADD_USER = 'sssisss';                       // Values for the add of a new User
        $query = "INSERT INTO User
                  (name,surname,email,phoneNumber,birthdate,password, userImage)
                   VALUES (?, ?, ?, ?, ?, ?, ?)";
        $statement = $this->db->prepare($query);
        //password_hash($password, PASSWORD_DEFAULT);
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $statement->bind_param($PARAM_ADD_USER, $name, $surname, $email,$phone_number, $birthdate, $hashed_password, $image);
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

    public function getUserByPost($post_id)
    {
        $PARAM_GET_USER_BY_POST = 'i';                       // Valu used to get the User by his ID
        $query = "SELECT *
                  FROM User
                  WHERE idUser IN(SELECT User_idUser
                               FROM Post
                               WHERE idPost = ?)";
        $statement = $this->db->prepare($query);
        $statement->bind_param($PARAM_GET_USER_BY_POST, $post_id);
        $statement->execute();
        $result = $statement->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
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
     * Summary of getProvinciesByRegion : Get all the Provincies of a specific region
     * @param mixed $region_id : a specific region
     * @return array    :all the proincies of a specific region
     */
    public function getProvinciesByRegion($region_id)
    {
        $PARAM_GET_PROVINCE_BY_REGION = 'i';   
        $query = "SELECT *
                  FROM Province
                  WHERE Region_idRegion = ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param($PARAM_GET_PROVINCE_BY_REGION, $region_id);
        $statement->execute();        
        $result = $statement->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

     /**
     * Summary of getCitiesByProvince : Get all the Cities of a specific province
     * @param mixed $province_id : a specific province
     * @return array    : all the cities of a specific region
     */
    public function getCitiesByProvince($province_id)
    {
        $PARAM_GET_CITIES_BY_PROVINCE = 's';   
        $query = "SELECT *
                  FROM City
                  WHERE Province_initials = ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param($PARAM_GET_CITIES_BY_PROVINCE, $province_id);
        $statement->execute();        
        $result = $statement->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Summary of addPost Adding a new post inside the database
     * @param mixed $title
     * @param mixed $description
     * @param mixed $price
     * @param mixed $user_id
     * @return mixed
     */
    public function  addPost($title, $description, $price, $user_id, $publish_time, $latitude, $longitude, $adress, $city_id)
    {
        var_dump($title, $description, $price, $user_id, $publish_time, $latitude, $longitude, $adress, $city_id);
        $PARAM_ADD_POST = 'ssdissidd';
        $query = "INSERT INTO Post
         (title,description,price,User_idUser,PublishTime,Address,City_idCity,latitude,LONGITUDE)
          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $statement = $this->db->prepare($query);
        
        $statement->bind_param($PARAM_ADD_POST, $title, $description, $price, $user_id, $publish_time,$adress, $city_id, $latitude, $longitude);
        $statement->execute();
        return $statement;
    }

    public function deletePost($post_id)
    {
        var_dump($post_id);
        $PARAM_DELETE_POST = 'i';                       // Value used to delete the post by his Id
        // Delete all the images from the specific user
        $query = "DELETE FROM Image WHERE Post_idPost = ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param($PARAM_DELETE_POST, $post_id);
        $statement->execute();
        //delete all the tags association
        $query = "DELETE FROM Post_has_Tag WHERE Post_idPost = ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param($PARAM_DELETE_POST, $post_id);
        $statement->execute();
        //delete all the saved that refers to this post
        $query = "DELETE FROM SavedPosts WHERE Post_idPost = ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param($PARAM_DELETE_POST, $post_id);
        $statement->execute();
        //delete all the notifications that refers to this post
        $query = "DELETE FROM Notification WHERE Post_idPost = ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param($PARAM_DELETE_POST, $post_id);
        $statement->execute();

        // Remove all the User that saved that post
        $query = "DELETE FROM Post WHERE idPost = ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param($PARAM_DELETE_POST, $post_id);
        return $statement->execute();
    }

    public function getPostById($post_id){
        $PARAM_GET_POST = 'i';
        $query = "SELECT *
                  FROM Post
                  WHERE idPost = ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param($PARAM_GET_POST, $post_id);
        $statement->execute();
        $result = $statement->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getPostByQuestion($question_id){
        $PARAM_GET_POST_BY_QUESTION = 'i';                       // Valu used to get the User by his ID
        $query = "SELECT *
                  FROM Post
                  WHERE idPost IN(SELECT Post_idPost
                               FROM Question
                               WHERE idQuestion = ?)";
        $statement = $this->db->prepare($query);
        $statement->bind_param($PARAM_GET_POST_BY_QUESTION, $question_id);
        $statement->execute();
        $result = $statement->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

     /**
     * Summary of getUsersPosts get all the post from a specific user
     * @param mixed $user_id
     * @return array
     */
    public function getLastUsersPosts($user_id)
    {
        $PARAM_GET_LAST_USER_POSTS = 'i';
        $query = "SELECT *
                  FROM Post
                  WHERE User_idUser = ?
                  ORDER BY PublishTime desc
                  LIMIT 1";
        $statement = $this->db->prepare($query);
        $statement->bind_param($PARAM_GET_LAST_USER_POSTS, $user_id);
        $statement->execute();
        $result = $statement->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
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
                  FROM Post
                  WHERE `Post`.User_idUser IN(
                    SELECT User_idUser1
                    FROM Following, Post
                    WHERE `Following`.User_idUser = ?
                  )
                  ORDER BY PublishTime DESC";
        $statement = $this->db->prepare($query);
        $statement->bind_param($PARAM_GET_USER_POSTS, $user_id);
        $statement->execute();
        $result = $statement->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function updateUser($idUser, $name, $surname, $phone, $birth, $email){
        $PARAM_UPDATE_USER = 'sssssi';
        $query = "UPDATE User
                  SET name = ?, surname = ?, phoneNumber = ?, birthDate = ?, email = ?
                  WHERE idUser = ?";
        $statement = $this->db->prepare($query);
        
        $statement->bind_param($PARAM_UPDATE_USER, $name, $surname, $phone, $birth, $email, $idUser);
        return $statement->execute();
    }
    public function updateTotalUser($idUser, $name, $surname, $phone, $birth, $email, $password){
        $PARAM_UPDATE_USER = 'ssssssi';
        $query = "UPDATE User
                  SET name = ?, surname = ?, phoneNumber = ?, birthDate = ?, email = ?, password = ?
                  WHERE idUser = ?";
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $statement = $this->db->prepare($query);
        $statement->bind_param($PARAM_UPDATE_USER, $name, $surname, $phone, $birth, $email,$hashed_password, $idUser);
        return $statement->execute();
    }

    public function userCheckEmail($iduser, $email){
        $PARAM_CHECK_EMAIL = 'is';
        $query = "SELECT *
                  FROM User
                  WHERE idUser <> ? AND email like ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param($PARAM_CHECK_EMAIL, $iduser, $email);
        $statement->execute();
        return count($statement->get_result()->fetch_all(MYSQLI_ASSOC)) <= 0;
    }

    public function uploadUserIMG($iduser, $file){
        $PARAM_UPDATE_USER = 'si';
        $query = "UPDATE User
                  SET userImage = ?
                  WHERE idUser = ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param($PARAM_UPDATE_USER, $file, $iduser);
        return $statement->execute();
    }

    public function userCheckPhone($iduser, $phone){
        $PARAM_CHECK_EMAIL = 'is';
        $query = "SELECT *
                  FROM User
                  WHERE idUser <> ? AND phoneNumber like ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param($PARAM_CHECK_EMAIL, $iduser, $phone);
        $statement->execute();
        return count($statement->get_result()->fetch_all(MYSQLI_ASSOC)) <= 0;
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
    
    public function getLocationInfoFromPost($post_id){
        $PARAM_GET_LOCATION = 'i';
        $query = "SELECT Region.regionName AS Region,
                         Province.initials AS Province,
                         City.cityName AS City,
                         City.postCode As PostCode,
                         Post.Address AS Address
                  FROM Region, Province, City, Post
                  WHERE Post.idPost = ?
                  AND Post.City_idCity = City.idCity
                  AND City.Province_initials = Province.initials
                  AND Province.Region_idRegion = Region.idRegion";
        $statement = $this->db->prepare($query);
        $statement->bind_param($PARAM_GET_LOCATION, $post_id);
        $statement->execute();
        $result = $statement->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);  
    }

    /**
     * Summary of getTagsByPost
     * @return array : All the tags of a post
     */
    public function getTagsByPost($post_id)
    {
        $PARAM_GET_TAGS_BY_POST = 'i';
        $query = "SELECT *
                  FROM Tag
                  WHERE idTag IN(SELECT Tag_idTag
                  FROM Post_has_Tag
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
     * Summary of getSaveByPost
     * @param mixed $post_id
     * @return array : The number of saved of a specific post
     */
    public function getSaveByPost($post_id){
        $PARAM_GET_SAVE_POST = 'i';
        $query = "SELECT COUNT(Post_idPost) AS saved
                  FROM SavedPosts
                  WHERE Post_idPost = ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param($PARAM_GET_SAVE_POST, $post_id);
        $statement->execute();
        $result = $statement->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
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
                  (User_idUser,Post_idPost,text)
                  VALUES(?,?,?)";
        $statement = $this->db->prepare($query);
        $statement->bind_param($PARAM_ADD_QUESTION, $user_id, $post_id, $question);
        return $statement->execute();
    }

    public function getPostsQuestions($post_id)
    {
        $PARAM_GET_QUESTIONS = 'i';
        $query = "SELECT Question.*, User.name, User.surname
                  FROM Question, User
                  WHERE Post_idPost = ?
                  AND idUser = User_idUser";
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
                     (User_idUser, Question_idQuestion,text)
                     VALUES(?,?,?)";
        $statement = $this->db->prepare($query);
        $statement->bind_param($PARAM_ADD_ANSWER, $user_id, $question_id, $answer);
        return $statement->execute();
    }

    public function getAnswerOf($question_id)
    {
        $PREPARE_GET_ANSWER = 'i';
        $query = "SELECT Answer.*, User.name, User.surname
                  FROM Answer, User
                  WHERE Question_idQuestion = ?
                  AND idUser = User_idUser";
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

    public function addTag($tag)
    {
        $PARAM_ADD_TAG = 's';
        $query = "INSERT INTO Tag
                  (tagName)
                  VALUES(?)";
        $statement = $this->db->prepare($query);
        $statement->bind_param($PARAM_ADD_TAG, $tag);
        return $statement->execute();
    }

    public function addTagToPost($tag_id, $post_id)
    {
        $PARAM_ADD_TAG_TO_POST= 'ii';
        $query = "INSERT INTO post_has_tag 
                  (Post_idPost, Tag_idTag)
                  VALUES(?,?)";
        $statement = $this->db->prepare($query);
        $statement->bind_param($PARAM_ADD_TAG_TO_POST, $post_id, $tag_id);
        var_dump($tag_id);
        var_dump($post_id);

        return $statement->execute();
    }

    public function addImage($path, $post_id)
    {
        $PARAM_ADD_IMAGE = 'si';
        $query = "INSERT INTO Image 
                  (path, Post_idPost)
                  VALUES(?,?)";
        $statement = $this->db->prepare($query);
        $statement->bind_param($PARAM_ADD_IMAGE, $path, $post_id);
        return $statement->execute();
    }

    public function getPostImages($post_id)
    {
        $PARAM_GET_IMAGES_BY_POST = 'i';
        $query = "SELECT *
                  FROM Image
                  WHERE Post_idPost	= ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param($PARAM_GET_IMAGES_BY_POST, $post_id);
        $statement->execute();
        $result = $statement->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);     
    }

    public function removeImage()
    {

    }

    public function getFollowers($user_id)
    {
        $PARAM_GET_FOLLOWERS = 'i';
        $query = "SELECT *
                  FROM Following
                  WHERE User_idUser1 = ?";
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
        //Source id starts following target id
        $PARAM_ADD_FOLLOWING = 'ii';
        $query = "INSERT INTO Following 
                  (User_idUser, User_idUser1)
                  VALUES(?,?)";
        $statement = $this->db->prepare($query);
        $statement->bind_param($PARAM_ADD_FOLLOWING, $source_id, $target_id);
        return $statement->execute();
    }

    public function isFollowing($source, $target){
        $PARAM_GET_FOLLOWING = 'ii';
        $query = "SELECT *
                  FROM Following
                  WHERE User_idUser = ? AND User_idUser1 = ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param($PARAM_GET_FOLLOWING, $source, $target);
        $statement->execute();
        $result = $statement->get_result();
        return count($result->fetch_all(MYSQLI_ASSOC)) > 0;
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
        $statement->bind_param($PARAM_REMOVE_FOLLOWING, $source_id, $target_id);
        return $statement->execute();
    }

    public function addChat($source, $destination){
        $PARAM_ADD_CHAT = 'ii';
        $query = "INSERT INTO Chat
                  (User_idUser, User_idUser1)
                  VALUES(?,?)";
        $statement = $this->db->prepare($query);
        $statement->bind_param($PARAM_ADD_CHAT, $source, $destination);
        return $statement->execute();
    }

    public function getChatById($idChat){
        $PARAM_SELECT_CHAT = 'i';
        $query = "SELECT *
                  FROM Chat
                  WHERE idChat = ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param($PARAM_SELECT_CHAT, $idChat);
        $statement->execute();
        $result = $statement->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getAllChat($source){
        $PARAM_SELECT_CHAT = 'ii';
        $query = "SELECT *
                  FROM Chat
                  WHERE User_idUser = ? OR User_idUser1 = ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param($PARAM_SELECT_CHAT, $source, $source);
        $statement->execute();
        $result = $statement->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function addMessage($body, $date, $user, $chat){
        $PARAM_ADD_MESSAGE = 'ssii';
        $query = "INSERT INTO Message
                  (body, data, User_idUser, Chat_idChat)
                  VALUES(?,?,?,?)";
        $statement = $this->db->prepare($query);
        $statement->bind_param($PARAM_ADD_MESSAGE, $body, $date, $user, $chat);
        return $statement->execute();
    }


    public function getChatMessages($idChat){
        $PARAM_SELECT_MESSAGE = 'i';
        $query = "SELECT *
                  FROM Message
                  WHERE Chat_idChat= ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param($PARAM_SELECT_MESSAGE, $idChat);
        $statement->execute();
        $result = $statement->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getUserPreference($iduser){
        $PARAM_USER_PREFERENCE = 'i';
        $query = 'SELECT `Post_has_Tag`.Tag_idTag, COUNT(`Post_has_Tag`.Tag_idTag) AS Total
                  FROM SavedPosts INNER JOIN Post_has_Tag ON `SavedPosts`.Post_idPost=`Post_has_Tag`.Post_idPost
                  WHERE `SavedPosts`.User_idUser = ?
                  GROUP BY (`Post_has_Tag`.Tag_idTag)
                  ORDER BY Total DESC';
        $statement = $this->db->prepare($query);
        $statement->bind_param($PARAM_USER_PREFERENCE, $iduser);
        $statement->execute();
        $result = $statement->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public function getRandomPostsOf($tag, $n=10, $iduser){
        $PARAM_RANDOM_POSTS = 'iii';
        $query = "SELECT *
                  FROM Post_has_Tag INNER JOIN Post ON `Post_has_Tag`.Post_idPost=`Post`.idPost
                  WHERE `Post_has_Tag`.Tag_idTag=? AND `Post`.User_idUser <> ?
                  ORDER BY RAND()
                  LIMIT ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param($PARAM_RANDOM_POSTS, $tag, $iduser, $n);
        $statement->execute();
        $result = $statement->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getChatByUsers($user, $user1){
        $PARAM_GET_CHAT = 'ii';
        $query = "SELECT *
                  FROM Chat
                  WHERE User_idUser = ? AND User_idUser1 = ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param($PARAM_GET_CHAT, $user, $user1);
        $statement->execute();
        $result = $statement->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function deleteMessages($idchat){
        $PARAM_DELETE_MESSAGES = 'i';
        $query = "DELETE FROM Message 
                  WHERE Chat_idChat = ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param($PARAM_DELETE_MESSAGES, $idchat);
        return $statement->execute();
    }

    public function deleteChat($idchat){
        $PARAM_DELETE_CHAT = 'i';
        $query = "DELETE FROM Chat 
                  WHERE idChat = ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param($PARAM_DELETE_CHAT, $idchat);
        return $statement->execute();
    }

    public function getRandomPosts($n=10, $iduser){
        $PARAM_RANDOM_POSTS = 'ii';
        $query = "SELECT *
                  FROM `Post`
                  WHERE `Post`.User_idUser <> ?
                  ORDER BY RAND()
                  LIMIT ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param($PARAM_RANDOM_POSTS, $iduser, $n);
        $statement->execute();
        $result = $statement->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getAllUsers(){
        $query = "SELECT *
                  FROM User";
        $statement = $this->db->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    

    public function createNewFollowerNotification($targetUser, $sourceUser, $time)
    {
        $PARAM_NEW_FOLLOWER = 'iis';
        $query = "INSERT INTO Notification
                  (type,targetUser,User_idUser,time)
                  VALUES('NEW_FOLLOWER',?,?,?)";
        $statement = $this->db->prepare($query);
        $statement->bind_param($PARAM_NEW_FOLLOWER, $targetUser, $sourceUser, $time);
        return $statement->execute();
    }

    public function createNewSaveNotification($targetUser, $sourceUser, $post, $time)
    {
        $PARAM_SAVE = 'iiis';
        $query = "INSERT INTO Notification
                  (type,targetUser,User_idUser,Post_idPost,time)
                  VALUES('NEW_SAVE',?,?,?,?)";
        $statement = $this->db->prepare($query);
        $statement->bind_param($PARAM_SAVE, $targetUser, $sourceUser, $post, $time);
        return $statement->execute();
    }

    public function createNewQuestionNotification($targetUser, $sourceUser, $post, $time)
    {
        $PARAM_QUESTION = 'iiis';
        $query = "INSERT INTO Notification
                  (type,targetUser,User_idUser,Post_idPost,time)
                  VALUES('NEW_QUESTION',?,?,?,?)";
        $statement = $this->db->prepare($query);
        $statement->bind_param($PARAM_QUESTION, $targetUser, $sourceUser, $post, $time);
        return $statement->execute();
    }

    public function createNewAnswerNotification($targetUser, $sourceUser, $post, $time)
    {
        $PARAM_ANSWER = 'iiis';
        $query = "INSERT INTO Notification
                  (type,targetUser,User_idUser,Post_idPost,time)
                  VALUES('NEW_ANSWER',?,?,?,?)";
        $statement = $this->db->prepare($query);
        $statement->bind_param($PARAM_ANSWER, $targetUser, $sourceUser, $post, $time);
        return $statement->execute();
    }
    public function createNewPostNotification($targetUser, $sourceUser, $post, $time)
    {
        var_dump($targetUser, $sourceUser, $post, $time);
        $PARAM_ANSWER = 'iiis';
        $query = "INSERT INTO Notification
                  (type,targetUser,User_idUser,Post_idPost,time)
                  VALUES('NEW_POST',?,?,?,?)";
        $statement = $this->db->prepare($query);
        $statement->bind_param($PARAM_ANSWER, $targetUser, $sourceUser, $post, $time);
        return $statement->execute();
    }
    
    public function createNewMessageNotification($targetUser, $sourceUser, $chat, $time){
        var_dump($targetUser, $sourceUser, $chat, $time);
        $PARAM_MESSAGE = 'iisi';
        $query = "INSERT INTO Notification
                  (type,targetUser,User_idUser,time,Chat_idChat)
                  VALUES('NEW_MESSAGE',?,?,?,?)";
        $statement = $this->db->prepare($query);
        $statement->bind_param($PARAM_MESSAGE, $targetUser, $sourceUser, $time, $chat);
        return $statement->execute();
    }

    public function getNotifications($user_id)
    {
        $PARAM_GET_NOTIFICATIONS = 'i';                       // Valu used to get the User by his ID
        $query = "SELECT *
                  FROM Notification
                  WHERE targetUser = ?
                  ORDER BY time desc";
        $statement = $this->db->prepare($query);
        $statement->bind_param($PARAM_GET_NOTIFICATIONS, $user_id);
        $statement->execute();
        $result = $statement->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

}
?>