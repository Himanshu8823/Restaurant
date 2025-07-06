<?php
include('../connection/connect.php'); // Include your database connection file
session_start();
if (empty($_SESSION["user_id"])) {

    header('location:../login.php');

} else {
    // Function to fetch restaurants
    function getRestaurants($db)
    {
        $restaurants = array();

        // Assuming you have a 'restaurants' table with columns 'rs_id', 'title'
        $query = "SELECT rs_id, title FROM restaurant";
        $result = mysqli_query($db, $query);

        while ($row = mysqli_fetch_assoc($result)) {
            $restaurants[] = $row;
        }

        return $restaurants;
    }

    // Function to fetch tables based on the selected restaurant
    function getTablesByRestaurant($restaurantId, $db)
    {
        $tables = array();

        // Assuming you have a 'tables' table with columns 'table_id', 'capacity', 'is_booked', 'table_name', 'description'
        $query = "SELECT table_id, table_name FROM tables WHERE rs_id = $restaurantId AND is_booked = 0";
        $result = mysqli_query($db, $query);

        while ($row = mysqli_fetch_assoc($result)) {
            $tables[] = $row;
        }

        return $tables;
    }

    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $restaurantId = $_POST["restaurant"];
        $tableId = $_POST["table"];
        $name = $_POST["name"];
        $contact = $_POST["contact"];
        $email = $_POST["email"];
        $date = $_POST["date"];
        $time = $_POST["time"];
        $partySize = $_POST["partySize"];
        $specialRequests = $_POST["specialRequests"];

        // Validate and sanitize the input data as needed

        // Insert the booking into the database
        $insertQuery = "INSERT INTO bookings (table_id, rs_id, customer_name, contact_number, email, booking_date, booking_time, party_size, special_requests) 
                    VALUES ($tableId, $restaurantId, '$name', '$contact', '$email', '$date', '$time', $partySize, '$specialRequests')";

        if (mysqli_query($db, $insertQuery)) {
            // Mark the table as booked
            $updateTableQuery = "UPDATE tables SET is_booked = 1 WHERE table_id = $tableId";
            mysqli_query($db, $updateTableQuery);

            echo "Booking successful!";
        } else {
            echo "Error: " . $insertQuery . "<br>" . mysqli_error($db);
        }
    }

    // Fetch initial data for dropdowns
    $restaurants = getRestaurants($db);
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Restaurant Table Booking</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">

        <!-- Add jQuery (if not already included) -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- Add the Select2 JS file -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
        <style>
            body {
                font-family: 'Arial', sans-serif;
                background-color: #f2f2f2;
                margin: 0;
                padding: 0;
            
                background-image: url('../images/background_image.gif');
                
            }

            .container {
                max-width: 600px;
                margin: 50px auto;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);

            }

            h2 {
                text-align: center;
                color: blue;
                font-size: 30px;
            }

            form {
                display: grid;
                grid-gap: 15px;
                font-size: 20px;
            }

            label {
                font-weight: bold;
                font-size: 25px;
                color: magenta
            }

            input,
            select,
            textarea {
                width: 100%;
                padding: 10px;
                box-sizing: border-box;
                border: 1px solid #ccc;
                border-radius: 4px;
                margin-top: 5px;
                font-size: 20px;
            }


            button {
                background-color: #4CAF50;
                color: white;
                padding: 10px 15px;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                font-size: 20px;
            }

            button:hover {
                background-color: #45a049;

            }
        </style>
    </head>

    <body>
        
        <a href="../index.php" style="margin-left:90%"><button type="button"
                style="margin-top:20px;background-color:red;color:white">X</button></a>
        <h2>Table Booking</h2>
        <div class="container">

            <form action="" method="post" onsubmit="return validateForm()">
                <label for="restaurant">Select Restaurant:</label>
                <select name="restaurant" id="restaurant" required>
                    <?php foreach ($restaurants as $restaurant): ?>
                        <option value="<?php echo $restaurant['rs_id']; ?>">
                            <?php echo $restaurant['title']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="table">Select Table:</label>
                <select name="table" id="table" required>
                    <!-- Options for tables will be added dynamically using JavaScript -->
                </select>

                <!-- Add a default option for the first table from the database -->
                <option value="" disabled>Select a table</option>

                <label for="name">Your Name:</label>
                <input type="text" name="name" id="name" required>

                <label for="contact">Contact Number:</label>
                <input type="tel" name="contact" id="contact" required>

                <label for="email">Email:</label>
                <input type="email" name="email" id="email" required>

                <label for="date">Booking Date:</label>
                <input type="date" name="date" id="date" required>

                <label for="time">Booking Time:</label>
                <input type="time" name="time" id="time" required>

                <label for="partySize">Party Size:</label>
                <input type="number" name="partySize" id="partySize" min="1" required>

                <label for="specialRequests">Special Requests:</label>
                <textarea name="specialRequests" id="specialRequests" rows="3"></textarea>

                <button type="submit">Book Table</button>
            </form>
        </div>

        <script>
            $(document).ready(function () {
                // Initialize Select2 on the restaurant dropdown
                $('#restaurant').select2();

                // Initialize Select2 on the table dropdown
                $('#table').select2();

                // Your existing script for updating tables dropdown
                $('#restaurant').on('change', function () {
                    var restaurantId = $(this).val();
                    var tableDropdown = $('#table');

                    tableDropdown.empty().append('<option value="" disabled>Select a table</option>');

                    $.ajax({
                        url: 'get_tables.php?restaurantId=' + restaurantId,
                        method: 'GET',
                        dataType: 'json',
                        success: function (response) {
                            $.each(response, function (index, table) {
                                tableDropdown.append('<option value="' + table.table_id + '">' + table.table_name + '</option>');
                            });

                            tableDropdown.select2(); // Refresh Select2
                        },
                        error: function (xhr, status, error) {
                            console.error('Error fetching tables:', error);
                        }
                    });
                });
            });
            // Function to validate the form
            function validateForm() {
                var restaurant = document.getElementById('restaurant');
                var table = document.getElementById('table');
                var name = document.getElementById('name');
                var contact = document.getElementById('contact');
                var email = document.getElementById('email');
                var date = document.getElementById('date');
                var time = document.getElementById('time');
                var partySize = document.getElementById('partySize');

                // Reset previous error messages
                document.getElementById('tableError').innerHTML = '';
                document.getElementById('nameError').innerHTML = '';
                document.getElementById('contactError').innerHTML = '';
                document.getElementById('emailError').innerHTML = '';
                document.getElementById('dateError').innerHTML = '';
                document.getElementById('timeError').innerHTML = '';
                document.getElementById('partySizeError').innerHTML = '';

                // Check if a restaurant is selected
                if (restaurant.value === "") {
                    alert("Please select a restaurant.");
                    return false;
                }

                // Check if a table is selected
                if (table.value === "") {
                    document.getElementById('tableError').innerHTML = 'Please select a table.';
                    return false;
                }

                // Check if the name is provided
                if (name.value.trim() === "") {
                    document.getElementById('nameError').innerHTML = 'Please enter your name.';
                    return false;
                }

                // Check if a valid contact number is provided
                var contactPattern = /^\d{10}$/; // Adjust as needed
                if (!contactPattern.test(contact.value.trim())) {
                    document.getElementById('contactError').innerHTML = 'Please enter a valid 10-digit contact number.';
                    return false;
                }

                // Check if a valid email is provided
                var emailPattern = /^\S+@\S+\.\S+$/; // Basic email pattern
                if (!emailPattern.test(email.value.trim())) {
                    document.getElementById('emailError').innerHTML = 'Please enter a valid email address.';
                    return false;
                }

                // Check if a date is selected and it's in the future
                var currentDate = new Date();
                var selectedDate = new Date(date.value);
                if (!date.value || selectedDate < currentDate) {
                    document.getElementById('dateError').innerHTML = 'Please select a valid future date.';
                    return false;
                }

                // Check if a valid time is selected
                var currentTime = new Date();
                var selectedTime = new Date(date.value + ' ' + time.value);
                if (!time.value || selectedTime < currentTime) {
                    document.getElementById('timeError').innerHTML = 'Please select a valid future time.';
                    return false;
                }

                // Check if a valid party size is provided
                if (!partySize.value || partySize.value <= 0) {
                    document.getElementById('partySizeError').innerHTML = 'Please enter a valid party size.';
                    return false;
                }

                // Add more validations as needed for other form elements

                return true; // Form is valid, proceed with submission
            }

            // Your existing script for updating tables dropdown
            document.getElementById('restaurant').addEventListener('change', function () {
                var restaurantId = this.value;
                var tableDropdown = document.getElementById('table');

                // Clear existing options
                tableDropdown.innerHTML = '<option value="" disabled>Select a table</option>';

                // Fetch tables based on the selected restaurant using AJAX
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function () {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        var tables = JSON.parse(xhr.responseText);

                        // Populate the 'table' dropdown with the fetched data
                        tables.forEach(function (table) {
                            var option = document.createElement('option');
                            option.value = table.table_id;
                            option.textContent = table.table_name;
                            tableDropdown.appendChild(option);
                        });
                    }
                };

                xhr.open('GET', 'get_tables.php?restaurantId=' + restaurantId, true);
                xhr.send();
            });
        </script>

    </body>

    </html>
    <?php
} ?>