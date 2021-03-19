<?php

require_once '/home/xkopalr1/public_html/zadanie3/api/models/UserModel.php';
require_once '/home/xkopalr1/public_html/zadanie3/api/models/UserAuditModel.php';


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

        if ((new UserAuditModel())->auditLogin($email,"OAUTH") == 0)
            return "Nastala neočakávaná chyba: audit login";

        session_start();
        $_SESSION['email']= $email;
        $_SESSION['name'] = $name;
        $_SESSION['log_type']= "oauth";
        header('Location: https://wt78.fei.stuba.sk/zadanie3/');
    } else {
        header('Location: '.$client->createAuthUrl());
    }
}

function handleLdap($login, $ldappass) // params: ldap credentials
{
    $ldapconn = ldap_connect("ldap.stuba.sk") // connect to ldap server
            or die("Could not connect to LDAP server.");

    $dn  = 'ou=People, DC=stuba, DC=sk';
    $ldaprdn  = "uid=$login, $dn";

    if ($ldapconn)
    {
        $set = ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
        $ldapbind = ldap_bind($ldapconn, $ldaprdn, $ldappass); // binding to ldap server
        // verify binding
        if ($ldapbind) {
            $results=ldap_search($ldapconn,$dn,"uid=*" . $login . "*",array("givenname","surname","mail","cn","uid"),0,1);
            $info=ldap_get_entries($ldapconn,$results);

            session_start();
            $_SESSION['email']= $info[0]['mail'][0];
            $_SESSION['log_type']= "LDAP";
            $_SESSION['name'] = $info[0]['cn'][0];

            if ((new UserAuditModel())->auditLogin($info[0]['mail'][0],"LDAP") == 0)
                return "Nastala neočakávaná chyba: audit login";

            ldap_unbind($ldapconn);
            return "1Úspešné prihlásenie používatela: " . $info[0]['mail'][0];
        } else {
            ldap_unbind($ldapconn);
            return "LDAP - nepodarilo sa prihlásiť";
        }
    }
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