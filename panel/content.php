<body>

<?php

$debug = false;

$queryArr = array();
parse_str($_SERVER['QUERY_STRING'], $queryArr);

?>

<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="?page=siparisler">Gulbahce Cafe</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="cikisyap.php">Cikis Yap</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid mainContainer">
    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <ul class="nav nav-sidebar">
                <?php

                $menuList = array("Siparisler", "Kampanyalar", "Menuler", "Icecekler", "Kullanicilar", "Sistem");
                if (!isset($queryArr['page'])) {
                    echo "<li class=\"active\"><a href=\"?page=siparisler\">Siparisler<span class=\"sr-only\">(current)</span></a></li>";
                    foreach ($menuList as $menuButton) {
                        if (strtolower($menuButton) !== "siparisler") {
                            echo "<li><a href=\"?page=$menuButton\">$menuButton</a></li>";
                        }
                    }
                } else {
                    foreach ($menuList as $menuButton) {
                        if (strtolower($menuButton) == strtolower($queryArr['page'])) {
                            echo "<li class=\"active\"><a href=\"?page=$menuButton\">$menuButton<span class=\"sr-only\">(current)</span></a></li>";
                        } else {
                            echo "<li><a href=\"?page=$menuButton\">$menuButton</a></li>";
                        }
                    }
                }
                ?>
            </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

            <?php

            if (!isset($queryArr['page']) || strtolower($queryArr['page']) == 'siparisler'){

            $response = httpPost('http://35.156.104.229:9000/panel/getOrders', json_encode(array('token' => $_SESSION['token'])));

            if ($debug) echo $response;

            $obj = json_decode($response);

            if ($obj->{'statusCode'} != 201) {
                $err = $obj->{'message'};
            } else {
                $siparisler = $obj->{'orders'};
            }

            if (!empty($err)) {
                echo "<div class=\"errbox alert alert-danger alert-dismissable fade in\"><a class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a><strong>Hata!</strong> " . $err . "</div>";
            }
            if(isset($queryArr['message']))
                echo "<div class=\"errbox alert alert-success alert-dismissable fade in\"><a class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>" . $queryArr['message'] . "</div>";


            ?>
            <div>
                <h1 class="page-header">Siparisler</h1>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Tel</th>
                            <th>Isim</th>
                            <th>Adres</th>
                            <th>Siparis</th>
                            <th>Notlar</th>
                            <th>Durum</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php

                        foreach ($siparisler as $siparis) {
                            echo "<tr>";
                            echo "<td>" . $siparis->{'phoneNumber'} . "</td>";
                            echo "<td>" . $siparis->{'name'} . "</td>";
                            echo "<td>" . $siparis->{'address'} . "</td><td>";

                            $siparisEdilenUrunler = $siparis->{'basket'};
                            foreach ($siparisEdilenUrunler as $key => $order) {
                                echo $order->{'quantity'} . " adet " . $order->{'name'} . $order->{'type'};
                                if ($key !== count($siparisEdilenUrunler) - 1) {
                                    echo ", ";
                                }
                            }

                            echo "</td><td>" . $siparis->{'notes'};
                            echo "</td><td>" . $siparis->{'status'};
                            echo "</tr>";
                        }

                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php } else if (strtolower($queryArr['page']) == 'kampanyalar'){

            $response = httpPost('http://35.156.104.229:9000/panel/getCampaigns', json_encode(array('token' => $_SESSION['token'])));

            if ($debug) echo $response;

            $obj = json_decode($response);

            if ($obj->{'statusCode'} != 201) {
                $err = $obj->{'message'};
            } else {
                $kampanyalar = $obj->{'campaigns'};
            }

            if (!empty($err)) {
                echo "<div class=\"errbox alert alert-danger alert-dismissable fade in\"><a class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a><strong>Hata!</strong> " . $err . "</div>";
            }
            if(isset($queryArr['message']))
                echo "<div class=\"errbox alert alert-success alert-dismissable fade in\"><a class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>" . $queryArr['message'] . "</div>";

            ?>
            <div>
                <h1 class="page-header">Kampanyalar</h1>
                <h3>Kampanya Olustur</h3>
                <form action="addCampaign.php" method="post">
                    <div class="form-group">
                        <label for="eklekampanyaadi">Kampanya adi</label>
                        <input type="text" class="form-control" id="eklekampanyaadi" name="eklekampanyaadi"
                               placeholder="ad" required autofocus>
                    </div>
                    <div class="form-group">
                        <label for="eklekampanyaaciklama">Aciklama</label>
                        <input type="text" class="form-control" id="eklekampanyaaciklama" name="eklekampanyaaciklama"
                               placeholder="aciklama" required>
                    </div>
                    <!-- v2
                    <div class="form-group">
                        <h3> == Icerdigi Urunler == </h3>
                    </div>
                    -->
                    <div class="form-group">
                        <label for="eklekampanyafiyat">Fiyat</label>
                        <input type="number" class="form-control" id="eklekampanyafiyat" name="eklekampanyafiyat"
                               placeholder="fiyat" required>
                    </div>
                    <div class="form-group">
                        <h3> == Kampanya bitis tarihi == </h3>
                    </div>
                    <div class="form-group">
                        <label for="eklekampanyaphotourl">PhotoUrl</label>
                        <input type="url" class="form-control" id="eklekampanyaphotourl" name="eklekampanyaphotourl"
                               placeholder="url" required>
                    </div>
                    <!--<div class="form-group">
                            <label for="ekleresim">Resim ekle</label>
                            <input type="file" id="ekleresim">
                            <p class="help-block">Uygulamada gorunecek resmi buraya yukleyiniz.</p>
                        </div>-->
                    <button type="submit" class="btn btn-default">Ekle</button>
                </form>
                <h3>Tum Urunler</h3>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Resim</th>
                            <th>Ad</th>
                            <th>Aciklama</th>
                            <!-- <th>Icerdigi Urunler</th> v2 -->
                            <th>Fiyat</th>
                            <th>Bitis tarihi</th>
                            <th>Secenekler</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php

                        foreach ($kampanyalar as $key => $kampanya) {
                            echo "<tr>";
                            echo "<td>$key</td>";
                            echo "<td><img src=\"" . $kampanya->{'photoUrl'} . "\" alt=\"" . $kampanya->{'name'} . " resmi\" class=\"img-responsive img-rounded miniPhoto\"></td>";
                            echo "<td>" . $kampanya->{'name'} . "</td>";
                            echo "<td>" . $kampanya->{'desc'} . "</td>";
                            // echo "<td>-</td>"; // v2
                            echo "<td>" . $kampanya->{'price'} . " TL</td>";
                            echo "<td>" . $kampanya->{'time'} . "</td>";
                            echo "<td><form action=\"deleteCampaign.php\" method=\"post\" class=\"pull-left\"><input type=\"hidden\" name=\"id\" value=\"".$kampanya->{'_id'}."\"><input type=\"submit\" value=\"Sil\" class=\"btn btn-danger\"></form></td>";
                            echo "</tr>";
                        }

                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php } else if (strtolower($queryArr['page']) == 'menuler'){

            $response = httpPost('http://35.156.104.229:9000/panel/getMenus', json_encode(array('token' => $_SESSION['token'])));

            if ($debug) echo $response;

            $obj = json_decode($response);

            if ($obj->{'statusCode'} != 201) {
                $err = $obj->{'message'};
            } else {
                $menuler = $obj->{'menus'};
            }

            if (!empty($err)) {
                echo "<div class=\"errbox alert alert-danger alert-dismissable fade in\"><a class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a><strong>Hata!</strong> " . $err . "</div>";
            }
            if(isset($queryArr['message']))
                echo "<div class=\"errbox alert alert-success alert-dismissable fade in\"><a class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>" . $queryArr['message'] . "</div>";

            ?>
            <div>
                <h1 class="page-header">Menuler</h1>
                <h3>Menu Olustur</h3>
                <form action="addMenu.php" method="post">
                    <div class="form-group">
                        <label for="eklemenuadi">Menu adi</label>
                        <input type="text" class="form-control" id="eklemenuadi" name="eklemenuadi" placeholder="ad"
                               required autofocus>
                    </div>
                    <div class="form-group">
                        <label for="eklemenuaciklama">Aciklama</label>
                        <input type="text" class="form-control" id="eklemenuaciklama" name="eklemenuaciklama"
                               placeholder="aciklama" required>
                    </div>
                    <!-- v2
                    <div class="form-group">
                        <h2>Icerdigi Urunler</h2>
                    </div> -->
                    <div class="form-group">
                        <label for="eklemenufiyat">Fiyat</label>
                        <input type="number" class="form-control" id="eklemenufiyat" name="eklemenufiyat"
                               placeholder="fiyat" required>
                    </div>
                    <div class="form-group">
                        <label for="eklemenuphotourl">PhotoUrl</label>
                        <input type="url" class="form-control" id="eklemenuphotourl" name="eklemenuphotourl"
                               placeholder="url" required>
                    </div>
                    <!--<div class="form-group">
                            <label for="ekleresim">Resim ekle</label>
                            <input type="file" id="ekleresim">
                            <p class="help-block">Uygulamada gorunecek resmi buraya yukleyiniz.</p>
                        </div>-->
                    <button type="submit" class="btn btn-default">Ekle</button>
                </form>
                <h3>Tum Urunler</h3>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Resim</th>
                            <th>Ad</th>
                            <th>Aciklama</th>
                            <!-- <th>Icerdigi Urunler</th> == v2 == -->
                            <th>Fiyat</th>
                            <th>Secenekler</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php

                        foreach ($menuler as $key => $menu) {
                            echo "<tr>";
                            echo "<td>$key</td>";
                            echo "<td><img src=\"" . $menu->{'photoUrl'} . "\" alt=\"" . $menu->{'name'} . " resmi\" class=\"img-responsive img-rounded miniPhoto\"></td>";
                            echo "<td>" . $menu->{'name'} . "</td>";
                            echo "<td>" . $menu->{'desc'} . "</td>";
                            // echo "<td>-</td>"; // v2
                            echo "<td>" . $menu->{'price'} . " TL</td>";
                            echo "<td><form action=\"index.php\" method=\"get\" class=\"pull-left\"><input type=\"hidden\" name=\"page\" value=\"menuduzenle\"><input type=\"hidden\" name=\"id\" value=\"".$menu->{'_id'}."\"><input type=\"hidden\" name=\"name\" value=\"".$menu->{'name'}."\"><input type=\"hidden\" name=\"desc\" value=\"".$menu->{'desc'}."\"><input type=\"hidden\" name=\"price\" value=\"".$menu->{'price'}."\"><input type=\"hidden\" name=\"photoUrl\" value=\"".$menu->{'photoUrl'}."\"><input type=\"submit\" value=\"Duzenle\" class=\"btn btn-default\"></form><form action=\"deleteMenu.php\" method=\"post\" class=\"pull-left\" style=\"margin-left: 10px\"><input type=\"hidden\" name=\"id\" value=\"".$menu->{'_id'}."\"><input type=\"submit\" value=\"Sil\" class=\"btn btn-danger\"></form></td>";
                            echo "</tr>";
                        }

                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php } else if (strtolower($queryArr['page']) == 'icecekler'){

            $response = httpPost('http://35.156.104.229:9000/panel/getDrinks', json_encode(array('token' => $_SESSION['token'])));

            if ($debug) echo $response;

            $obj = json_decode($response);

            if ($obj->{'statusCode'} != 201) {
                $err = $obj->{'message'};
            } else {
                $icecekler = $obj->{'drinks'};
            }

            if (!empty($err)) {
                echo "<div class=\"errbox alert alert-danger alert-dismissable fade in\"><a class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a><strong>Hata!</strong> " . $err . "</div>";
            }
            if(isset($queryArr['message']))
                echo "<div class=\"errbox alert alert-success alert-dismissable fade in\"><a class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>" . $queryArr['message'] . "</div>";

            ?>
            <div>
                <h1 class="page-header">Icecekler</h1>
                <h3>Icecek Ekle</h3>
                <form action="addDrink.php" method="post">
                    <div class="form-group">
                        <label for="ekleicecekadi">Icecek adi</label>
                        <input type="text" class="form-control" id="ekleicecekadi" name="ekleicecekadi" placeholder="ad"
                               required autofocus>
                    </div>
                    <div class="form-group">
                        <label for="ekleicecekaciklama">Aciklama</label>
                        <input type="text" class="form-control" id="ekleicecekaciklama" name="ekleicecekaciklama"
                               placeholder="aciklama" required>
                    </div>
                    <div class="form-group">
                        <label for="ekleicecekfiyat">Fiyat</label>
                        <input type="number" class="form-control" id="ekleicecekfiyat" name="ekleicecekfiyat"
                               placeholder="fiyat" required>
                    </div>
                    <div class="form-group">
                        <label for="ekleicecekphotourl">PhotoUrl</label>
                        <input type="text" class="form-control" id="ekleicecekphotourl" name="ekleicecekphotourl"
                               placeholder="url" required>
                    </div>
                    <!--<div class="form-group">
                            <label for="ekleresim">Resim ekle</label>
                            <input type="file" id="ekleresim">
                            <p class="help-block">Uygulamada gorunecek resmi buraya yukleyiniz.</p>
                        </div>-->
                    <button type="submit" class="btn btn-default">Ekle</button>
                </form>
                <h3>Tum Icecekler</h3>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Resim</th>
                            <th>Ad</th>
                            <th>Aciklama</th>
                            <th>Fiyat</th>
                            <th>Secenekler</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php

                        foreach ($icecekler as $key => $icecek) {
                            echo "<tr>";
                            echo "<td>$key</td>";
                            echo "<td><img src=\"" . $icecek->{'photoUrl'} . "\" alt=\"" . $icecek->{'name'} . " resmi\" class=\"img-responsive img-rounded miniPhoto\"></td>";
                            echo "<td>" . $icecek->{'name'} . "</td>";
                            echo "<td>" . $icecek->{'desc'} . "</td>";
                            echo "<td>" . $icecek->{'price'} . " TL</td>";
                            echo "<td><form action=\"index.php\" method=\"get\" class=\"pull-left\" ><input type=\"hidden\" name=\"page\" value=\"icecekduzenle\"><input type=\"hidden\" name=\"id\" value=\"".$icecek->{'_id'}."\"><input type=\"hidden\" name=\"name\" value=\"".$icecek->{'name'}."\"><input type=\"hidden\" name=\"desc\" value=\"".$icecek->{'desc'}."\"><input type=\"hidden\" name=\"price\" value=\"".$icecek->{'price'}."\"><input type=\"hidden\" name=\"photoUrl\" value=\"".$icecek->{'photoUrl'}."\"><input type=\"submit\" value=\"Duzenle\" class=\"btn btn-default\"></form><form action=\"deleteDrink.php\" method=\"post\" class=\"pull-left\" style=\"margin-left: 10px\"><input type=\"hidden\" name=\"id\" value=\"".$icecek->{'_id'}."\"><input type=\"submit\" value=\"Sil\" class=\"btn btn-danger\"></form></td>";
                            echo "</tr>";
                        }

                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php } else if (strtolower($queryArr['page']) == 'kullanicilar'){

        $response = httpPost('http://35.156.104.229:9000/panel/getUsers', json_encode(array('token' => $_SESSION['token'])));

        if ($debug) echo $response;

        $obj = json_decode($response);

        if ($obj->{'statusCode'} != 201) {
            $err = $obj->{'message'};
        } else {
            $kullanicilar = $obj->{'users'};
        }

        if (!empty($err)) {
            echo "<div class=\"errbox alert alert-danger alert-dismissable fade in\"><a class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a><strong>Hata!</strong> " . $err . "</div>";
        }
        if(isset($queryArr['message']))
            echo "<div class=\"errbox alert alert-success alert-dismissable fade in\"><a class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>" . $queryArr['message'] . "</div>";


        ?>
        <div>
            <h1 class="page-header">Kullanicilar</h1>
            <h3>Tum Kullanicilar</h3>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Ad</th>
                        <th>Telefon</th>
                        <th>Secenekler</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php

                    foreach ($kullanicilar as $key => $kullanici) {
                        echo "<tr>";
                        echo "<td>$key</td>";
                        echo "<td>" . $kullanici->{'name'} . "</td>";
                        echo "<td>" . $kullanici->{'phoneNumber'} . "</td>";
                        echo "<td>-</td>";
                        echo "</tr>";
                    }

                    ?>
                    </tbody>
                </table>
            </div>
            <?php } else if (strtolower($queryArr['page']) == 'sistem') { ?>
                <div>
                    <h1 class="page-header">Sistem</h1>
                </div>
            <?php } else if (strtolower($queryArr['page']) == 'icecekduzenle') {

                ?>
                <div>
                    <h3>Icecek Duzenle</h3>
                    <form action="editDrink.php" method="post">
                        <input type="hidden" name="id" value="<?php echo $queryArr['id']?>">
                        <div class="form-group">
                            <label for="duzenleicecekadi">Icecek adi</label>
                            <input type="text" class="form-control" id="duzenleicecekadi" name="duzenleicecekadi" value="<?php echo $queryArr['name']?>" placeholder="ad"
                                   required autofocus>
                        </div>
                        <div class="form-group">
                            <label for="duzenleicecekaciklama">Aciklama</label>
                            <input type="text" class="form-control" id="duzenleicecekaciklama" name="duzenleicecekaciklama" value="<?php echo $queryArr['desc']?>"
                                   placeholder="aciklama" required>
                        </div>
                        <div class="form-group">
                            <label for="duzenleicecekfiyat">Fiyat</label>
                            <input type="number" class="form-control" id="duzenleicecekfiyat" name="duzenleicecekfiyat" value="<?php echo $queryArr['price']?>"
                                   placeholder="fiyat" required>
                        </div>
                        <div class="form-group">
                            <label for="duzenleicecekphotourl">PhotoUrl</label>
                            <input type="text" class="form-control" id="duzenleicecekphotourl" name="duzenleicecekphotourl" value="<?php echo $queryArr['photoUrl']?>"
                                   placeholder="url" required>
                        </div>
                        <!--<div class="form-group">
                                <label for="duzenleresim">Resim duzenle</label>
                                <input type="file" id="duzenleresim">
                                <p class="help-block">Uygulamada gorunecek resmi buraya yukleyiniz.</p>
                            </div>-->
                        <button type="submit" class="btn btn-default">Guncelle</button>
                    </form>
                </div>
            <?php } else if (strtolower($queryArr['page']) == 'menuduzenle') {

                ?>
                <div>
                    <h3>Menu Duzenle</h3>
                    <form action="editMenu.php" method="post">
                        <input type="hidden" name="id" value="<?php echo $queryArr['id']?>">
                        <div class="form-group">
                            <label for="duzenlemenuadi">Menu adi</label>
                            <input type="text" class="form-control" id="duzenlemenuadi" name="duzenlemenuadi" value="<?php echo $queryArr['name']?>" placeholder="ad"
                                   required autofocus>
                        </div>
                        <div class="form-group">
                            <label for="duzenlemenuaciklama">Aciklama</label>
                            <input type="text" class="form-control" id="duzenlemenuaciklama" name="duzenlemenuaciklama" value="<?php echo $queryArr['desc']?>"
                                   placeholder="aciklama" required>
                        </div>
                        <!-- v2
                        <div class="form-group">
                            <h2>Icerdigi Urunler</h2>
                        </div> -->
                        <div class="form-group">
                            <label for="duzenlemenufiyat">Fiyat</label>
                            <input type="number" class="form-control" id="duzenlemenufiyat" name="duzenlemenufiyat" value="<?php echo $queryArr['price']?>"
                                   placeholder="fiyat" required>
                        </div>
                        <div class="form-group">
                            <label for="duzenlemenuphotourl">PhotoUrl</label>
                            <input type="url" class="form-control" id="duzenlemenuphotourl" name="duzenlemenuphotourl" value="<?php echo $queryArr['photoUrl']?>"
                                   placeholder="url" required>
                        </div>
                        <!--<div class="form-group">
                                <label for="duzenleresim">Resim duzenle</label>
                                <input type="file" id="duzenleresim">
                                <p class="help-block">Uygulamada gorunecek resmi buraya yukleyiniz.</p>
                            </div>-->
                        <button type="submit" class="btn btn-default">Guncelle</button>
                    </form>
                </div>
            <?php } ?>

        </div>
    </div>
</div>

<script type="application/javascript" src="js/jquery-3.1.1.min.js"></script>
<script type="application/javascript" src="js/bootstrap.min.js"></script>
<script type="application/javascript" src="js/scripts.js"></script>
</body>
</html>