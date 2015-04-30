<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 21-10-2014
 * Time: 16:11
 */

include_once('includes/config.php');

?>

<div class="header">
    <ul class="nav nav-pills pull-right">

        <li class="medium"><a href="../overdezewebsite"> Over deze website</a></li>
        <li class="medium"><a href="../contact"> Contact Pagina</a></li>

        <?php
        if (!$user->is_logged_in()) {
            echo '<li class="active" ><a href = "login" > Inloggen</a ></li >';

        } else {
            echo ' <li class="active" ><a href = "login" > Mijn Profiel</a ></li >';
            echo ' <li class="active" ><a href = "logout" > Uitloggen</a ></li >';
        }
        ?>

    </ul>
    <h3 class="text-muted"><a href="index">Home</a></h3>


</div>


