<?php
session_start();

include 'includeFunc.php';
$kullaniciadi = $password = $err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $id = fixInput($_POST['id']);

    $postData = array(
        'token' => $_SESSION['token'],
        'id' => $id,
    );

    $url = 'http://35.156.104.229:9000/panel/deleteMenu';

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