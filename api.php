<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>WeatherU</title>
	<link rel="stylesheet" href="style.css"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://kit.fontawesome.com/25f0aa180e.js" crossorigin="anonymous"></script>
</head>

<body>
	<!-- NOTICE!!! -->
	<!-- I HAVE REMOVED MY API KEY SO THAT ITS NOT PUBLICLY AVAILABLE ON GITHUB -- NEED TO STORE SOMEWHERE -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={APIKEY}"></script>
    

    <?php
        if(isset($_POST['submit']))
        {
            $username = $_POST['uname'];
            $password = $_POST['pwd'];
           
        

            $server = "localhost";   
            $userid = "ukgxpyvvigex4";
            $pw = "$1njfkiz312";
            $db = "dbbc8pf3dpkksh";
            // Create connection
            $conn = new mysqli($server, $userid, $pw);
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $conn->select_db($db);

            $sql = "SELECT * FROM users WHERE username = '$username' AND pwd = '$password'";
            
        
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {    
                    $location = $row['loc'];
                }
            } else {
                echo "Invalid Credentials";
            }
            
            $conn->close();
        }
    ?>
    




	<script>
        var myLocation = "<?php echo $location?>";
        alert(myLocation);      
        // Input is a string in the form of 'City, State'
        function get_lat_long(input){
            return new Promise(function(resolve, reject){
                var geocoder = new google.maps.Geocoder();
                geocoder.geocode({ 'address': input}, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        var coordinates = [results[0].geometry.location.lat(), results[0].geometry.location.lng()];
                        resolve(coordinates);
                    } else {
                        reject(status)
                    }
                });
            })
            
        }

        async function update_weather(coord) {
            // 
            // NOTICE!!!
            // I HAVE REMOVED MY API KEY SO IT IS NOT PUBLIC ON GITHUB -- NEED TO FIGURE OUT HOW TO STORE SOMEWHERE SAFE AND IMPORT
            // 
            current = await fetch("https://api.openweathermap.org/data/2.5/weather?lat=" + coord[0] + "&lon=" + coord[1] + "&appid={APIKEY}&units=imperial")
                .then(current => current.text())
                .then(data => {
                    data = JSON.parse(data);
                    temp = data.main.temp;
                    feels_like = data.main.feels_like;
                    city_name = data.name;
                    description = data.weather.main;
                    time_zone = data.timezone;

                }).catch (error => console.log(error))
            document.getElementById("curr_city").innerHTML = city_name;
            document.getElementById("temp").innerHTML = temp + "&deg;F";
            document.getElementById("temp2").innerHTML = feels_like + "&deg;F";

            


            weekly = await fetch("https://api.openweathermap.org/data/2.5/forecast?lat=" + coord[0] + "&lon=" + coord[1] + "&appid={APIKEY}&units=imperial")
                .then(weekly => weekly.text())
                .then(data => {
                    data = JSON.parse(data);
                    weekly_data = data.list;
                    
                }).catch (error => console.log(error))

            
            for (var i = 0; i < 5; i++) {
                day_temp = weekly_data[i].main.temp;
                document.getElementById("5day" + i).innerHTML = Math.round(day_temp) + "&deg;";
            }

            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth() + 1;

            for (var i = 0; i < 5; i++) {
                document.getElementById("date" + i).innerHTML = mm + '/' + (dd + i);
            }

            if (description == "Clear" && today.getHours() >= 19 && today.getHours() <= 6){
                document.getElementById("conditions").innerHTML = "<i class='fa-solid fa-moon'></i>"
            }else if (description == "Clear" && today.getHours() < 19 && today.getHours() > 6 ){
                document.getElementById("conditions").innerHTML = "<i class='fa-solid fa-sun'></i>"
            }else if (description == "Rain" || description == "Drizzle"){
                document.getElementById("conditions").innerHTML = "<i class='fa-solid fa-cloud-showers-heavy'></i>"
            }else if (description == "Snow")
                document.getElementById("conditions").innerHTML = "<i class='fa-solid fa-snowflake'></i>"
            }else if (description == "Clouds"){
                document.getElementById("conditions").innerHTML = "<i class='fa-solid fa-cloud'></i>"
            }else if (description == "Thunderstorm"){
                document.getElementById("conditions").innerHTML = "<i class='fa-solid fa-cloud-bolt'></i>"
            }else {
                document.getElementById("conditions").innerHTML = "<i class='fa-solid fa-cloud-fog'></i>"
            }

        }

        async function load_page(){
            update_weather(await get_lat_long("Seattle, WA"));
        }

        async function search_weather(input){
            update_weather(await get_lat_long(input));
        }
                    

    </script>
	<!-- NOTES FOR BACK-END -->
	<!-- The background photo, background color of the weather box, and the weather icon all get swapped out depending on what kind of weather it is. All options are already commented out for you either in the html or the css. For background and background color, there are 3 options: sunny, night, cloudy/rainy/snowy. For the icons, there are 5 options: sunny, night, cloudy, rainy, and snowy. -->
	<script src="jquery-3.6.0.js"></script>
	<div id="main">
		<header><button id="logout">SIGN OUT</button></header>
		<h1>WeatherU</h1>
		<h2>Current Weather in
			<br>
			<input id='city'><button id="enter"><i class="fa fa-search"></i></button>
		</h2>
		<div id="weather">
			<div id="data">
				<div id="curr_city"></div>
				<div id="row1">
					<div id="temp"></div>
					<div id="conditions">
						<i class="fa-solid fa-sun"></i>
						<!--
						<i class="fa-solid fa-moon"></i> //night
						<i class="fa-solid fa-cloud-showers-heavy"></i> //rain
						<i class="fa-solid fa-cloud"></i> //cloudy
						<i class="fa-solid fa-snowflake"></i> //snowy
						-->
					</div>
				</div>
				<div id="row2">
					<div id="feels">Feels like:</div>
					<div id="temp2"></div>
				</div>
			</div>
		</div>
		<div id="week">
            <a href=""><div class="days"><div id='date0'>Today </div><div class="temp7" id="5day0">&deg;</div></div></a>
			<a href=""><div class="days"><div id='date1'>Today </div><div class="temp7" id="5day1">&deg;</div></div></a>
			<a href=""><div class="days"><div id='date2'>Today </div><div class="temp7" id="5day2">&deg;</div></div></a>
			<a href=""><div class="days"><div id='date3'>Today </div><div class="temp7" id="5day3">&deg;</div></div></a>
			<a href=""><div class="days"><div id='date4'>Today </div><div class="temp7" id="5day4">&deg;</div></div></a>
		</div>

		<div id="clothes">
			<h3>What to wear:</h3>
			<div id="recommendations">
				<div id="rec_text">
					It's hot and sunny out! We recommend short sleeves and light pants or shorts. Enjoy some time outside today!
				</div>
			</div>
		</div>
	</div>
	<footer>
		<a href="mailto:gabriel.schwartz@tufts.edu?subject=Contact WeatherU!">
			<div class="footbutton">Contact us!</div>
		</a>
		<a href="">
			<div class="footbutton">Sign out</div>
		</a>
	</footer>
</body>

<script>
    document.getElementById('enter').addEventListener('click', function (){

        if (document.getElementById('city').value){
            search_weather(document.getElementById('city').value)
        }
    });
    
</script>
<script>search_weather(myLocation)</script>

</html>
