<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 21-10-2014
 * Time: 15:42
 */

include_once('includes/config.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Uitgebreid Zoeken</title>
    <!-- Bootstrap -->
    <link href="style/bootstrap.min.css" rel="stylesheet">
    <link href="style/jumbotron-narrow.css" rel="stylesheet">
    <script type="text/JavaScript" src="js/bootstrap.min.js"></script>

</head>
<body>

<div class="container">
    <?php include('includes/header.php'); ?>

    <form name="form" action="resultaat.php" method="POST">
        <input type="hidden" name="check_submit" value="1"/>

        <div class="form-group">
            <label for="bedrijfsnaam">Bedrijfsnaam</label>
            <input type="text" name="Name" id="bedrijfsnaam" class="form-control input-lg"
                   placeholder="Bedrijfsnaam" tabindex="1">
        </div>

        <div class="form-group">
            <label for="executie">Executie klasse</label>
            <select name="Executie" class="form-control" tabindex="2" id="executie">
                <option value="" disabled selected>Executie Klasse</option>
                <option value="1">Executie Klasse 1</option>
                <option value="2">Executie Klasse 2</option>
                <option value="3">Executie Klasse 3</option>
                <option value="4">Executie Klasse 4</option>
            </select>
        </div>

        <div class="form-group">
            <label for="provincie">Provincie</label>
            <select name="Provincie" class="form-control" tabindex="4" id="provincie">
                <option value="" disabled selected>Provincie</option>
                <option value="Drenthe">Drenthe</option>
                <option value="Flevoland">Flevoland</option>
                <option value="Friesland">Friesland</option>
                <option value="Gelderland">Gelderland</option>
                <option value="Groningen">Groningen</option>
                <option value="Limburg">Limburg</option>
                <option value="Noord-Brabant">Noord-Brabant</option>
                <option value="Noord-Holland">Noord-Holland</option>
                <option value="Overijssel">Overijssel</option>
                <option value="Utrecht">Utrecht</option>
                <option value="Zeeland">Zeeland</option>
                <option value="Zuid-Holland">Zuid-Holland</option>
            </select>
        </div>

        <div class="form-group">
            <label for="stad">Stad</label>
            <input type="text" name="Stad" id="Stad" class="form-control input-lg"
                   placeholder="Stad" tabindex="1">
        </div>

        <div class="form-group">
            <label for="adres">Adres</label>
            <input type="text" name="Adres" id="adres" class="form-control input-lg"
                   placeholder="Adres" tabindex="1">
        </div>


        <button class="btn btn-success" type="submit">Zoeken</button>

    </form>

    <?php include('includes/footer.php'); ?>

</div>
<!-- einde container div -->

</body>
</html>