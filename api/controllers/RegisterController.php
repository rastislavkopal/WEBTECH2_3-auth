<?php

require_once '/home/xkopalr1/public_html/zadanie3/api/models/UserModel.php';

function handlerBasicRegistration($data)
{
    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL))
        return "Nespravny format emailu.";
    else if (empty($data['password']) || empty($data['password-again']) )
        return "Heslo nesmie byt prazdne";
    else if (empty($data['secret']) || empty($data['first_name']) || empty($data['surname']))
        return "Nespravne zadané údaje";


    if (strcmp($data['password'], $data['password-again']) != 0){
        return "hesla sa nerovnaju";
    }

    return (new UserModel())->createBasicUser($data, md5($data['password']));
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