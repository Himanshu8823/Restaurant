<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Map with Directions</title>
    <style>
        #map {
            height: 400px;
            width: 100%;
        }
    </style>
</head>
<body>
    <div id="map"></div>

    <script>
        // Replace with your restaurant and user addresses
        var restaurantAddress = "sandeep food plaza";
        var userAddress = "new english school nashirabad";

        function initMap() {
            var directionsService = new google.maps.DirectionsService();
            var directionsRenderer = new google.maps.DirectionsRenderer();
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 14,
                center: {lat: 37.7749, lng: -122.4194} // Default center (San Francisco)
            });
            directionsRenderer.setMap(map);

            var request = {
                origin: userAddress,
                destination: restaurantAddress,
                travelMode: 'DRIVING'
            };

            directionsService.route(request, function(response, status) {
                if (status == 'OK') {
                    directionsRenderer.setDirections(response);
                } else {
                    window.alert('Directions request failed due to ' + status);
                }
            });
        }
    </script>

    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCP8nKjC3oW1A-z70ef1-crdc2_EQGDQJQ&callback=initMap"></script>
</body>
</html>
