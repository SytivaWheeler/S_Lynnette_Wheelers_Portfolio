
<?php

require "../include_files/IMDB_api_trans.php";

$curl = curl_init();

$genre = "";
$platform = "";

//retreived from textbox on API_test
if (isset($_POST['genre']) && isset($_POST['platform'])) {
	$genre = "&genres=". $_POST['genre'];
	$platform = "&source_ids=" . $_POST['platform'];
}

$url = "https://watchmode.p.rapidapi.com/list-titles/?types=movie&regions=US". $platform. "&page=1&limit=15" . $genre . "&sort_by=relevance_desc"; 

curl_setopt_array($curl, [
	CURLOPT_URL => $url,
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
	CURLOPT_HTTPHEADER => [
		"X-RapidAPI-Host: watchmode.p.rapidapi.com",
		"X-RapidAPI-Key: 431c61df0cmsh8311e336d260c4fp11a6b7jsn809f288bb122"
	],
]);

/* JSON includes: Titles as titles, page numbers as page, 
number of results as total_results, number of pages as total_pages */

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);


if ($err) {
	echo "cURL Error #:" . $err;
}else {
	
	
	$watchmoderesp = json_decode($response, true);
	$titles = $watchmoderesp['titles'];
	
	
	foreach ($titles as $key1 => $value1) {
		$imdbresp = get_details($titles[$key1]['imdb_id']);
		
		echo '<div class = "card" style="width: 18rem;">
		<img class="card-img-top" src= "' . $imdbresp['image'] . '" alt = "img">
		<div class="card-body">
        	<h1 class = "titles"> ' . $titles[$key1]['title'] . '</h1>
			<form action="../include_files/insert_list.php" method="POST">
			<button type="submit" class= "btn btn-primary" name="favbtn" value="'. $titles[$key1]['imdb_id'] .'"> Favorite</button>
            <button type="submit" class= "btn btn-primary" name="watchbtn" value="'. $titles[$key1]['imdb_id'] .'"> Watch List</button>
			</form>
		</div>
		</div>';

		// echo '<div class="container img-container">
		// 		<img src="'.  $imdbresp['image'] .'" class="img-thumbnail">
		// 	  </div>
		// 	  <div class="container title-details-container">
		// 		<p>'. $titles[$key1]['title'] . '</p>
		//  		<p>'.'IMDB ID: ' . $titles[$key1]['imdb_id'] . '</p>
		//  		<button class="btn btn-secondary">Show plot</button>
		//  			<p class="plot">Nothin here yet..</p>
		// 	   </div>'
		//  	 ;
	}
	
}

?>