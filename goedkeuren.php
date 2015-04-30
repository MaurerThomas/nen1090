<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 29-10-2014
 * Time: 19:16
 */
include_once('includes/config.php');
$email = $_SESSION["email"];
if (!$user->is_logged_in()) {
    header('Location: login');
}

if ($user->getRoleFromDb($email) == 'user') {
    header('Location: login');
}
$id = $_GET['id'];

$stmt = $db->prepare('UPDATE bedrijven SET goedgekeurd = "Ja" WHERE bedrijfsid = ? ');
$stmt->execute(array($id));

header('Location: beheer');