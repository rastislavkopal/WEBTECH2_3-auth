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
//
    $ga = new PHPGangsta_GoogleAuthenticator();

    $secret = $ga->createSecret();
    $returnArr['secret'] = $secret; // get the secret for account
//    echo 'Secret is: '.$secret.'<br />';

    $qrCodeUrl = $ga->getQRCodeGoogleUrl($websiteTitle, $secret);
//    echo 'Google Charts URL QR-Code:<br /><img src="'.$qrCodeUrl.'" />';
    $returnArr['qrCodeUrl'] = $qrCodeUrl; // get qr code link

    $myCode = $ga->getCode($secret);
//    echo 'Verifying Code '.$myCode.'<br />';
//    $returnArr['code'] = $myCode;

//third parameter of verifyCode is a multiplicator for 30 seconds clock tolerance
    $result = $ga->verifyCode($secret, $myCode, 1);
    return json_encode($returnArr);
//    if ($result) {
//        echo 'Verified';
//    } else {
//        echo 'Not verified';
//    }
}