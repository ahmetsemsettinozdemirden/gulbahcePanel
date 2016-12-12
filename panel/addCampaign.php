<?php
session_start();

include 'config.php';
include 'includeFunc.php';
$kullaniciadi = $password = $err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $name = fixInput($_POST['eklekampanyaadi']);
    $desc = fixInput($_POST['eklekampanyaaciklama']);
    $price = fixInput($_POST['eklekampanyafiyat']);
    $photoUrl = fixInput($_POST['eklekampanyaphotourl']);

    $postData = array(
        'token' => $_SESSION['token'],
        'name' => $name,
        'desc' => $desc,
        'price' => $price,
        'photoUrl' => $photoUrl,
    );

    $url = 'http://'.$url.':9000/panel/addCampaign';

    $response = httpPost($url, json_encode($postData));
    //echo "Response: ".$response;

    $obj = json_decode($response);

    if ( $obj->{'statusCode'} != 201 ) {
        $err = $obj->{'message'};
        alert($err);
    }else{
        header('Location: index.php?page=kampanyalar&message='.$obj->{'message'});
        exit();
    }
}

?>