<?php

include_once 'Database.php';

/*
 * Handles operation on basic users
 */
class UserModel{

    private $db;

    /**
     * UserModel constructor.
     */
    public function __construct()
    {
        $this->db = new Database();
    }

    public function createBasicUser($arr){
        try{
            $conn = $this->db->getConnection();

            $prep = $conn->prepare("INSERT INTO users (email, password) VALUES (:email,:password)");
            $prep->bindValue(':email', $arr['email'], PDO::PARAM_STR);
            $prep->bindValue(':password', md5($arr['password']), PDO::PARAM_STR);

            return $prep->execute() ? "Uspesne pridany novy pouzivatel" : "Nieco sa nepodarilo";
        } catch(PDOException $e) {
            return "Connection failed: " . $e->getMessage();
        }
    }

    public function verifyUserPass($email, $hashedPass)
    {
        $conn = $this->db->getConnection();
        $sth = $conn->prepare('SELECT password FROM users WHERE email=:email');
        $sth->bindParam(':email', $email, PDO::PARAM_STR);
        $sth->execute();
        $result = $sth->fetch(PDO::FETCH_ASSOC);

        if ($result == null)
            return false;

        return (strcmp($hashedPass, $result['password'] ) == 0);
    }


}