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

}