<?php

// Include the file with the database connection
include("connect.php");

// Replace this with your actual Google Maps API key
$googleMapsApiKey = "AIzaSyCP8nKjC3oW1A-z70ef1-crdc2_EQGDQJQ";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user's address from the form
    $userAddress = $_POST["user_address"];

    // Geocode user's address to get coordinates
    $userCoordinates = geocodeAddress($userAddress, $googleMapsApiKey);

    if ($userCoordinates) {
        // Fetch all restaurants from the database
        $sql = "SELECT * FROM restaurant";
        $result = $db->query($sql);

        if ($result) {
            // Check if there are rows in the result
            if ($result->num_rows > 0) {
                $restaurantsFound = false;

                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    // Geocode restaurant address to get coordinates
                    $restaurantCoordinates = geocodeAddress($row['address'], $googleMapsApiKey);

                    if ($restaurantCoordinates) {
                        // Calculate distance using Haversine formula
                        $distance = haversineDistance(
                            $userCoordinates['lat'],
                            $userCoordinates['lng'],
                            $restaurantCoordinates['lat'],
                            $restaurantCoordinates['lng']
                        );

                        if ($distance <= 50) {
                            echo "Restaurant: " . $row["title"] . "<br>";
                            // Output other restaurant details as needed
                            $restaurantsFound = true;
                        }
                    }
                }

                if (!$restaurantsFound) {
                    echo "No restaurants found within 50 km.";
                }
            } else {
                echo "No restaurants found.";
            }
        } else {
            // Output the error message
            echo "Query error: " . $db->error;
        }
    } else {
        echo "Geocoding failed for user's address.";
    }
}

// Function to geocode an address and get coordinates
function geocodeAddress($address, $apiKey)
{
    $address = urlencode($address);
    $apiKey = urlencode($apiKey);

    $geocodeUrl = "https://maps.googleapis.com/maps/api/geocode/json?address=$address&key=$apiKey";

    $response = file_get_contents($geocodeUrl);
    $data = json_decode($response, true);

    if ($data && $data['status'] === 'OK') {
        $location = $data['results'][0]['geometry']['location'];
        return $location;
    } else {
        return null;
    }
}

// Function to calculate Haversine distance
function haversineDistance($lat1, $lon1, $lat2, $lon2)
{
    $earthRadius = 6371; // in kilometers

    $dlat = deg2rad($lat2 - $lat1);
    $dlon = deg2rad($lon2 - $lon1);

    $a = sin($dlat / 2) * sin($dlat / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dlon / 2) * sin($dlon / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

    $distance = $earthRadius * $c;

    return $distance;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Finder</title>
    <script>
        // Function to get user's current location
        function useCurrentLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    // Update the form input with the current coordinates
                    document.getElementById('user_address').value = position.coords.latitude + ', ' + position.coords.longitude;
                }, function (error) {
                    console.error("Error getting current location:", error.message);
                });
            } else {
                alert("Geolocation is not supported by your browser.");
            }
        }
    </script>
</head>
<body>

<h1>Find Nearby Restaurants</h1>

<form method="post" action="">
    <label for="user_address">Enter Your Location:</label>
    <input type="text" id="user_address" name="user_address" required>
    <button type="button" onclick="useCurrentLocation()">Use Your Current Location</button>
    <button type="submit">Find Restaurants</button>
</form>

</body>
</html>
