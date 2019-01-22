<?php
function connection()
{
    // esto es temporal, para facilitar la produccion
    // no estará en el producto final
    if (__DIR__ == '/vagrant/code/public/reto3/core') {
        $host = "localhost";
        $port = "33060";
        $user = "homestead";
        $pass = "secret";
        $database = "homestead";
    } else {
        $host = "localhost";
        $port = "3306";
        $user = "reto3";
        $pass = "reto3";
        $database = "reto3";
    }


    $con = new PDO("mysql:$host;port=$port;dbname=$database;charset=UTF8", $user, $pass);
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