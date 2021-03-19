<?php

require_once '/home/xkopalr1/public_html/zadanie3/api/models/UserModel.php';

function handlerBasicRegistration($data)
{
    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL) || empty($data['password']) || empty($data['password-again'] || empty($data['secret'])) ){
        return "Chybny vstup";
    }

    if (strcmp($data['password'], $data['password-again']) != 0){
        return "hesla sa nerovnaju";
    }

    return (new UserModel())->createBasicUser($data);
}

function get2Fa()
{
    $websiteTitle = 'wt78.fei.stuba.sk';

    $ga = new PHPGangsta_GoogleAuthenticator();

    $secret = $ga->createSecret();
    $returnArr['secret'] = $secret; // get the secret for account

    $qrCodeUrl = $ga->getQRCodeGoogleUrl($websiteTitle, $secret);
    $returnArr['qrCodeUrl'] = $qrCodeUrl; // get qr code link

    return json_encode($returnArr);
}