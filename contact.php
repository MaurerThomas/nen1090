<?php
session_start()
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Contact</title>
    <!-- Bootstrap -->
    <link href="style/bootstrap.min.css" rel="stylesheet">
    <link href="style/jumbotron-narrow.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <?php include('includes/header.php'); ?>

    <h1>Contactformulier</h1>

    <form method="POST" name="contactform" action="contact-form-handler">
        <p>

        <div class="form-group">
            <label for='name'>Uw Naam:</label> <br>
            <input type="text" name="name" class="form-control input-lg">
        </div>
        </p>
        <p>
            <label for='email'>Email Adres:</label> <br>
            <input type="text" name="email" class="form-control input-lg"> <br>
        </p>

        <p>
            <label for='message'>Bericht:</label> <br>
            <textarea name="message" class="form-control"></textarea>
        </p>
        <input type="submit" value="Verstuur formulier" class="btn btn-success btn-block btn-lg"><br>
    </form>



    <?php include('includes/footer.php'); ?>


</div>
<!-- einde container div -->

</body>
</html>