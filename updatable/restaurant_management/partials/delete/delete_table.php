<?php
// Include the database connection file
include("../../connection/connect.php");
error_reporting(0);
session_start();
$res_id=$_SESSION['rs_id'];

// Check if the table ID to be deleted is provided in the URL
if(isset($_GET['table_del'])) {
    // Sanitize the input to prevent SQL injection
    $table_id = mysqli_real_escape_string($db, $_GET['table_del']);

    // SQL query to delete the table
    $delete_query = "DELETE FROM tables WHERE table_id = '$table_id'";
    
    // Execute the delete query
    $delete_result = mysqli_query($db, $delete_query);

    // Check if the delete operation was successful
    if($delete_result) {
        // Table deleted successfully
        echo '<script>alert("Table deleted successfully!");</script>';
        header("Location: ../tables.php?rs_id=$res_id");
    } else {
        // Error deleting table
        echo '<script>alert("Error deleting table: ' . mysqli_error($db) . '");</script>';
        header("Location: ../tables.php?rs_id=$res_id");
    }
} else {
    // Redirect if table ID is not provided
    header("Location: ../tables.php?rs_id=$res_id");
    exit(); // Stop further execution
}
?>
