<?php

use Pecee\SimpleRouter\SimpleRouter;

SimpleRouter::get('/zadanie3/api/', function() {
    return 'Hello world';
});

SimpleRouter::get('/zadanie3/api/user', function() {
    return 'Hello user';
});