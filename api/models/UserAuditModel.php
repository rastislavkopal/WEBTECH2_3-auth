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


    public function getAuditds()
    {
        $dataArr = array();
        try{
            $conn = $this->db->getConnection();
            $q = $conn->query("SELECT id, user_email, login_time, login_type FROM login_audit");

            while ($r = $q->fetch(PDO::FETCH_ASSOC))
                $dataArr[] = $r;

        } catch(PDOException $e) {
            return "Connection failed: " . $e->getMessage();
        }
        return json_encode($dataArr);
    }

    public function getUserAudit($user_email, $login_type)
    {
        $dataArr = array();
        try{
            $conn = $this->db->getConnection();
            $q = $conn->prepare("SELECT id, user_email, login_time, login_type FROM login_audit WHERE user_email=:user_email AND login_type=:login_type");
            $q->execute(array(":user_email" => $user_email, ":login_type" => $login_type));

            while ($r = $q->fetch(PDO::FETCH_ASSOC))
                $dataArr[] = $r;

        } catch(PDOException $e) {
            return "Connection failed: " . $e->getMessage();
        }
        return json_encode($dataArr);
    }

    public function getStats()
    {
        try{
            $dataArr = array();
            $conn = $this->db->getConnection();
            $q = $conn->prepare("SELECT login_type, COUNT(*) as count FROM `login_audit` GROUP BY login_type");
            $q->execute();

            while ($r = $q->fetch(PDO::FETCH_ASSOC))
                $dataArr[] = $r['count'];

            return json_encode($dataArr);
        } catch(PDOException $e) {
            return "Connection failed: " . $e->getMessage();
        }
    }

}