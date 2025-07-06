<?php
require_once __DIR__ . '/vendor/autoload.php';

use Twilio\Rest\Client;

function sendWhatsAppMessage($msg) {

// Twilio credentials
$accountSid = 'ACc1f07ff51e2fccb51fae13f1a02a12e4';
$authToken  = '752ddbe6a2948e5358f8a7c135ebf856';
$twilioPhoneNumber = '+14155238886';


    $client = new Client($accountSid, $authToken);

    $message = $client->messages->create(
        "whatsapp:+918080048058",
        [
            "from" => "whatsapp:" . $twilioPhoneNumber,
            "body" => "Your order confirmed successfully $msg
            ",
        ]
    );

    return $message->sid;
}

?>
