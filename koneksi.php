<?php
function getConnection()
{
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbName = "latihan_sql";

    $conn = new mysqli($servername, $username, $password, $dbName);

    if ($conn->connect_error) {
        die("Koneksi gagal:" . $conn->connect_error);
    }

    return $conn;
}
