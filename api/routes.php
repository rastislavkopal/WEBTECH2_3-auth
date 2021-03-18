<?php

use Pecee\SimpleRouter\SimpleRouter;
require_once './controllers/LoginController.php';


SimpleRouter::get('/zadanie3/api/', function() {
    return 'Hello world';
});


SimpleRouter::get('/zadanie3/api/user', function() {
    return 'Hello user';
});


SimpleRouter::get('/zadanie3/api/oauth', handleOauth());


SimpleRouter::get('/zadanie3/api/ldap', handleLdap() );


SimpleRouter::get('/zadanie3/api/login', function() {
    session_start();
    $_SESSION['meno']="xxx";
    return "meno je: ".$_SESSION['meno']."<br />";
    handleBasicLogin();
});


SimpleRouter::get('/zadanie3/api/logout', function() {
    session_start();
    session_unset();
    session_destroy();
    return "meno je: ".$_SESSION['meno']."<br />";
});
