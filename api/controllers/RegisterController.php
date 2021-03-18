<?php

require_once '/home/xkopalr1/public_html/zadanie3/api/models/UserModel.php';

function handlerBasicRegistration($data)
{
    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL) || empty($data['password']) || empty($data['password-again']) ){
        return "Chybny vstup";
    }

    if (strcmp($data['password'], $data['password-again']) != 0){
        return "hesla sa nerovnaju";
    }

    return (new UserModel())->createBasicUser($data);
}