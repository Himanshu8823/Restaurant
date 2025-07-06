<?php 
    require_once('vendor/autoload.php');

    $google_client= new Google_Client();
    $google_client->setClientId("$client");
    $google_client->setClientSecret($secret);
    $google_client->setRedirectUri($uri);

    $google_client->addScope('email');
    $google_client->addScope('profile');
    $google_client->addScope('https://www.googleapis.com/auth/user.addresses.read');
    $google_client->addScope('https://www.googleapis.com/auth/user.phonenumbers.read');
?>