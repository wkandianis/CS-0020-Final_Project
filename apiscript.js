
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
    res = await fetch("https://api.openweathermap.org/data/2.5/weather?lat=" + coord[0] + "&lon=" + coord[1] + "&appid={APIKEY}&units=imperial")
        .then(res => res.text())
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
}

async function load_page(){
    update_weather(await get_lat_long("Seattle, WA"));
}

async function search_weather(input){
    update_weather(await get_lat_long(input));
}




