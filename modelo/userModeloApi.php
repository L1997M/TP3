<?php
class userModeloApi{

    private $db;
    function __construct(){
        $this->db = new PDO('mysql:host=localhost;' . 'dbname=vinilos_db;charset=utf8', 'root', '');

    }
    public function getUserByEmail($email) {
        $query = $this->db->prepare("SELECT * FROM usuario WHERE email = ?");
        $query->execute([$email]);
        return $query->fetch(PDO::FETCH_OBJ);
    }

}