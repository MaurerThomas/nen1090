<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 21-10-2014
 * Time: 15:42
 */

require_once('includes/config.php');

//process login form if submitted
if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $_SESSION["email"] = $email;


    if ($user->login($email, $password)) {

        $query = "SELECT email, user_type, bedrijfsid FROM members WHERE email = :email";
        $stmt = $db->prepare($query);
        $stmt->execute(array(':email' => $_POST['email']));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $bedrijfid = $row['bedrijfsid'];
        echo $bedrijfid;
        switch ($row['user_type']) {
            case 'admin':
                $loc = 'beheer';
                break;
            case 'user':
                $loc = "profiel.php?bedrijfid=$bedrijfid";
                break;
        }

        header('Location: ' . $loc);


    } else {
        $error[] = 'Verkeerde email of wachtwoord of uw account is nog niet geactiveerd.';
    }
}//end if submit

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inloggen</title>
    <!-- Bootstrap -->
    <link href="style/bootstrap.min.css" rel="stylesheet">
    <link href="style/login.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
            <form role="form" method="post" action="" autocomplete="off">
                <h2>Inloggen bij nen1090 bank</h2>

                <p><a href='./'>Terug naar home</a></p>
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
                            echo "<h2 class='bg-success'>Uw account is geactiveerd. U kunt nu inloggen.</h2>";
                            break;
                        case 'reset':
                            echo "<h2 class='bg-success'>Er is een reset link naar u gestuurd.</h2>";
                            break;
                        case 'resetAccount':
                            echo "<h2 class='bg-success'>Wachtwoord is veranderd, U kunt nu inloggen.</h2>";
                            break;
                    }
                }
                ?>
                <div class="form-group">
                    <input type="text" name="email" id="email" class="form-control input-lg" placeholder="Email"
                           value="<?php if (isset($error)) {
                               echo $_POST['email'];
                           } ?>" tabindex="1">
                </div>
                <div class="form-group">
                    <input type="password" name="password" id="password" class="form-control input-lg"
                           placeholder="Wachtwoord" tabindex="3">
                </div>
                <div class="row">
                    <div class="col-xs-9 col-sm-9 col-md-9">
                        <a href='reset'>Wachtwoord vergeten?</a>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-xs-6 col-md-6"><input type="submit" name="submit" value="Login"
                                                          class="btn btn-success btn-block btn-lg" tabindex="5"></div>
                </div>
                <br>

            </form>
            <?php include('includes/footer.php'); ?>
        </div>
    </div>
</div>
<!-- einde container div -->

</body>
</html>