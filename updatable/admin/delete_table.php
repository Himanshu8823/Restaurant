<?php
session_start();
include("../connection/connect.php");
error_reporting(0);

if (isset($_GET['table_del'])) {
    $table_id = $_GET['table_del'];

    // Perform the delete operation for bookings, if they exist
    $delete_query_bookings = "DELETE FROM bookings WHERE table_id='$table_id'";
    $result_bookings = mysqli_query($db, $delete_query_bookings);

    // Perform the delete operation for tables
    $delete_query_tables = "DELETE FROM tables WHERE table_id='$table_id'";
    $result_tables = mysqli_query($db, $delete_query_tables);

    if ($result_tables || $result_bookings) {
        echo "<script>alert('Table and related bookings deleted successfully');</script>";
        echo "<script>window.location.href='all_tables.php';</script>";
    } else {
        echo "<script>alert('Error in deleting table or bookings: " . mysqli_error($db) . "');</script>";
        echo "<script>window.location.href='all_tables.php';</script>";
    }
} else {
    // If table_id is not set, redirect to the appropriate page
    header("Location: all_tables.php");
    exit();
}
?>
