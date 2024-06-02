<?php

require("IMDB_api_con.php");

//Makes an api call to IMDB api on RapidAPI using the IMDB id for a movie.
//Returns same info as title/get-plots. More info:https://rapidapi.com/apidojo/api/imdb8/

function get_details($imdb_id){
    $json_decoded = json_decode(imdb_api_call($imdb_id), true);
    return $json_decoded;
}

?>