<?php

use Pecee\SimpleRouter\SimpleRouter;
include_once  '/home/xkopalr1/public_html/zadanie3/api/controllers/LoginController.php';
include_once '/home/xkopalr1/public_html/zadanie3/api/controllers/RegisterController.php';


SimpleRouter::get('/zadanie3/api/', function() {
    return 'Hello world';
});


SimpleRouter::get('/zadanie3/api/user', function() {
    return 'Hello user';
});


SimpleRouter::post('/zadanie3/api/register', function() {
    $data = input()->all([
        'email',
        'password',
        'password-again'
    ]);
    return handlerBasicRegistration($data);
});

SimpleRouter::get('/zadanie3/api/oauth', function(){
    return "here i am";
});

SimpleRouter::get('/zadanie3/api/logoauth', function(){
    return "not yet oauth";
//    return handleOauth();
} );


SimpleRouter::get('/zadanie3/api/ldap', function(){

    return "not yet ldap";
//    return handleLdap();
} );


SimpleRouter::post('/zadanie3/api/login', function() {
    $data = input()->all([ 'email', 'password']);
    return handleBasicLogin($data);
});


SimpleRouter::get('/zadanie3/api/logout', function() {
    session_start();
    session_unset();
    session_destroy();
    return "meno je: ".$_SESSION['meno']."<br />";
});
