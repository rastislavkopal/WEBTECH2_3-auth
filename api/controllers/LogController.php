<?php

require_once '/home/xkopalr1/public_html/zadanie3/api/models/UserModel.php';
require_once '/home/xkopalr1/public_html/zadanie3/api/models/UserAuditModel.php';



function loginAudit($condition) // 1 = per user log
{
    session_start();

    if (!isset($_SESSION['email']) || !isset($_SESSION['log_type']) || empty($_SESSION['email']) || empty($_SESSION['log_type']))
        return "Not allowed";


    if ($condition) { // log for user
        return (new UserAuditModel())->getUserAudit($_SESSION['email'], $_SESSION['log_type']);
    } else { // get full logs
        return (new UserAuditModel())->getAuditds();
    }
}