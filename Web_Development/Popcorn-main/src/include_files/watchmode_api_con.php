
<?php

/* Makes calls to the Watchmode API. Parameter is a url string, returns a JSON. 
   Replacement APIKeys in case call limit is reached: 6e3bf15622msh2a036b1b18d2bc5p19ed6ajsnc1ee38e5b67a */
function wtchmd_api_call($paramurl){

	$curl = curl_init();

	curl_setopt_array($curl, [
		CURLOPT_URL => $paramurl,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "GET",
		CURLOPT_HTTPHEADER => [
			"X-RapidAPI-Host: watchmode.p.rapidapi.com",
			"X-RapidAPI-Key: 9efbbe6bedmsh04a467c22b89f2ap14caa1jsn86eac3955fbe"
		],
	]);

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);


	if ($err) {
		return "cURL Error #:" . $err;
	}else {
		return $response;
	}
}

?>