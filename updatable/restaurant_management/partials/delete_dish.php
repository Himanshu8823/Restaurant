<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['manager']) && !isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}

// Include database connection
include("../connection/connect.php");
$rs_id=$_SESSION['rs_id'];
// Check if dish ID is set and valid
if (isset($_GET['d_id']) && is_numeric($_GET['d_id'])) {
    $d_id = $_GET['d_id'];

    // Delete dish from the database
    $delete_sql = "DELETE FROM dishes WHERE d_id = $d_id";
    if (mysqli_query($db, $delete_sql)) {
        // Redirect back to manage_menu.php
        header("Location: manage_menu.php?rs_id=$rs_id");
        exit();
    } else {
        echo "Error deleting dish: " . mysqli_error($db);
    }
} else {
    echo "Invalid dish ID.";
    exit();
}
?>
