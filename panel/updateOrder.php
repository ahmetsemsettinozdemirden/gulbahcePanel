<?php
session_start();

include 'config.php';
include 'includeFunc.php';
$kullaniciadi = $password = $err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $id = fixInput($_POST['id']);
    $status = fixInput($_POST['status']);

    $postData = array(
        'token' => $_SESSION['token'],
        'id' => $id,
        'status' => $status,
    );

    $url = 'http://'.$url.':9000/panel/updateOrder';

    $response = httpPost($url, json_encode($postData));
    echo $response;

    $obj = json_decode($response);

    if ( $obj->{'statusCode'} != 201 ) {
        $err = $obj->{'message'};
        alert($err);
    }else{
        header('Location: index.php?page=siparisler&message='.$obj->{'message'});
        exit();
    }
}

?>