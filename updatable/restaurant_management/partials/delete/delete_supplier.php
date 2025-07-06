<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit(); 
}

// Include database connection
include("../../connection/connect.php");

// Check if ID and rs_id are set
if(isset($_GET['id']) && isset($_GET['rs_id'])) {
    // Sanitize input to prevent SQL injection
    $supplier_id = mysqli_real_escape_string($db, $_GET['id']);
    $rs_id = mysqli_real_escape_string($db, $_GET['rs_id']);

    // Construct the DELETE query
    $sql = "DELETE FROM inventory_suppliers WHERE supplier_id = '$supplier_id' AND rs_id = '$rs_id'";

    // Execute the query
    if(mysqli_query($db, $sql)) {
        // Deletion successful
        echo "<script>alert('Supplier deleted successfully');</script>";
    } else {
        // Error occurred
        echo "<script>alert('Error deleting supplier');</script>";
    }
} else {
    // ID or rs_id not set
    echo "<script>alert('ID or rs_id not provided');</script>";
}

?>
