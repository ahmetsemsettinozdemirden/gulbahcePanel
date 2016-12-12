<?php
session_start();

include 'config.php';
include 'includeFunc.php';
$kullaniciadi = $password = $err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $id = fixInput($_POST['id']);
    $name = fixInput($_POST['duzenleicecekadi']);
    $desc = fixInput($_POST['duzenleicecekaciklama']);
    $price = fixInput($_POST['duzenleicecekfiyat']);
    $photoUrl = fixInput($_POST['duzenleicecekphotourl']);

    $postData = array(
        'token' => $_SESSION['token'],
        'id' => $id,
        'name' => $name,
        'desc' => $desc,
        'price' => $price,
        'photoUrl' => $photoUrl,
    );

    $url = 'http://'.$url.':9000/panel/editDrink';

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