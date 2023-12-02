
async function init(enable) {
    setTimeAndDate();
    if(enable){
        const weather = await getWeatherData(
            "http://api.weatherapi.com/v1/current.json?key=34554d57195c4493b22120517232405&q=Vlissingen"
        );
        setIcon(weather.current.condition.code, weather.current.condition.text);
        setTemperature(weather.current.temp_c);
        setWindSpeed(weather.current.wind_kph);
        setWindDirection(weather.current.wind_dir);
    }
    else {
        setIcon();
        setTemperature();
        setWindSpeed();
        setWindDirection();
    }

}

async function getWeatherData(url) {
    try {
        
        let response = await fetch(url);
        let weather = await response.json();
        
        return weather;
    }
    catch (err) {
        console.error("Error: ", err);
    }
}



function setIcon(iconNumber = 1000, description='sunny'){
    let weatherImg = document.getElementById('weatherImg');
    weatherImg.src = `assets/icons/weather/${iconNumber}.png`;
    weatherImg.alt = description;
}

function setTemperature(temperature = 25) {
    document.getElementById('temperature').innerHTML = `${temperature} °C`
}

function setWindSpeed(windSpeed = 20) {
    document.getElementById('windSpeed').innerHTML = `${windSpeed} km/h`

}

function setWindDirection(windDirection = "SW") {
    document.getElementById('windDireciton').classList.add(windDirection.toString().toLowerCase());
}

setInterval(setTimeAndDate, 300);

function setTimeAndDate() {
    let timeField = document.getElementById('time');
    let dataField = document.getElementById('data');

    const date = new Date();

    let day = date.getDate();
    let month = date.getMonth()+1;
    let year = date.getFullYear();

    let hours = date.getHours();
    let minutes = date.getMinutes();

    dataField.innerHTML = `${day}.${month}.${year}`;
    if (minutes < 10) {
        timeField.innerHTML = `${hours}:0${minutes}`;
    }
    else {
        timeField.innerHTML = `${hours}:${minutes}`;
    }
}

//disable and enable the api calls
//with parameter of init function
//true - api is being called
//false - api calls are paused and default values are used
init(true);
