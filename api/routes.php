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

SimpleRouter::get('/zadanie3/api/register/2fa/staticcheck', function() {
    $secret = '57c930e236522a2e8e25e7f4d9c64167';

    $code = "678408";

    $ga = new PHPGangsta_GoogleAuthenticator();
    $result = $ga->verifyCode($secret, $code,1);

    if ($result == 1) {
        echo $result;
    } else {
        echo 'Login failed';
    }
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
    $data = input()->all([ 'email', 'password', 'code']);
    return handleBasicLogin($data);
});



SimpleRouter::get('/zadanie3/api/logout', function() {
    session_start();
    session_unset();
    session_destroy();
    header('Location: https://wt78.fei.stuba.sk/zadanie3');
});
