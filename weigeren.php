<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 29-10-2014
 * Time: 19:16
 */

include_once('./includes/config.php');

$id = $_GET['id'];

$stmt = $db->prepare('DELETE FROM bedrijven WHERE bedrijfsid = ? ');
$stmt->execute(array($id));

header('Location: ../beheer');