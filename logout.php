<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 24-10-2014
 * Time: 14:50
 */

require_once('includes/config.php');
//logout
$user->logout();
//logged in return to index page
header('Location: index');
exit;