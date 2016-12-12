<?php
session_start();

include 'config.php';
include 'includeFunc.php';
$kullaniciadi = $password = $err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $id = fixInput($_POST['id']);
    $name = fixInput($_POST['duzenlemenuadi']);
    $desc = fixInput($_POST['duzenlemenuaciklama']);
    $price = fixInput($_POST['duzenlemenufiyat']);
    $photoUrl = fixInput($_POST['duzenlemenuphotourl']);

    $postData = array(
        'token' => $_SESSION['token'],
        'id' => $id,
        'name' => $name,
        'desc' => $desc,
        'price' => $price,
        'photoUrl' => $photoUrl,
    );

    $url = 'http://'.$url.':9000/panel/editMenu';

    $response = httpPost($url, json_encode($postData));
    echo $response;

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