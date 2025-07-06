<?php
include("../connection/connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["feedbackId"])) {
    $feedbackId = $_POST["feedbackId"];

    // Perform the delete operation (replace 'feedback' with your actual table name)
    $deleteQuery = "DELETE FROM feedback WHERE id = '$feedbackId'";
    $deleteResult = mysqli_query($db, $deleteQuery);

    if ($deleteResult) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => mysqli_error($db)]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>
