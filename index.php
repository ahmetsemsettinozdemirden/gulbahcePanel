<!DOCTYPE html>
<html lang="en-us">
<head>
    <?php
    session_start();
    if(isset($_SESSION['token'])){
        header('Location: panel/index.php');
    }
    ?>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GulbahceCafe Admin Paneli</title>
    <meta http-equiv="Cache-Control" content="no-cache"/>
    <meta http-equiv="pragma" content="no-cache"/>
    <meta name="description" content="Desc." />
    <link href="panel/css/bootstrap.min.css" rel="stylesheet">
    <link href="panel/css/bootstrap-theme.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <link rel="stylesheet" href="panel/css/styles.css" type="text/css">
    <link rel="stylesheet" href="panel/css/font-awesome.min.css">
</head>
<body class="signin">

    <?php

    include 'panel/includeFunc.php';

    $kullaniciadi = $password = $err = "";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $username = fixInput($_POST['username']);
        $password = fixInput($_POST['password']);

        $postData = array(
            'username' => $username,
            'password' => $password,
        );

        $url = 'http://35.156.104.229:9000/panel/signIn';

        $response = httpPost($url, json_encode($postData));
        echo "Response: ".$response;

        $obj = json_decode($response);

        if ( $obj->{'statusCode'} != 201 ) {
            $err = $obj->{'message'};
        }else{
            $_SESSION['token'] = $obj->{'token'};

            header('Location: ./panel/index.php');
            exit();
        }
    }

    ?>

    <div class="container">
        <form class="form-signin" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <h2 class="form-signin-heading">Admin Girisi</h2>
            <label for="inputUsername" class="sr-only">Kullanici adi</label>
            <input type="text" id="inputUsername" name="username" class="form-control" placeholder="kullanici adi" required autofocus>
            <label for="inputPassword" class="sr-only">Sifre</label>
            <input type="password" id="inputPassword" name="password" class="form-control" placeholder="sifre" required>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Giris Yap</button>
            <?php
            if(!empty($err)){
                echo "<div class=\"errbox alert alert-danger alert-dismissable fade in\"><a class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a><strong>Hata!</strong> ".$err."</div>";
            }
            ?>
        </form>
    </div>

    <script type="application/javascript" src="panel/js/jquery-3.1.1.min.js" ></script>
    <script type="application/javascript" src="panel/js/bootstrap.min.js"></script>
    <script type="application/javascript" src="panel/js/scripts.js"></script>
</body>
</html>