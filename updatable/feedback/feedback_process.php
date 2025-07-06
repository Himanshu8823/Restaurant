<?php
include("../connection/connect.php");
$feedbackMessage = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $rating = $_POST['rating'];
    $easeOfUse = $_POST['easeOfUse'];
    $designFeedback = $_POST['design'];
    $suggestions = $_POST['improvements'];

    $sql = "INSERT INTO website_feedbacks (name, email, rating, ease_of_use, design_feedback, suggestions) 
            VALUES ('$name', '$email', $rating, $easeOfUse, '$designFeedback', '$suggestions')";

    if ($db->query($sql) === TRUE) 
    {
        $feedbackMessage = "Thanks for your feedback, $name! We appreciate your input.";
    }
     else
      {
        $feedbackMessage = "Error: " . $sql . "<br>" . $db->error;
    }
    $db->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Submission</title>
    <style>
       
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .close-button {
            background-color: #4caf50;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 26px;
            transition: background-color 0.3s ease;
        }

        .close-button:hover {
            background-color: #45a049;
        }
        p{
            font-size: 26px
            ;
        }
    </style>
</head>

<body>
  
    <div id="feedbackModal" class="modal">
        <div class="modal-content">
            <p><?php echo $feedbackMessage; ?></p>
            <button class="close-button" onclick="closeModal()">Close</button>
        </div>
    </div>

    <script>
        
        function openModal() {
            document.getElementById("feedbackModal").style.display = "flex";
        }

       
        function closeModal() {
            document.getElementById("feedbackModal").style.display = "none";
            window.location="website_feedback.php";
         
        }
0
        window.onload = function () {
            <?php echo !empty($feedbackMessage) ? 'openModal();' : ''; ?>
        };
    </script>
</body>

</html>
