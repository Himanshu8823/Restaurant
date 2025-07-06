<?php
// Include your database connection file
include("connection/connect.php");
session_start();

// Check if user_id is set in the session
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];}
// Fetch updated data from the database
$query_res = mysqli_query($db, "SELECT * FROM users_orders WHERE u_id='$user_id' ORDER BY date DESC");

// Check if there are any records
if (!empty($query_res) && mysqli_num_rows($query_res) > 0) {
    while ($row = mysqli_fetch_array($query_res)) {
        $status = $row['status'];
        if (empty($status) || $status == "NULL"){
            echo '<tr>';
            echo '<td>' . $row['title'] . '</td>';
            echo '<td>' . $row['quantity'] . '</td>';
            echo '<td>' . '$' . $row['price'] . '</td>';
            echo '<td>';
            if (empty($status) || $status == "NULL") {
                echo '<button type="button" class="btn cancel btn-secondary" style="font-weight:bold;"><i class="fas fa-bars"></i> Dispatch</button>';
            } 
            echo '</td>';
            echo '<td>' . $row['date'] . '</td>';
            echo '<td><a href="javascript:void(0);" onclick="deleteOrder(' . $row['o_id'] . ')" class="btn btn-danger" style="font-size:20px;background-color:red;"><i class="fas fa-trash-alt"></i> Cancel</a></td>';
            echo '</tr>';
        }
    }
} else {
    // If no records found
    echo '<tr>';
    echo '<td colspan="6">Records not found</td>';
    echo '</tr>';
}
?>
