<?php
$airtrail_baseurl = ""; // Set your Airtrail base URL here, e.g., "https://myairtrail.com"
$airtrail_apikey = ""; // Set your Airtrail API key here

$context = stream_context_create([
    "http" => [
        "header" => "Authorization: Authorization: Bearer $airtrail_apikey"
    ]
]);
$flightlist = json_decode(file_get_contents($airtrail_baseurl . "/api/flight/list", false, $context), true)['flights'];
?>

<!doctype html>
<html lang="en-US">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width" />
    <title>My flights</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
        crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
        crossorigin=""></script>
    <script src="https://cdn.jsdelivr.net/npm/leaflet.geodesic"></script>


    <style>
        html,
        body {
            height: 100%;
            margin: 0;
        }

        .leaflet-container {
            height: 100%;
            width: 100%;
            max-width: 100%;
            max-height: 100%;
        }
    </style>
</head>

<body>
    <div id="map"></div>
    <script>
        const map = L.map('map').setView([20, 0], 3);

        const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        <?php
        foreach ($flightlist as $key => $value) {
            echo 'const flight_' . $key . ' = new L.Geodesic([[' . $value['from']['lat'] . ', ' . $value['from']['lon'] . '], [' . $value['to']['lat'] . ', ' . $value['to']['lon'] . ']]).addTo(map);';
        }
        ?>
    </script>
</body>

</html>