<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 7-12-2014
 * Time: 14:37
 */

require_once('includes/config.php');
if (!$user->is_logged_in()) {
    header('Location: login.php');
}

$stmt = $db->prepare('SELECT resetToken, resetComplete FROM members WHERE resetToken = :token');
$stmt->execute(array(':token' => $_GET['key']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
//if no token from db then kill the page
if (empty($row['resetToken'])) {
    $stop = 'Token is ongeldig. Gebruik de link in de verstuude email. ';
} elseif ($row['resetComplete'] == 'Yes') {
    $stop = 'Uw wachtwoord is al veranderd!';
}
//if form has been submitted process it
if (isset($_POST['submit'])) {
//basic validation
    if (strlen($_POST['password']) < 3) {
        $error[] = 'Wachtwoord is te kort.';
    }
    if (strlen($_POST['passwordConfirm']) < 3) {
        $error[] = 'Bevestig wachtwoord is te kort.';
    }
    if ($_POST['password'] != $_POST['passwordConfirm']) {
        $error[] = 'Wachtwoord komen niet overeen.';
    }
//if no errors have been created carry on
    if (!isset($error)) {
//hash the password
        $hashedpassword = $user->password_hash($_POST['password'], PASSWORD_BCRYPT);
        try {
            $stmt = $db->prepare("UPDATE members SET password = :hashedpassword, resetComplete = 'Yes' WHERE resetToken = :token");
            $stmt->execute(array(
                ':hashedpassword' => $hashedpassword,
                ':token' => $row['resetToken']
            ));
//redirect to index page
            header('Location: login.php?action=resetAccount');
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
    <title>Reset wachtwoord</title>
    <!-- Bootstrap -->
    <link href="style/bootstrap.min.css" rel="stylesheet">
    <link href="style/jumbotron-narrow.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <?php include('includes/header.php'); ?>


    <div class="row">
        <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
            <?php if (isset($stop)) {
                echo "<p class='bg-danger'>$stop</p>";
            } else {
                ?>
                <form role="form" method="post" action="" autocomplete="off">
                    <h2>Change Password</h2>
                    <hr>
                    <?php
                    //check for any errors
                    if (isset($error)) {
                        foreach ($error as $error) {
                            echo '<p class="bg-danger">' . $error . '</p>';
                        }
                    }
                    //check the action
                    switch ($_GET['action']) {
                        case 'active':
                            echo "<h2 class='bg-success'>Uw account is geactiveerd. U kunt nu inloggen.</h2>";
                            break;
                        case 'reset':
                            echo "<h2 class='bg-success'>Bekijk uw inbox voor een reset link.</h2>";
                            break;
                    }
                    ?>
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type="password" name="password" id="password" class="form-control input-lg"
                                       placeholder="Wachtwoord" tabindex="1">
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type="password" name="passwordConfirm" id="passwordConfirm"
                                       class="form-control input-lg" placeholder="Bevestig wachtwoord" tabindex="1">
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-xs-6 col-md-6"><input type="submit" name="submit" value="Verander wachtwoord"
                                                              class="btn btn-primary btn-block btn-lg" tabindex="3">
                        </div>
                    </div>
                </form>
            <?php } ?>
        </div>
    </div>
    <?php include('includes/footer.php'); ?>

</div>
<!-- einde container div -->

</body>
</html>