<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['manager'])&&!isset($_SESSION['username'])&&!isset($_SESSION['cashier'])) {
    header("Location: ../login.php");
    exit();
}

// Include database connection
include("../connection/connect.php");

// Fetch the menu item ID from the URL
$item_id = $_GET['id'];

// Delete the menu item from the database
$delete_query = "DELETE FROM mess_menu_items WHERE item_id = $item_id";

if (mysqli_query($db, $delete_query)) {
    // Redirect to the manage menu items page
    header("Location: manage_menu_items.php");
    exit();
} else {
    // Error deleting menu item
    $error_message = "Error deleting menu item: " . mysqli_error($db);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Menu Item</title>
</head>

<body>

    <!-- Add your HTML content here -->
    <h1>Delete Menu Item</h1>
    <?php if (isset($error_message)) : ?>
        <div class="error"><?php echo $error_message; ?></div>
    <?php endif; ?>

</body>

</html>
