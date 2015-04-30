<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 21-10-2014
 * Time: 15:42
 */

require_once('includes/config.php');

if (!$user->is_logged_in()) {
    header('Location: login');
}
$email = $_SESSION['email'];
$id = $_GET['bedrijfid'];
if ($user->get_id_from_email($email) === $id) {

    try {

        $stmt = $db->prepare('SELECT * FROM bedrijven WHERE bedrijfsid = :id');
        $stmt->execute(array(

            ':id' => $_GET['bedrijfid']

        ));

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $bedrijfsnaam = $row['bedrijfsnaam'];
            $bedrijfsOmschrijving = $row['omschrijving'];
            $klasse = $row['klasse'];
            $logo = $row['imagelink'];
            $certificaatnummer = $row['certificaatnummer'];
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

} else {
    header("Location: verboden");
    exit();
}


if (isset($_POST['submit'])) {
    /**
     *
     * $target_dir = "./images/";
     * if(isset($_FILES["fileToUpload"]["name"])){
     * $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
     * $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);}
     * $uploadOk = 1;
     *
     * // Check if image file is a actual image or fake image
     * if (isset($_FILES["fileToUpload"]["tmp_name"])) {
     *
     * list($width, $height, $check) = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
     *
     * if ($width > 200 && $height > 200) {
     * echo "Afbeelding is te groot in breedte en hoogte";
     * $error[] = "Afbeelding is te groot in breedte en hoogte";
     * }
     *
     * if ($check !== false) {
     * echo "File is an image - " . $check["mime"] . ".";
     * $uploadOk = 1;
     * } else {
     * echo "File is not an image.";
     * $error [] = 'Uploaded bestand is geen afbeelding';
     * }
     *
     * // Check file size
     * if ($_FILES["fileToUpload"]["size"] > 500000) {
     * $uploadOk = 0;
     * $error [] = 'De afbeelding is te groot';
     * }
     *
     * // Allow certain file formats
     * if (isset($imageFileType) != "jpg" && isset($imageFileType) != "png" && isset($imageFileType) != "jpeg"
     * && isset($imageFileType) != "gif"
     * ) {
     * $uploadOk = 0;
     * $error[] = 'Alleen JPG, JPEG, PNG & GIF afbeelding zijn toegestaan';
     * }
     * }
     */


    if (!isset($error)) {

        /**
         * if ($uploadOk == 0) {
         * echo "Sorry, your file was not uploaded.";
         * // if everything is ok, try to upload file
         * } else {
         * if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
         * echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
         * }
         * }
         */
        try {

            $stmt = $db->prepare('UPDATE bedrijven SET bedrijfsnaam = :bedrijfsnaam, certificaatnummer = :certificaatnummer, klasse = :executieklasse, omschrijving = :omschrijving,
             werkzaam = :werkzaam, adres = :adres, telefoon = :telefoon, email = :email, website = :website WHERE bedrijfsid = :id ');
            $stmt->execute(array(
                'bedrijfsnaam' => $_POST['bedrijfsnaam'],
                'certificaatnummer' => $_POST['certificaatnummer'],
                'executieklasse' => $_POST['klasse'],
                'omschrijving' => $_POST['omschrijving'],
                'werkzaam' => implode(',', $_POST['werkzaam']),
                'adres' => $_POST['adres'],
                'telefoon' => $_POST['telefoon'],
                'email' => $_POST['e-mail'],
                'website' => $_POST['website'],
                //'imagelink' => $target_file,
                ':id' => $_GET['bedrijfid']


            ));


            //header("refresh: 0;");
            //exit();

//else catch the exception and show the error.
        } catch (PDOException $e) {
            $error[] = $e->getMessage();
            print $error[0];
        }

    }

    /**
     * foreach ($_POST as $field_name => $val) {
     * //clean post values
     * $field_userid = strip_tags(trim($field_name));
     * $val = strip_tags(trim($val));
     *
     * //from the fieldname:user_id we need to get user_id
     * $split_data = explode(':', $field_userid);
     * $user_id = $split_data[1];
     * $field_name = $split_data[0];
     * echo $val;
     * if (!empty($user_id) && !empty($field_name) && !empty($val)) {
     * //update the values
     *
     * $stmt = $db->prepare("UPDATE bedrijven SET $field_name = '$val' WHERE bedrijfsid = $user_id");
     * $stmt->execute();
     * echo "Updated";
     * } else {
     * echo "Invalid Requests 1";
     * }
     * }
     */
} ?>

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
    <script type="text/javascript" src="js/jquery-1.11.2.min.js"></script>

</head>
<body>

<div class="container">
    <?php include('includes/header.php'); ?>

    <div class="row">
        <div class="col-xs-12 col-md-9 col-md-6 col-sm-offset-2 col-md-offset-3">
            <h2>Profiel aanpassen</h2>

            <p>Verander hier uw profiel.</p>

        </div>
    </div>

    <form role="form" method="post" action="" class="form-horizontal">
        <div class="form-group">
            <div id="status"></div>
            <label for="bedrijfsnaam:<?php echo $_GET["bedrijfid"] ?>"> Bedrijfsnaam</label>
            <input id="bedrijfsnaam:<?php echo $_GET["bedrijfid"] ?>" contenteditable="true" class="form-control"
                   name="bedrijfsnaam" value="<?php if (isset($bedrijfsnaam)) {
                echo $bedrijfsnaam;
            } else echo "Geen bedrijfsnaam gevonden" ?>"/>
        </div>


        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                    <label for="certificaatnummer:<?php echo $_GET["bedrijfid"] ?>"> Certificaatnummer</label>
                    <input id="certificaatnummer:<?php echo $_GET["bedrijfid"] ?>" contenteditable="true"
                           class="form-control"
                           name="certificaatnummer" value="<?php if (isset($certificaatnummer)) {
                        echo $certificaatnummer;
                    } else echo "Geen certificaatnummer gevonden" ?>"/>
                    <?php  /**if (isset($logo) == null): ?>
                     * Uw bedrijf heeft nog geen logo.<br>
                     * <label for="fileToUpload">Upload een logo</label>
                     * <input type="file" name="fileToUpload" id="fileToUpload" accept="image/* ">
                     *
                     * <input type="submit" name="submit" value="Opslaan">
                     *
                     * <?php else: ?>
                     * <img id="result_img" src=" <?php if (isset($logo)) { echo $logo; } ?> ">
                     * <?php endif; */
                    ?>

                </div>
            </div>


            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                    <div id="status"></div>
                    <label for="klasse:<?php echo $_GET["bedrijfid"] ?>">Executieklasse </label>
                    <input id="klasse:<?php echo $_GET["bedrijfid"] ?>" contenteditable="true" class="form-control"
                           name="klasse" value="<?php if (isset($klasse)) {
                        echo $klasse;
                    } else echo "Geen klasse gevonden" ?>"/>
                </div>
            </div>
        </div>


        <div class="form-group">
            <div id="status"></div>
            <label for="omschrijving:<?php echo $_GET["bedrijfid"] ?>"> Bedrijfsomschrijving</label>
            <textarea id="omschrijving:<?php echo $_GET["bedrijfid"] ?>" contenteditable="true" class="form-control"
                      name="omschrijving" rows="10" cols="35">
                <?php if (isset($bedrijfsOmschrijving)) {
                    echo $bedrijfsOmschrijving;
                } else echo "Dit bedrijf heeft nog geen omschrijving" ?>
            </textarea>
        </div>

        <div class="form-group">

            <label for="werkzaamheden">Werkzaam in:</label>

            <div class="checkbox" id="werkzaam">
                <label><input type="checkbox" value="1" name="werkzaam[]"  <?php if (isset($gekozenWerkzaamheden)) {
                        if (in_array(1, $gekozenWerkzaamheden)) {
                            echo "checked='checked'";
                        }
                    } ?>> Utiliteits bouw</label>
                <label><input type="checkbox" value="2" name="werkzaam[]" <?php if (isset($gekozenWerkzaamheden)) {
                        if (in_array(2, $gekozenWerkzaamheden)) {
                            echo "checked='checked'";
                        }
                    } ?>> petrochemie</label>
                <label><input type="checkbox" value="3" name="werkzaam[]" <?php if (isset($gekozenWerkzaamheden)) {
                        if (in_array(3, $gekozenWerkzaamheden)) {
                            echo "checked='checked'";
                        }
                    } ?>> Offshore</label>
                <label><input type="checkbox" value="4" name="werkzaam[]" <?php if (isset($gekozenWerkzaamheden)) {
                        if (in_array(4, $gekozenWerkzaamheden)) {
                            echo "checked='checked'";
                        }
                    } ?>> Machine bouw</label>
                <label><input type="checkbox" value="5" name="werkzaam[]" <?php if (isset($gekozenWerkzaamheden)) {
                        if (in_array(5, $gekozenWerkzaamheden)) {
                            echo "checked='checked'";
                        }
                    } ?>> Infra</label>
            </div>
        </div>

        <div class="form-group" id="contactgegevens">
            <label for="contactgegevens">Contactgegevens:</label><br>
            <label for="adres">Adres</label><br>
            <input id="adres" name="adres" value="<?php if (isset($adres)) {
                echo $adres;
            } else echo "Adres" ?>"/><br>
            <label for="telefoon">Telefoon</label><br>
            <input placeholder="Telefoon" id="telefoon" name="telefoon" value="<?php if (isset($telefoon)) {
                echo $telefoon;
            } else echo "Telefoon" ?>"><br>
            <label for="e-mail">E-mail</label><br>
            <input placeholder="E-mail" id="e-mail" name="e-mail" value="<?php if (isset($email)) {
                echo $email;
            } else echo "E-mail" ?>"><br>
            <label for="website">Website</label><br>
            <input placeholder="Website" id="website" name="website" value="<?php if (isset($website)) {
                echo $website;
            } else echo "Website" ?>"><br>


        </div>

        <div class="form-group">
            <input type="submit" name="submit" value="Opslaan" class="btn btn-success btn-block btn-lg" tabindex="8">
        </div>

    </form>

</div>
<!-- einde container div -->
<?php include('includes/footer.php'); ?>
</body>
</html>
