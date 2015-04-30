<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 24-10-2014
 * Time: 14:12
 */


ob_start();
session_start();

//set timezone
date_default_timezone_set('Europe/London');

//database credentials
define('DBHOST', 'localhost');
define('DBUSER', 'root');
define('DBPASS', "");
define('DBNAME', 'nen1090');

//application address
define('DIR', 'http://nen1090bank.nl/');
define('SITEEMAIL', 'info@nen1090bank.nl');

try {

    //create PDO connection
    $db = new PDO("mysql:host=" . DBHOST . ";dbname=" . DBNAME, DBUSER, DBPASS);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    //show error
    echo '<p class="bg-danger">' . $e->getMessage() . '</p>';
    exit;
}

//include the user class, pass in the database connection
include('classes/user.php');
$user = new User($db);