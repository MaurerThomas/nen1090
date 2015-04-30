<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 29-10-2014
 * Time: 19:05
 */
require_once('includes/config.php');


$query = "SELECT email, user_type, bedrijfsid FROM members WHERE email = :email";
$stmt = $db->prepare($query);
$stmt->execute(array(':email' => $_POST['email']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$bedrijfid = $row['bedrijfsid'];
echo $bedrijfid;
switch ($row['user_type']) {
    case 'admin':
        $loc = 'beheer.php';
        break;
    case 'user':
        $loc = "profiel.php?bedrijfid=$bedrijfid";
        break;
}

header('Location: ' . $loc);
exit();