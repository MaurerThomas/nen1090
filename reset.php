<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 7-12-2014
 * Time: 14:21
 */
require_once('includes/config.php');
//if(!$user->is_logged_in()){ header('Location: login.php'); }

if (isset($_POST['submit'])) {
//email validation
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $error[] = 'Please enter a valid email address';
    } else {
        $stmt = $db->prepare('SELECT email FROM members WHERE email = :email');
        $stmt->execute(array(':email' => $_POST['email']));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (empty($row['email'])) {
            $error[] = 'Email provided is not on recognised.';
        }
    }
//if no errors have been created carry on
    if (!isset($error)) {
//create the activasion code
        $token = md5(uniqid(rand(), true));
        try {
            $stmt = $db->prepare("UPDATE members SET resetToken = :token, resetComplete='No' WHERE email = :email");
            $stmt->execute(array(
                ':email' => $row['email'],
                ':token' => $token
            ));
//send email
            $to = $row['email'];
            $subject = "Password Reset";
            $body = "Someone requested that the password be reset. \n\nIf this was a mistake, just ignore this email and nothing will happen.\n\nTo reset your password, visit the following address: " . DIR . "resetPassword.php?key=$token";
            $additionalheaders = "From: <" . SITEEMAIL . ">\r\n";
            $additionalheaders .= "Reply-To: $" . SITEEMAIL . "";
            mail($to, $subject, $body, $additionalheaders);
//redirect to index page
            header('Location: login.php?action=reset');
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
    <title>Reset</title>
    <!-- Bootstrap -->
    <link href="style/bootstrap.min.css" rel="stylesheet">
    <link href="style/jumbotron-narrow.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <?php include('includes/header.php'); ?>

    <div class="row">
        <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
            <form role="form" method="post" action="" autocomplete="off">
                <h2>Reset uw wachtwoord</h2>

                <p><a href='login'>Terug naar home</a></p>
                <hr>
                <?php
                //check for any errors
                if (isset($error)) {
                    foreach ($error as $error) {
                        echo '<p class="bg-danger">' . $error . '</p>';
                    }
                }
                if (isset($_GET['action'])) {
//check the action
                    switch ($_GET['action']) {
                        case 'active':
                            echo "<h2 class='bg-success'>Uw account is nu geactiveerd. U kunt inloggen.</h2>";
                            break;
                        case 'reset':
                            echo "<h2 class='bg-success'>Controleer uw inbox voor een reset link.</h2>";
                            break;
                    }
                }
                ?>
                <div class="form-group">
                    <input type="email" name="email" id="email" class="form-control input-lg" placeholder="Email"
                           value="" tabindex="1">
                </div>
                <input type="submit" name="submit" value="Verstuur email" class="btn btn-success btn-block btn-lg"
                       tabindex="2">
            </form>
            <?php include('includes/footer.php'); ?>
        </div>
    </div>
</div>
</body>
</html>