<?php

require_once '/home/xkopalr1/public_html/zadanie3/api/models/UserModel.php';


function handleOauth()
{
    require_once '/home/xkopalr1/public_html/zadanie3/api/vendor/autoload.php';
    $string = file_get_contents("/home/xkopalr1/public_html/credentials.json");
    $json_a = null;
    if ($string === false || ($json_a = json_decode($string, true)) == null)
        return "unable to load credentials";

// init configuration
    $clientID = $json_a['web']['client_id'];
    $clientSecret = $json_a['web']['client_secret'];
    $redirectUri = $json_a['web']['redirect_uris'][0];

// create Client Request to access Google API
    $client = new Google_Client();
    $client->setClientId($clientID);
    $client->setClientSecret($clientSecret);
    $client->setRedirectUri($redirectUri);
    $client->addScope("email");
    $client->addScope("profile");

// authenticate code from Google OAuth Flow
    if (isset($_GET['code']))
    {
        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
        $client->setAccessToken($token['access_token']);

        // get profile info
        $google_oauth = new Google_Service_Oauth2($client);
        $google_account_info = $google_oauth->userinfo->get();
        $email =  $google_account_info->email;
        $name =  $google_account_info->name;
// now you can use this profile info to create account in your website and make user logged in.

        session_start();
        $_SESSION['email']= $email;
        $_SESSION['name'] = $name;
        $_SESSION['log_type']= "oauth";
        header('Location: https://wt78.fei.stuba.sk/zadanie3/');
    } else {
        echo $client->createAuthUrl();
        header('Location: '.$client->createAuthUrl());
    }
}

function handleLdap()
{
    return "not yet";
}

// gets $data -> email and pass's hash
function handleBasicLogin($data)
{
    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL) || empty($data['password'])){
        return "Chybny vstup";
    }
    $userModel = new UserModel();

    if (empty($data['code']))
        return "Overovaci kód nesmie byť prázdny.";

    $ga = new PHPGangsta_GoogleAuthenticator();
    $result = $ga->verifyCode($userModel->getUserSecret($data['email']), $data['code']);

    if ($result != 1) {
        return $result ." - Overovací kód nie je správny";
    }

    if ($userModel->verifyUserPass($data['email'], md5($data['password'])) ){ // true => hash matches
        session_start();
        $_SESSION['email']= $data['email'];
        $_SESSION['name'] = "";
        $_SESSION['log_type']= "basic";
        return "1Uspesne prihlasenie uzivatela: ". $_SESSION['email'];
    } else{
        return "Nepodarilo sa prihlasit";
    }
}