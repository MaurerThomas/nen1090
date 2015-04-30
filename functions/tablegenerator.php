<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 22-12-2014
 * Time: 20:52
 */


echo '<table class="table table-striped table-bordered table-hover">';
echo '<tr><th>Naam</th><th>Stad</th><th>Provincie</th><th>Executie Klasse</th><th>Profiel</th></tr>';
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

    echo '<tr>';
    echo '<td>' . $row['bedrijfsnaam'] . '</td>';
    echo '<td>' . $row['stad'] . ' </td>';
    echo '<td>' . $row['provincie'] . '</td>';
    echo '<td>' . $row['klasse'] . '</td>';
    echo '<td> <a target="_blank" href = "oprofiel.php?bedrijfid=' . $row['bedrijfsid'] . '">Profiel Pagina</a></td>';

    echo '</tr>';

}
echo '</table>';




// Voor later
/**
 * if ($row['imagelink'] === null){
 * echo '<td>' .'<p></p>'.  '</td>';
 *
 * } else {
 * echo '<td> <img id="result_img" class="img-responsive" src= "'.$row['imagelink'].'" />   </td>';
 *
 * }
 */