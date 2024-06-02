
<?php
require("DBConn.php");
require("watchmode_api_con.php");

function pop_homepage($genres){
	$url = "https://watchmode.p.rapidapi.com/list-titles/?types=movie&regions=US&page=1&limit=65&genres=" . $genres . "&sort_by=relevance_desc";
	return json_decode(wtchmd_api_call($url), true);
}

function wtch_get_details($imdb_id){
	$url = "https://watchmode.p.rapidapi.com/title/" . $imdb_id . "/details/?language=ES";
	return json_decode(wtchmd_api_call($url), true);
}

function sort_genre_platform($platform, $genre){
	$url = "https://watchmode.p.rapidapi.com/list-titles/?types=movie&regions=US" . $platform . "&page=1&limit=65" . $genre . "&sort_by=relevance_desc";
	return json_decode(wtchmd_api_call($url), true);
}

function specific_platforms($imdb_id){
	$url = "https://watchmode.p.rapidapi.com/title/" . $imdb_id . "/" . "sources/";
	return json_decode(wtchmd_api_call($url), true);
}

?>