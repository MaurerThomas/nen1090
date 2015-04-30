<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 21-10-2014
 * Time: 17:20
 */


$host = "localhost";
$db_name = "****";
$username = "****";
$password = "";

try {
    $con = new PDO("mysql:host={$host};dbname={$db_name}", $username, $password);
} // to handle connection error
catch (PDOException $exception) {
    echo "Connection error: " . $exception->getMessage();
}
