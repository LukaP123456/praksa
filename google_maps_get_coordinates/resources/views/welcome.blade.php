<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
</head>
<script src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_MAP_KEY')}}"></script>
{{--<script>--}}
{{--    async function initMap() {--}}
{{--        let address = document.getElementById('address').value--}}
{{--        console.log(address)--}}
{{--        const response = await fetch('http://127.0.0.1:8000/api/map/coordinates/' + address, {--}}
{{--            method: 'POST',--}}
{{--            headers: {--}}
{{--                'Content-Type': 'application/json'--}}
{{--            },--}}
{{--            body: JSON.stringify({--}}
{{--                address: document.getElementById('address').value--}}
{{--            })--}}
{{--        });--}}
{{--        const data = await response.json();--}}

{{--        let lat = data.latitude;--}}
{{--        let lng = data.longitude;--}}
{{--        let myLatLng = {lat: lat, lng: lng};--}}

{{--        let map = new google.maps.Map(document.getElementById('map'), {--}}
{{--            zoom: 8,--}}
{{--            center: myLatLng--}}
{{--        });--}}

{{--        let marker = new google.maps.Marker({--}}
{{--            position: myLatLng,--}}
{{--            map: map--}}
{{--        });--}}
{{--    }--}}
{{--</script>--}}

<script>
    async function initMap(callback) {
        let address = document.getElementById('address').value;
        const response = await fetch('http://127.0.0.1:8000/api/map/coordinates', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                address: address
            })
        });
        const data = await response.json();

        let lat = data.latitude;
        let lng = data.longitude;
        let myLatLng = {lat: lat, lng: lng};
        let map = new google.maps.Map(document.getElementById('map'), {
            zoom: 8,
            center: myLatLng
        });

        let marker = new google.maps.Marker({
            position: myLatLng,
            map: map
        });

        map.addListener('click', function (e) {
            placeMarker(e.latLng, map);
        });

        function placeMarker(position, map) {
            var marker = new google.maps.Marker({
                position: position,
                map: map
            });
            map.panTo(position);
            console.log(position)
        }
    }


</script>
<body>
Address: <input type="text" id="address" value="Seattle, WA"><br>
<button onclick="initMap()">Show on Map</button>
<div id="map" style="width:500px;height:380px;"></div>
</body>
</html>
