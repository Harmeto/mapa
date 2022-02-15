<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]>      <html class="no-js"> <!--<![endif]-->
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>API Web</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.4.0/dist/leaflet.css" integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA==" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.4.0/dist/leaflet.js" integrity="sha512-QVftwZFqvtRNi0ZyCtsznlKSWOStnDORoefr1enyq5mVL4tmKB3S/EnC3rRJcxCPavG10IcrVGSmPh6Qw5lwrg==" crossorigin=""></script>
    <style>
        #mymap {
            height: 400px;
        }
        
        b {
            text-decoration: underline;
            text-decoration-color: red;
        }
    </style>
</head>

<body>
    <h1>Tu ubicacion en tiempo real</h1>
    <h3>Acepta la ubicacion del navegador, para ver en donde te encuentras actualmente.</h3>
    <h3><b> Los datos seran enviados a un servidor para jakearlo.</b></h3>
    <p>
        latitude: <span id="latitude"></span>&deg;<br /> longitude: <span id="longitude"></span>&deg;
    </p>
    <div id="task-form">
        <label for="texto">Ingrese su fruta favorita: </label>
        <input id='texto'>
        <button id="geolocate"> Enviar </button>
    </div>
    <br>
    <div id="mymap"></div>

    <script>
        //geolocalizacion 
        if ('geolocation' in navigator) {
            console.log('geolocation available');
            //si esta disponible geolocalizar
            navigator.geolocation.getCurrentPosition(async position => {
                //añade variables para latitud y longitud
                lat = position.coords.latitude;
                lon = position.coords.longitude;
                //asigna valores a los div latitud y longitud
                document.getElementById('latitude').textContent = lat;
                document.getElementById('longitude').textContent = lon;
                const data = {
                    lat,
                    lon
                };
                //mapa para ver nuestra ubicacion 
                const mymap = L.map('mymap').setView([lat, lon], 15);
                const attribution =
                    '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors';
                const tileUrl = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
                const tiles = L.tileLayer(tileUrl, {
                    attribution
                });
                tiles.addTo(mymap);
                const marker = L.marker([lat, lon]).addTo(mymap);
            });
        } else {
            console.log('geolocation not available');
        }
        //boton GEOLOCATE 


        document.getElementById('geolocate').addEventListener('click', event => {
            navigator.geolocation.getCurrentPosition(async position => {
                //añade variables para latitud y longitud
                lat = position.coords.latitude;
                lon = position.coords.longitude;
                //asigna valores a los div latitud y longitud
                document.getElementById('latitude').textContent = lat;
                document.getElementById('longitude').textContent = lon;
                const escr = document.getElementById('texto').value;
                const data = {
                    lat,
                    lon,
                    escr,
                };
                //transforma y envia los datos en forma de json 
                const options = {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                };
                //envia los datos a /api
                const response = await fetch('/api', options);
                const json = await response.json();
                console.log('datos enviados ahora lo vamoh a jakear');
            })


        });
    </script>

</body>

</html>