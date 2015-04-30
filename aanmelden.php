<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 21-10-2014
 * Time: 15:42
 */

require_once('includes/config.php');

if (isset($_POST['submit'])) {
    /**
     * $target_dir = "./images/";
     * if(isset($_FILES["fileToUpload"]["name"])){
     * $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
     * $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);}
     * $uploadOk = 1;
     */


//very basic validation
    if (strlen($_POST['password']) < 3) {
        $error[] = 'Wachtwoord is te kort. ';

    }
    if (strlen($_POST['passwordConfirm']) < 3) {
        $error[] = 'Bevestig wachtwoord is te kort.';
    }
    if ($_POST['password'] != $_POST['passwordConfirm']) {
        $error[] = 'Wachtwoord komen niet overeen.';

    }
//email validation
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $error[] = 'Vul alstublieft een geldig e-mailadres in';
    } else {
        $stmt = $db->prepare('SELECT email FROM members WHERE email = :email');
        $stmt->execute(array(':email' => $_POST['email']));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!empty($row['email'])) {
            $error[] = 'E-mailadres is al in gebruik.';
        }
    }
    /**
     * // Check if image file is a actual image or fake image
     * if(isset($_FILES["fileToUpload"]["tmp_name"])){
     *
     * list($width,$height,$check) = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
     *
     * if($width > 200 && $height > 200){
     * echo "Afbeelding is te groot in breedte en hoogte";
     * $error[] = "Afbeelding is te groot in breedte en hoogte";
     * }
     *
     * if($check !== false) {
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
     * if(isset($imageFileType) != "jpg" && isset($imageFileType) != "png" && isset($imageFileType) != "jpeg"
     * && isset($imageFileType) != "gif" ) {
     * $uploadOk = 0;
     * $error[] = 'Alleen JPG, JPEG, PNG & GIF afbeelding zijn toegestaan';
     * }
     *
     * }
     */
//if no errors have been created carry on
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
//hash the password
        $hashedpassword = $user->password_hash($_POST['password'], PASSWORD_BCRYPT);
//create the activasion code
        $activasion = md5(uniqid(rand(), true));
        try {

            // insert bedrijfsgegevens
            $stmt = $db->prepare('INSERT INTO bedrijven (bedrijfsnaam,klasse,certificaatnummer,provincie,stad) VALUES (:naam , :klasse, :certificaatnummer, :provincie, :stad)');
            $stmt->execute(array(
                ':naam' => $_POST['bedrijfsnaam'],
                ':klasse' => $_POST['Klasse'],
                ':certificaatnummer' => $_POST['CertificaatNummer'],
                ':provincie' => $_POST['Provincie'],
                ':stad' => $_POST['stad']
            ));
            $bedrijfid = $db->lastInsertId('id');
//insert into database with a prepared statement
            $stmt = $db->prepare('INSERT INTO members (password,email,active,bedrijfsid) VALUES (:password, :email, :active, :bedrijfsid)');
            $stmt->execute(array(
                ':password' => $hashedpassword,
                ':email' => $_POST['email'],
                ':active' => $activasion,
                ':bedrijfsid' => $bedrijfid

            ));
            $id = $db->lastInsertId('memberID');
//send email

            $to = $_POST['email'];
            $subject = "Registration Confirmation";
            $body = "Thank you for registering at demo site.\n\n To activate your account, please click on this link:\n\n " . DIR . "activate.php?x=$id&y=$activasion\n\n Regards Site Admin \n\n";
            $additionalheaders = "From: <" . SITEEMAIL . ">\r\n";
            $additionalheaders .= "Reply-To: $" . SITEEMAIL . "";
            mail($to, $subject, $body, $additionalheaders);


//redirect to index page

            header("Location: aanmeldensucces");
            exit;
//else catch the exception and show the error.
        } catch (PDOException $e) {
            $error[] = $e->getMessage();

        }

    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aanmelden</title>
    <!-- Bootstrap -->
    <link href="style/bootstrap.min.css" rel="stylesheet">
    <link href="style/jumbotron-narrow.css" rel="stylesheet">
    <link href="style/fileinput.min.css" media="all" rel="stylesheet" type="text/css">
    <script src="js/fileinput.min.js" type="text/javascript"></script>
    <script src="js/jquery-1.11.2.min.js" type="text/javascript"></script>


</head>
<body>

<div class="container">
    <?php include('includes/header.php'); ?>

    <form role="form" method="post" action="" autocomplete="off" enctype="multipart/form-data">
        <input type="hidden" name="topic" id="topic">

        <?php if (isset($error)) {
            foreach ($error as $fout) {
                echo '<p class="bg-danger">' . $fout . '</p>';
            }
        } ?>
        <div class="form-group">
            <label for="bedrijfsnaam">Bedrijfsnaam*</label>
            <input type="text" name="bedrijfsnaam" id="bedrijfsnaam" class="form-control input-lg"
                   placeholder="Bedrijfsnaam" tabindex="1" required="true">
        </div>
        <!--
        <div class="form-group">
            <label for="fileToUpload">Upload een logo</label>
            <input type="file" name="fileToUpload" id="fileToUpload" accept="image/* ">

        </div>
        -->
        <div class="form-group">
            <label for="certificaatnummer">Certificaatnummer</label>
            <input type="text" name="CertificaatNummer" id="certificaatnummer" class="form-control input-lg"
                   placeholder="Certificaatnummer" tabindex="2">
        </div>

        <div class="form-group">
            <label for="Klasse">Executie Klasse*</label>
            <select name="Klasse" class="form-control" tabindex="3" required="required" id="Klasse">
                <option value="" disabled selected>Executie Klasse</option>
                <option value="1">Executie Klasse 1</option>
                <option value="2">Executie Klasse 2</option>
                <option value="3">Executie Klasse 3</option>
                <option value="4">Executie Klasse 4</option>
            </select>
        </div>

        <div class="form-group">
            <label for="stad">Stad*</label>
            <input type="text" name="stad" id="stad" class="form-control input-lg"
                   placeholder="Stad" tabindex="" required="true">
        </div>

        <div class="form-group">
            <label for="Provincie">Provincie*</label>
            <select name="Provincie" class="form-control" tabindex="4" required="required" id="Provincie">
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
            <label for="email">Email*</label>
            <input type="email" name="email" id="email" class="form-control input-lg" placeholder="Email Address"
                   value="<?php if (isset($error)) {
                       echo $_POST['email'];
                   } ?> " tabindex="5" required="true">
        </div>
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                    <label for="password">Wachtwoord*</label>
                    <input type="password" name="password" id="password" class="form-control input-lg"
                           placeholder="Password" tabindex="6" required="true">

                </div>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                    <label for="passwordConfirm">Bevestig wachtwoord*</label>
                    <input type="password" name="passwordConfirm" id="passwordConfirm" class="form-control input-lg"
                           placeholder="Confirm Password" tabindex="7" required="true">
                </div>
            </div>
        </div>

        <div class="form-group">
            * = verplichte veld
        </div>


        <div class="form-group">
            <input type="submit" name="submit" value="Register" class="btn btn-success btn-block btn-lg" tabindex="8">
        </div>


    </form>
    <?php include('includes/footer.php'); ?>
</div>
<!-- einde container div -->

</body>
</html>