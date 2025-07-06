<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Include database connection
    include 'connect.php';

    $address = $_POST['address'];

    // Replace 'YOUR_API_KEY' with your actual Google Maps API key
    $apiKey = 'AIzaSyCP8nKjC3oW1A-z70ef1-crdc2_EQGDQJQ';
    $apiUrl = "https://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($address) . "&key=" . $apiKey;

    // Make a request to the Google Maps Geocoding API
    $response = file_get_contents($apiUrl);
    $data = json_decode($response, true);

    if ($data && $data['status'] === 'OK' && isset($data['results'][0]['geometry']['location'])) {
        $location = $data['results'][0]['geometry']['location'];

        // Display the latitude and longitude on the screen
        $latitude = $location['lat'];
        $longitude = $location['lng'];

        echo "<h2>Coordinates for '$address':</h2>";
        echo "<table border='1'>";
        echo "<tr><th>Latitude</th><th>Longitude</th></tr>";
        echo "<tr><td>$latitude</td><td>$longitude</td></tr>";
        echo "</table>";
    } else {
        echo "Error converting address to coordinates. Please check the address.";
    }
}
?>
