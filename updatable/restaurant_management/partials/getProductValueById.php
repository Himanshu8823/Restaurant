<?php
include("../connection/connect.php");

if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];

    $query = "SELECT title, price FROM dishes WHERE d_id = $product_id";
    $result = mysqli_query($db, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        echo json_encode($row);
    } else {
        echo json_encode(['error' => 'Product not found']);
    }
} else {
    echo json_encode(['error' => 'Invalid request']);
}
?>
