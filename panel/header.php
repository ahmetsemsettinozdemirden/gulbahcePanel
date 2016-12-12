<!DOCTYPE html>
<html lang="en-us">
<head>
    <?php
    session_start();

    include 'config.php';
    include 'includeFunc.php';
    if(!isset($_SESSION['token'])){
        header('Location: ../index.php');
    }
    ?>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GulbahceCafe Admin Paneli</title>
    <meta http-equiv="Cache-Control" content="no-cache"/>
    <meta http-equiv="pragma" content="no-cache"/>
    <meta name="description" content="Desc." />
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-theme.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/styles.css" type="text/css">
</head>