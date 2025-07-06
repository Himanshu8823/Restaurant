<?php

// Include your database connection file
include("connection/connect.php");

// Get admin response and order ID from POST request
$adminResponse = $_POST['admin_response'];
$orderId = $_POST['order_id'];

// Validate admin response and order ID
if (!in_array($adminResponse, ['1', '2', '3']) || !is_numeric($orderId)) {
    http_response_code(400);
    echo "Invalid admin response or order ID.";
    exit();
}

$statusMapping = [
    '1' => 'in process',
    '2' => 'delivered',
    '3' => 'rejected',
];

// Get the corresponding status from the mapping
$newStatus = $statusMapping[$adminResponse];

// Update the order status in the database
$updateQuery = "UPDATE users_orders SET status = '$newStatus' WHERE o_id = $orderId";

if (mysqli_query($db, $updateQuery)) {
    http_response_code(200);
    echo "Order status updated successfully.";
} else {
    http_response_code(500);
    echo "Error updating order status: " . mysqli_error($db);
}

// Close the database connection
mysqli_close($db);
?>
