<?php
session_start();
$errors = '';
$myemail = 'info@nen1090bank.nl';
if (empty($_POST['name']) ||
    empty($_POST['email']) ||
    empty($_POST['message'])
) {
    $errors .= "\n Alle velden zijn verplicht";
}

$name = $_POST['name'];
$email_address = $_POST['email'];
$message = $_POST['message'];

if (!preg_match(
    "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i",
    $email_address)
) {
    $errors .= "\n Email adres is niet geldig";
}

if (empty($errors)) {
    $to = $myemail;
    $email_subject = "Contact formulier: $name";
    $email_body = "Nieuw bericht. " .
        " Dit zijn de details:\n Name: $name \n Email: $email_address \n Message \n $message";

    $headers = "From: $myemail\n";
    $headers .= "Reply-To: $email_address";

    mail($to, $email_subject, $email_body, $headers);
    //redirect to the 'thank you' page
    header('Location: contactformsucces');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fout</title>
    <!-- Bootstrap -->
    <link href="style/bootstrap.min.css" rel="stylesheet">
    <link href="style/jumbotron-narrow.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <?php include('includes/header.php'); ?>

    <?php
    echo nl2br($errors);
    ?>

    <?php include('includes/footer.php'); ?>


</div>
<!-- einde container div -->

</body>
</html>

