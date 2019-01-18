<?php
function connection()
{
    if (__DIR__ == '/vagrant/code/public/AppEventos/core') {
        $host = "localhost";
        $port = "33060";
        $user = "homestead";
        $pass = "secret";
        $database = "homestead";
    } else {
        $host = "localhost";
        $port = "3306";
        $user = "root";
        $pass = "";
        $database = "reto3";
    }


    $con = new PDO("mysql:$host;port=$port;dbname=$database", $user, $pass);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $con->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $con;
}

function preparedStatement($query, $data)
{
    $con = connection();
    $stmt = $con->prepare("$query");
    $stmt->execute($data);
    $con = null;
    return $stmt;
}