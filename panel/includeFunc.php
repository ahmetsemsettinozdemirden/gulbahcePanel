<?php

function httpPost($url, $data){
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL,            $url );
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt($ch, CURLOPT_POST,           1 );
    curl_setopt($ch, CURLOPT_POSTFIELDS,     $data );
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

    $result=curl_exec ($ch);
    return $result;
}

function fixInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function alert($message){
    echo "<script language=\"javascript\">";
    echo "alert(\"".$message."\")";
    echo "</script>";
}

?>
