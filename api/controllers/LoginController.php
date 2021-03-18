<?php

function handleOauth()
{
    require_once 'vendor/autoload.php';
    $string = file_get_contents("/home/xkopalr1/public_html/credentials.json");
    $json_a = null;
    if ($string === false || ($json_a = json_decode($string, true)) == null) {
        return "unable to load credentials";
    }

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
    if (isset($_GET['code'])) {
        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
        $client->setAccessToken($token['access_token']);

        // get profile info
        $google_oauth = new Google_Service_Oauth2($client);
        $google_account_info = $google_oauth->userinfo->get();
        $email =  $google_account_info->email;
        $name =  $google_account_info->name;

        // now you can use this profile info to create account in your website and make user logged in.
        echo var_dump($token) . "   .... " . $email . " ..... " .$name;
    } else {
        echo $client->createAuthUrl();
    }
}

function handleLdap()
{
    return "not yet";
}

function handleBasicLogin()
{
    return "not yet";
}