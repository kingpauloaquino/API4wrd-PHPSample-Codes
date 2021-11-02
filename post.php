<?php

$url = "https://api4wrd.2kpa.me/paymongo/v1/create"; // you will need an app_key, get it from -> https://api4wrd.ukayra.com/register

$redirect = [
    "success" => "your-domain/success.php",
    "failed" => "your-domain/failed.php"
];

$billing = [
    "email" => $_GET["email"],
    "name" =>  $_GET["firstName"] . " " .  $_GET["lastName"],
    "phone" =>  $_GET["mobile"],
    "address" => [
        "line1" =>  $_GET["address"],
        "line2" =>  $_GET["address2"],
        "city" =>  $_GET["city"],
        "state" =>  $_GET["state"],
        "postal_code" =>  $_GET["zip"],
        "country" =>  $_GET["country"]
    ]
];

$attributes = [
    "livemode" => false,
    "type" => "gcash",
    "amount" => 10000,
    "currency" => "PHP",
    "redirect" => $redirect,
    "billing" => $billing,
];

$source = [
    "app_key" => "a327e923e8d7d921ad3d3b06cafd6d13ed4420b6", // get it from -> https://api4wrd.ukayra.com/register
    "secret_key" => "sk_test_HL7BiubdGVbXHXCt2nhf8fNE", // secret key from paymongo - be sure your account is fully activated
    "password" => "your-paymongo-password", // your paymongo account password - be sure your account is fully activated
    "data" => [
        "attributes" => $attributes
    ]
];


$jsonData = json_encode($source);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// disable ssl
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$result = curl_exec($ch);
$resData = json_decode($result, true);

if ($resData["status"] == 200) {
    header("Location: " . $resData["url_redirect"]);
} else {
    header("Location: index.php");
}

die();
