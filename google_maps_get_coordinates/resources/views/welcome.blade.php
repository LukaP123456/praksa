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
        //Get value from input field
        let address = document.getElementById('address').value;
        //Send the request with data to the api
        const response = await fetch('http://127.0.0.1:8000/api/map/coordinates', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                address: address
            })
        });
        //Data from the api
        const data = await response.json();

        //Extract the lat and long from the data variable
        let lat = data.latitude;
        let lng = data.longitude;
        let myLatLng = {
            lat: lat,
            lng: lng
        };

        //Create the map with marker on the returned lat and lng
        let map = new google.maps.Map(document.getElementById('map'), {
            zoom: 8,
            center: myLatLng
        });

        //Add the marker to the map
        let marker = new google.maps.Marker({
            position: myLatLng,
            map: map
        });

        //Add event listener on map which will call function placeMarker which will place marker on map
        google.maps.event.addDomListener(map, 'click', function (event) {
            placeMarker(event.latLng, map);
        });

        function placeMarker(position, map) {
            let marker = new google.maps.Marker({
                position: position,
                map: map
            });
            map.panTo(position);
            console.log("lat: " + position.toJSON().lat, "lng: " + position.toJSON().lng);
        }
    }

</script>
<body onload="initMap()">
<div>
    Address: <input type="text" id="address" value="Seattle, WA"><br>
    <button>Show on Map</button>
    <div id="map" style="width:500px;height:380px;"></div>
</div>
</body>
</html>
