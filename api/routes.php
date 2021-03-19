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
        'password-again',
        'secret'
    ]);
    return handlerBasicRegistration($data);
});


SimpleRouter::get('/zadanie3/api/register/2fa', function() {
    return get2Fa();
});


SimpleRouter::get('/zadanie3/api/oauth', function(){
    return handleOauth();
} );


SimpleRouter::post('/zadanie3/api/ldap', function(){
    return handleLdap(input('login_name'),input('password'));
} );


SimpleRouter::post('/zadanie3/api/login', function() {
    $data = input()->all([ 'email', 'password', 'code']);
    return handleBasicLogin($data);
});



SimpleRouter::get('/zadanie3/api/logout', function() {
    session_start();
    session_unset();
    session_destroy();
    header('Location: https://wt78.fei.stuba.sk/zadanie3');
});
