<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 21-10-2014
 * Time: 15:42
 */

require_once('includes/config.php');
$email = $_SESSION["email"];
if (!$user->is_logged_in()) {
    header('Location: login');
}

if ($user->getRoleFromDb($email) == 'user') {
    header('Location: login');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Beheer</title>
    <!-- Bootstrap -->
    <link href="style/bootstrap.min.css" rel="stylesheet">
    <link href="style/jumbotron-narrow.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <?php include('includes/header.php'); ?>
    <div class="row">
        <h3>Bedrijven Beheren</h3>
    </div>
    <div class="row">

        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>Bedrijfsnaam</th>
                <th>Klasse</th>
                <th>Certificaatnummer</th>
                <th>Actie</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $sql = ('SELECT * FROM bedrijven WHERE goedgekeurd = "Nee" ORDER BY bedrijfsid DESC');
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $num = $stmt->rowCount();
            if ($num > 0) {

                //retrieve our table contents
                //fetch() is faster than fetchAll()
                //http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    //creating new table row per record
                    echo "<tr>";
                    echo '<td>' . $row['bedrijfsnaam'] . '</td>';
                    echo '<td>' . $row['klasse'] . '</td>';
                    echo '<td>' . $row['certificaatnummer'] . '</td>';

                    echo '<td width=250>';

                    echo '<a class="btn btn-success" href="goedkeuren.php?id=' . $row['bedrijfsid'] . '">Accept</a>';
                    echo ' ';
                    echo '<a class="btn btn-danger" href="weigeren.php?id=' . $row['bedrijfsid'] . '">Verwijder</a>';
                    echo '</td>';
                    echo '</tr>';
                }
            } //if no records found
            else {
                echo "Geen bedrijven meer die goedgekeurd moeten worden.";
            }
            ?>

            </tbody>
        </table>
    </div>

    <?php include('includes/footer.php'); ?>
</div>
<!-- einde container div -->

</body>
</html>