<?php
session_start();

include 'config.php';
include 'includeFunc.php';
$kullaniciadi = $password = $err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $name = fixInput($_POST['eklemenuadi']);
    $desc = fixInput($_POST['eklemenuaciklama']);
    $price = fixInput($_POST['eklemenufiyat']);
    $photoUrl = fixInput($_POST['eklemenuphotourl']);

    $postData = array(
        'token' => $_SESSION['token'],
        'name' => $name,
        'desc' => $desc,
        'price' => $price,
        'photoUrl' => $photoUrl,
    );

    $url = 'http://'.$url.':9000/panel/addMenu';

    $response = httpPost($url, json_encode($postData));
    //echo "Response: ".$response;

    $obj = json_decode($response);

    if ( $obj->{'statusCode'} != 201 ) {
        $err = $obj->{'message'};
        alert($err);
    }else{
        header('Location: index.php?page=menuler&message='.$obj->{'message'});
        exit();
    }
}

?>