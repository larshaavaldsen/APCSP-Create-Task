<?php
$quer = htmlspecialchars($_GET["quer"]);
// Get cURL resource
$curl = curl_init();
// Set some options - we are passing in a useragent too here
curl_setopt_array($curl, [
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'https://api.apixu.com/v1/current.json?key=sample='.$quer,
    CURLOPT_USERAGENT => 'Codular Sample cURL Request'
]);
// Send the request & save response to $resp
$resp = curl_exec($curl);
// Close request to clear up some resources
curl_close($curl);
$arr = json_decode($resp, true);
$location = $arr['location']['name'];
$region = $arr['location']['region'];
$country = $arr['location']['country'];
$currentf = $arr['current']['temp_f'];
$condition = $arr['current']['condition']['text'];
?>
<html>
    <head>
        <link rel="stylesheet" href="https://cdn.rawgit.com/mblode/marx/master/css/marx.min.css">
        <link href="https://afeld.github.io/emoji-css/emoji.css" rel="stylesheet">
        <script lang="js">
  	function tempC() {
                var temps = '<?php print($currentf); ?>';
                if(temps > 90) {
                    var commentT = 'Its quite hot in <?php print($location) ?> today. Dress lightly';
                }
                else if (temps > 55) {
                    var commentT = 'Its mild in <?php print($location) ?> today. Shorts and a t-shirt will do!';
                }
                else if (temps < 55) {
                    var commentT = 'Its cold in <?php print($location) ?> today. Might want to pack a jacket!';
                }
                document.getElementById('tempSpot').innerHTML = commentT;
          }
	function conditions() {
		var conditi = '<?php print($condition); ?>'
		if(conditi == 'Sunny') {
		    var commentC = 'It nice and sunny out, maybe pack a hat ' + '<i class="em em-sunny"></i>';
		}
		else if(conditi.includes('cloud') == true) {
		    var commentC = 'Its overcast today, might want a jacket ' + '<i class="em em-cloud"></i>';
		}

		else if(conditi == 'Mist') {
		   var commentC = 'Its misty out there today';
		}
		else if(conditi.includes('rain') == true) {
		   var commentC = 'It is rainy today, pack an umbrella! <i class="em em-umbrella_with_rain_drops"></i>';
		}
		document.getElementById('condSpot').innerHTML = commentC;
	}
        </script>
    </head>
    <body onload='tempC(); conditions();'>
        <main>
            <h1>Weather-inator <i class="em em-partly_sunny_rain"></i></h1>
           <hr>
           <h2>Weather for <?php print($location); print(', '); print($region); print(', '); print($country) ?></h2>
            <div id='temp' value='<?php print($currentf)?>'><h4>Current Temperature: <?php print($currentf) ?>&#176; F</h4>
            <div id='condition' value='<?php print($condition)?>'><h4>Current Weather: <?php print($condition)?></h4></div>
            <a href='/index.html'>Back</a>
            <h6 id="tempSpot"></h6>
	    <h6 id='condSpot'><h6>
 </main>
    </body>
</html>
