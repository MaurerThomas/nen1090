<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 21-10-2014
 * Time: 17:28
 */

session_start();
include_once('includes/db_connect.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Resultaat</title>
    <!-- Bootstrap -->
    <link href="style/bootstrap.min.css" rel="stylesheet">
    <link href="style/jumbotron-narrow.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <?php include('includes/header.php'); ?>

    <?php
    if (array_key_exists('check_submit', $_POST)) {

        // Alleen naam ingevoerd
        if (!empty($_POST['Name'])) {
            $query = "SELECT bedrijfsnaam, klasse, provincie, stad,bedrijfsid FROM bedrijven WHERE bedrijfsnaam = ? AND goedgekeurd= 'Ja'";
            $stmt = $con->prepare($query);
            $stmt->bindParam(1, $_POST['Name'], PDO::PARAM_STR);
            $stmt->execute();
            $num = $stmt->rowCount();
            require_once('functions/tablegenerator.php');


            // Executie en naam ingevoerd
        } // Provincie en executie ingevoerd
        elseif (!empty($_POST['Provincie']) && $_POST['Executie']) {

            $query = "SELECT bedrijfsnaam, klasse, provincie,stad,bedrijfsid FROM bedrijven WHERE klasse >= ?  AND provincie = ? AND goedgekeurd= 'Ja' ORDER BY klasse  ";
            $stmt = $con->prepare($query);
            $stmt->bindParam(1, $_POST['Executie']);
            $stmt->bindParam(2, $_POST['Provincie']);
            $stmt->execute();
            $num = $stmt->rowCount();
            require_once('functions/tablegenerator.php');
        } elseif (!empty ($_POST['Executie']) && $_POST['Name']) {
            $selectie = $_POST['Executie'];
            $query = "SELECT bedrijfsnaam, klasse, provincie,stad,bedrijfsid FROM bedrijven WHERE klasse >= ?  AND bedrijfsnaam = ? AND goedgekeurd= 'Ja' ";
            $stmt = $con->prepare($query);
            $stmt->bindParam(1, $_POST['Executie'], PDO::PARAM_STR);
            $stmt->bindParam(2, $_POST['Name'], PDO::PARAM_STR);
            $stmt->execute();
            $num = $stmt->rowCount();
            require_once('functions/tablegenerator.php');

            // Alleen executie ingevoerd
        } elseif (!empty($_POST['Executie']) && empty($_POST['Provincie'])) {
            $selectie = $_POST['Executie'];

            $query = " SELECT bedrijven.bedrijfsnaam, bedrijven.klasse, bedrijven.provincie, bedrijfsid,stad FROM bedrijven WHERE klasse >= ? AND goedgekeurd= 'Ja'  ORDER BY klasse ";
            $stmt = $con->prepare($query);
            $stmt->bindParam(1, $_POST['Executie']);
            $stmt->execute();
            $num = $stmt->rowCount();

            require_once('functions/tablegenerator.php');

            // Alleen Provincie ingevoerd
        } elseif (!empty($_POST['Provincie'])) {

            $query = "SELECT bedrijven.bedrijfsnaam, bedrijven.klasse, bedrijven.provincie,stad,bedrijfsid FROM bedrijven WHERE provincie = ? AND goedgekeurd= 'Ja' ORDER BY klasse ";
            $stmt = $con->prepare($query);
            $stmt->bindParam(1, $_POST['Provincie']);
            $stmt->execute();
            $num = $stmt->rowCount();
            require_once('functions/tablegenerator.php');

        } elseif (!empty($_POST['Stad'])) {

            $query = "SELECT bedrijfsnaam, klasse, provincie,stad,bedrijfsid FROM bedrijven WHERE stad = ? AND goedgekeurd= 'Ja' ORDER BY klasse ";
            $stmt = $con->prepare($query);
            $stmt->bindParam(1, $_POST['Stad']);
            $stmt->execute();
            $num = $stmt->rowCount();
            require_once('functions/tablegenerator.php');

        } elseif (!empty($_POST['Adres'])) {

            $query = "SELECT bedrijfsnaam, klasse, provincie,stad,bedrijfsid,adres FROM bedrijven WHERE adres = ? AND goedgekeurd= 'Ja' ORDER BY klasse ";
            $stmt = $con->prepare($query);
            $stmt->bindParam(1, $_POST['Adres']);
            $stmt->execute();
            $num = $stmt->rowCount();
            require_once('functions/tablegenerator.php');

        }
    }

    ?>
    <p><a class="btn btn-sm btn-success" href="zoeken" role="button">Terug</a></p>

    <?php include('includes/footer.php'); ?>

</div>
<!-- einde container div -->

</body>
</html>