<?php

use Pecee\SimpleRouter\SimpleRouter;
include_once  '/home/xkopalr1/public_html/zadanie3/api/controllers/LoginController.php';
include_once '/home/xkopalr1/public_html/zadanie3/api/controllers/RegisterController.php';
include_once '/home/xkopalr1/public_html/zadanie3/api/controllers/LogController.php';



SimpleRouter::post('/zadanie3/api/register', function() {
    $data = input()->all([
        'email',
        'first_name',
        'surname',
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


SimpleRouter::get('/zadanie3/api/userhistory', function() {
    return loginAudit(1);
});

SimpleRouter::get('/zadanie3/api/stats', function() {
    return getStats();
});


SimpleRouter::get('/zadanie3/api/history', function() {
    return loginAudit(0);
});


SimpleRouter::get('/zadanie3/api/logout', function() {
    session_start();
    session_unset();
    session_destroy();
    header('Location: https://wt78.fei.stuba.sk/zadanie3');
});
