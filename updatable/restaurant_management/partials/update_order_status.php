<?php
// Include your database connection file
include 'connection/connect.php';

// Check if request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Decode JSON data received from the client
    $data = json_decode(file_get_contents('php://input'), true);

    // Validate input
    if (!isset($data['orderId']) || !isset($data['status'])) {
        // Send error response for missing parameters
        http_response_code(400);
        echo json_encode(array('error' => 'Missing parameters'));
        exit;
    }

    // Sanitize data
    $orderId = mysqli_real_escape_string($db, $data['orderId']);
    $status = mysqli_real_escape_string($db, $data['status']);

    // Validate status
    if ($status !== 'in process' && $status !== 'rejected') {
        // Send error response for invalid status
        http_response_code(400);
        echo json_encode(array('error' => 'Invalid status'));
        exit;
    }

    // Check if the order exists
    $checkQuery = "SELECT * FROM users_orders WHERE id = '$orderId'";
    $checkResult = mysqli_query($db, $checkQuery);
    if (!$checkResult || mysqli_num_rows($checkResult) === 0) {
        // Send error response if the order doesn't exist
        http_response_code(404);
        echo json_encode(array('error' => 'Order not found'));
        exit;
    }

    // Update order status in the database
    $updateQuery = "UPDATE users_orders SET status = '$status' WHERE id = '$orderId'";
    $updateResult = mysqli_query($db, $updateQuery);
    if ($updateResult) {
        // Send success response
        http_response_code(200);
        echo json_encode(array('message' => 'Order status updated successfully'));
    } else {
        // Send error response if update fails
        http_response_code(500);
        echo json_encode(array('error' => 'Error updating order status'));
    }
} else {
    // Send error response for unsupported request method
    http_response_code(405);
    echo json_encode(array('error' => 'Method Not Allowed'));
}
?>
