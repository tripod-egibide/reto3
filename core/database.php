<?php
function connection()
{
    $host = "192.168.2.16";
    $port = "3306";
    $user = "reto";
    $pass = "ProyectoReto3$";
    $database = "reto3";
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
