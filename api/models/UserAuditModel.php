<?php

include_once 'Database.php';

/*
 * Handles logging history of users => basic login, oauth, ldap
 */
class UserAuditModel{

    private $db;

    /**
     * UserModel constructor.
     */
    public function __construct()
    {
        $this->db = new Database();
    }

    public function auditLogin($email, $login_type)
    {
        try{
            $conn = $this->db->getConnection();
            $prep = $conn->prepare("INSERT INTO login_audit (user_email, login_type) VALUES (:user_email,:login_type)");
            $result = $prep->execute([ ":user_email" => $email , ":login_type" => $login_type]);
            $conn=null;
            return $result;
        } catch(PDOException $e) {
            return "Connection failed: " . $e->getMessage();
        }
    }

}