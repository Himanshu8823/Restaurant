<?php
include("../connection/connect.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize user inputs
    $rs_id = isset($_POST['rs_id']) ? intval($_POST['rs_id']) : 0;
    $feedback_email = filter_var($_POST['feedback-email'], FILTER_SANITIZE_EMAIL);

    // Validate the email
    if (!filter_var($feedback_email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email address");
    }

    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $rating = intval($_POST['rating']);
    $feedback = filter_var($_POST['message'], FILTER_SANITIZE_STRING);

    // Perform database insertion
    $stmt = $db->prepare("INSERT INTO feedback (rs_id, name, feedback_email, rating, message) VALUES (?, ?, ?, ?, ?)");

    // Check for errors in the prepare statement
    if (!$stmt) {
        die("Error in prepare statement: " . $db->error);
    }

    // Bind parameters
    $stmt->bind_param("issis", $rs_id, $name, $feedback_email, $rating, $feedback);

    // Check if the bind_param was successful
    if (!$stmt) {
        die("Error in bind_param: " . $db->error);
    }

    // Execute the statement
    if ($stmt->execute()) {
        // Insertion successful
        // Trigger JavaScript to show custom modal with the success message
        echo "<script>
                document.addEventListener('DOMContentLoaded', function () {
                    // Display your custom modal here
                    // You can customize this according to your design
                    var modal = document.getElementById('custom-modal');
                    var closeModalButton = document.getElementById('close-modal-button');
                    
                    modal.style.display = 'block';

                    closeModalButton.addEventListener('click', function() {
                        modal.style.display = 'none';
                        window.location.href = 'restaurant_feedback.php';
                    });
                });
              </script>";
        // You can redirect or perform other actions as needed.
    } else {
        // Insertion failed
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();

    // Close the database connection
    $db->close();
} else {
    echo "Invalid request";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Page Title</title>
    <style>
        /* Add your custom modal styles here */
        #custom-modal {
            font-size: 30px;
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            text-align: center;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ccc;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        #close-modal-button {
            cursor: pointer;
            display: inline-block;
            margin-top: 10px;
            padding: 10px;         
            background-color: green;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 25px;
        }
    </style>
</head>
<body>

<!-- Your other HTML content goes here -->

<!-- Custom Modal -->
<div id="custom-modal">
    <p>Feedback submitted successfully. Thank you!</p>
    <center><button id="close-modal-button">Close</button></center>
</div>

</body>
</html>
