<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 21-10-2014
 * Time: 15:42
 */

require_once('includes/config.php');

try {

    $stmt = $db->prepare('SELECT * FROM bedrijven WHERE bedrijfsid = :id');
    $stmt->execute(array(

        ':id' => $_GET['bedrijfid']

    ));
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        $bedrijfsnaam = $row['bedrijfsnaam'];
        $bedrijfsOmschrijving = $row['omschrijving'];
        $klasse = $row['klasse'];
        $checkLogo = $row['imagelink'];
        $certificaatnummer = $row['certificaatnummer'];
        if ($checkLogo === NULL) {
            $logo = "Dit bedrijf heeft geen logo";
        } else {
            $logo = $row['imagelink'];
        }
        $adres = $row['adres'];
        $telefoon = $row['telefoon'];
        $email = $row['email'];
        $website = $row['website'];
        $werkzaam = $row['werkzaam'];
        $gekozenWerkzaamheden = explode(',', $werkzaam);
    }

} catch (PDOException $e) {

    $error[] = $e->getMessage();
    print $error[0];

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profiel</title>
    <!-- Bootstrap -->
    <link href="style/bootstrap.min.css" rel="stylesheet">
    <link href="style/jumbotron-narrow.css" rel="stylesheet">


</head>
<body>

<div class="container">
    <?php include('includes/header.php'); ?>

    <div class="row">
        <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
            <h2><?php if (isset($bedrijfsnaam)) {
                    echo $bedrijfsnaam;
                } else echo "Geen bedrijfsnaam gevonden" ?></h2>
        </div>
    </div>

    <form role="form" method="post" action="" class="form-horizontal">
        <div class="form-group">

            <label> Bedrijfsnaam</label><br>
            <?php if (isset($bedrijfsnaam)) {
                echo $bedrijfsnaam;
            } else echo "Geen bedrijfsnaam gevonden" ?>
        </div>

        <div class="row">
            <!--
            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                <label for="result_img">Logo</label><br>
                <img id="result_img" src="<?php /**if(isset($logo)) {echo $logo;} */ ?>" />
                </div>
            </div>
            -->
            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                    <label for="certificaatnummer:<?php echo $_GET["bedrijfid"] ?>"> Certificaatnummer</label><br>
                    <?php if (isset($certificaatnummer)) {
                        echo $certificaatnummer;
                    } else echo "Geen certificaatnummer gevonden" ?>
                </div>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                    <label for="klasse:<?php echo $_GET["bedrijfid"] ?>">Executieklasse </label><br>
                    <?php if (isset($klasse)) {
                        echo $klasse;
                    } else echo "Geen klasse gevonden" ?>
                </div>
            </div>
        </div>


        <div class="form-group">
            <div id="status"></div>
            <label for="omschrijving:<?php echo $_GET["bedrijfid"] ?>"> Bedrijfsomschrijving</label>
            <textarea readonly id="omschrijving" class="form-control" name="naam" rows="10" cols="35">
                <?php if (isset($bedrijfsOmschrijving)) {
                    echo $bedrijfsOmschrijving;
                } else echo "Dit bedrijf heeft nog geen omschrijving" ?>
            </textarea>
        </div>

        <div class="form-group">

            <label for="werkzaamheden">Werkzaam in:</label>

            <div class="checkbox" id="werkzaamheden">
                <label><input type="checkbox" disabled="disabled" value="1"
                              name="werkzaam"  <?php if (isset($gekozenWerkzaamheden)) {
                        if (in_array(1, $gekozenWerkzaamheden)) {
                            echo "checked='checked'";
                        }
                    } ?>> Utiliteits bouw</label>
                <label><input type="checkbox" disabled="disabled" value="2"
                              name="werkzaam"  <?php if (isset($gekozenWerkzaamheden)) {
                        if (in_array(2, $gekozenWerkzaamheden)) {
                            echo "checked='checked'";
                        }
                    } ?>> petrochemie</label>
                <label><input type="checkbox" disabled="disabled" value="3"
                              name="werkzaam"  <?php if (isset($gekozenWerkzaamheden)) {
                        if (in_array(3, $gekozenWerkzaamheden)) {
                            echo "checked='checked'";
                        }
                    } ?>> Offshore</label>
                <label><input type="checkbox" disabled="disabled" value="4"
                              name="werkzaam"  <?php if (isset($gekozenWerkzaamheden)) {
                        if (in_array(4, $gekozenWerkzaamheden)) {
                            echo "checked='checked'";
                        }
                    } ?>> Machine bouw</label>
                <label><input type="checkbox" disabled="disabled" value="5"
                              name="werkzaam"  <?php if (isset($gekozenWerkzaamheden)) {
                        if (in_array(5, $gekozenWerkzaamheden)) {
                            echo "checked='checked'";
                        }
                    } ?>> Infra</label>
            </div>
        </div>

        <div class="form-group" id="contactgegevens">
            <label for="contactgegevens">Contactgegevens:</label><br>
            <address>

                <label for="adres">Adres</label><br>
                <?php if (isset($adres)) {
                    echo $adres;
                } else echo "Geen Adres gevonden" ?><br>
                <label for="telefoon">Telefoon</label><br>
                <?php if (isset($telefoon)) {
                    echo $telefoon;
                } else echo "Geen Telefoonnummer gevonden" ?><br>
                <label for="e-mail">E-mail</label><br>
                <?php if (isset($email)) {
                    echo $email;
                } else echo "Geen E-mail gevonden" ?><br>
                <label for="website">Website</label><br>
                <?php if (isset($website)) {
                    echo $website;
                } else echo "Geen Website gevonden" ?><br>
            </address>
        </div>

    </form>

    <?php include('includes/footer.php'); ?>

</div>
<!-- einde container div -->

</body>
</html>