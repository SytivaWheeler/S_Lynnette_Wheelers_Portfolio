<?php
require("IMDB_api_trans.php");
require("watchmode_trans.php");

$genre = "";
$platform = "";

# Retreived from textbox on homepage
if (isset($_POST['genre']) && $_POST['genre'] != "") {
	$genre = "&genres=" . $_POST['genre'];
}
if (isset($_POST['platform']) && $_POST['platform'] != "") {
	$platform = "&source_ids=" . $_POST['platform'];
}

# Retrieve info from api based on genres and platforms
$watchmoderesp = sort_genre_platform($platform, $genre);
$titles = $watchmoderesp['titles'];

/* JSON includes: Titles as titles, page numbers as page, 
number of results as total_results, number of pages as total_pages */

# For each echos html data to home to show all movies listed from api call.
foreach ($titles as $key1 => $value1) {
	/*	 
		Use if other api (IMDB API) calls run out and pictures/ plot details stop appearing for movies
        To switch from IMDB to Watchmode:
			Replace $imdbresp = get_details($titles[$key1]['imdb_id']); with $imdbresp = wtch_get_details($titles[$key1]['imdb_id']);  
			replace $imdbresp['image'] with $imdbresp['poster']
		To switch the other direction, do the opposite.
	*/
	$imdbresp = wtch_get_details($titles[$key1]['imdb_id']);

	echo '<div class = "card" style="width: 18rem;">
		<img class="card-img-top" src= "' . $imdbresp['poster'] . '" alt = "img">  
		<div class="card-body">
        	<h1 class = "titles"> ' . $titles[$key1]['title'] . '</h1>
			<form action="../include_files/insert_list.php" method="POST">
			<button type="submit" class= "btn btn-primary" name="favbtn" value="' . $titles[$key1]['imdb_id'] . '"> Favorite</button>
            <button type="submit" class= "btn btn-primary" name="watchbtn" value="' . $titles[$key1]['imdb_id'] . '"> Watch List</button>
			</form>
		</div>
		</div>';
}

?>