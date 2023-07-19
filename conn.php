<?php
    $servername = "localhost";
    $database = "koperasiuas";
    $username = "root";
    $password = "";

    $conn = mysqli_connect($servername, $username,$password, $database);
    if(mysqli_connect_errno())
        echo "Koneksi Gagal";

?>