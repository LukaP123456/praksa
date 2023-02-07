<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Google maps</title>
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <style type="text/css">
        #map {
            height: 400px;
        }
    </style>
</head>

<body>
<div class="container mt-5">
    <h2>google maps</h2>
    <div id="map"></div>
</div>

<script type="text/javascript">
    function initMap() {
        const myLatLng = {lat: 22.2734719, lng: 70.7512559};
        const myLatLng2 = {lat: 45.2734719, lng: 80.7512559};
        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 5,
            center: myLatLng,
        });

        new google.maps.Marker({
            position: myLatLng, map,
            title: "asdasdasdasd",
        });

        new google.maps.Marker({
            position: myLatLng2, map,
            title: "qqqqqqqqq",
        });
    }

    window.initMap = initMap;
</script>

<script type="text/javascript"
        src="https://maps.google.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&callback=initMap"></script>

</body>
</html>
