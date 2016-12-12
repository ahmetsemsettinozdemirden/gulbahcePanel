<?php
session_start();

include 'config.php';
include 'includeFunc.php';
$kullaniciadi = $password = $err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $name = fixInput($_POST['ekleicecekadi']);
    $desc = fixInput($_POST['ekleicecekaciklama']);
    $price = fixInput($_POST['ekleicecekfiyat']);
    $photoUrl = fixInput($_POST['ekleicecekphotourl']);

    $postData = array(
        'token' => $_SESSION['token'],
        'name' => $name,
        'desc' => $desc,
        'price' => $price,
        'photoUrl' => $photoUrl,
    );

    $url = 'http://'.$url.':9000/panel/addDrink';

    $response = httpPost($url, json_encode($postData));
    echo $response;

    $obj = json_decode($response);

    if ( $obj->{'statusCode'} != 201 ) {
        $err = $obj->{'message'};
        alert($err);
    }else{
        header('Location: index.php?page=icecekler&message='.$obj->{'message'});
        exit();
    }
}

?>