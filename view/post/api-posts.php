<?php
    /*
    =====================================================================================================
    CLASS FOR THE DB QUERIES 
    =====================================================================================================
    */
    class DataBase{
        private $db;
        
        /// Constructor for the database
        public function __construct($servername, $username, $password, $dbname, $port){
            $this->db = new mysqli($servername, $username, $password, $dbname, $port);
            //An error occurred, we must kill 
            if($this->db->connect_error){
                die("Connection Failed: ".$this->db->connect_errno);
            }
        }

        public function getUsers($user_id){
            $query = "";
            return NULL;
        }

        public function getFollowers($user_id){
            $query = "";
        }

        public function getFollowing($user_id){
            $query = "";
        }

    
    }
?>