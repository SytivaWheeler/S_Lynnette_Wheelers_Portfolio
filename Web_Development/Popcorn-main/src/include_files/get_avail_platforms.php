<?php
require("watchmode_trans.php");

$imdb_id = $_POST['imdb_ID'];

$json = specific_platforms($imdb_id);
foreach ($json as $key => $value){
    echo '<div class="movlink">
    <a href="'.$value['web_url'] .'">' . $value['name'] . '; format: '. $value['format'].'</a>
    </div>';
}
?>