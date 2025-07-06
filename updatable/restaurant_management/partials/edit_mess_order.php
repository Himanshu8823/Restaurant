<?php
session_start();

// Redirect to login page if user is not logged in
if (!isset($_SESSION['manager'])&&!isset($_SESSION['username'])&&!isset($_SESSION['cashier'])) {
    header("Location: ../login.php");
    exit();
}
$rs_id=$_SESSION['rs_id'];

// Include database connection
include("../connection/connect.php");


// Fetch the order ID from the URL
$order_id = $_GET['id'];

$order_query = "SELECT mess_orders.*, mess_customers.full_name AS customer_name, mess_menu_items.item_name AS item_name, mess_orders.order_status 
                FROM mess_orders 
                INNER JOIN mess_customers ON mess_orders.customer_id = mess_customers.customer_id 
                INNER JOIN mess_menu_items ON mess_orders.item_id = mess_menu_items.item_id 
                WHERE mess_orders.order_id = $order_id";
$order_result = mysqli_query($db, $order_query);
$order = mysqli_fetch_assoc($order_result);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {

    $quantity = $_POST['quantity'];
    $order_status = $_POST['order_status'];
    $delivery_address = $_POST['delivery_address'];
    $delivery_time = $_POST['delivery_time'];

    $update_query = "UPDATE mess_orders 
                     SET quantity = '$quantity', 
                         order_status = '$order_status', delivery_address = '$delivery_address', delivery_time = '$delivery_time'
                     WHERE order_id = $order_id";

    if (mysqli_query($db, $update_query)) {
        
        header("Location: view_mess_orders.php?rs_id=$rs_id");
        exit();
    } else {
        // Error updating order
        $error_message = "Error updating mess order: " . mysqli_error($db);
    }
}

// Include header, menu, and sidebar files
include("hel.php");
include('header_menu.php');
include('header.php');
include('sidebar.php');
?>

<div class="wrapper">
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <section class="content-header">
            <h1>Edit Mess Order</h1>
        </section>
        <section class="content">
            <?php if (isset($error_message)) : ?>
                <div class="alert alert-danger"><?php echo $error_message; ?></div>
            <?php endif; ?>
            <form method="post" action="">
                <div class="form-group">
                    <label for="customer_name">Customer Name</label>
                    <input type="text" class="form-control" id="customer_name" name="customer_name" value="<?php echo $order['customer_name']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="item_name">Item Name</label>
                    <input type="text" class="form-control" id="item_name" name="item_name" value="<?php echo $order['item_name']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input type="number" class="form-control" id="quantity" name="quantity" value="<?php echo $order['quantity']; ?>">
                </div>
                <div class="form-group">
                    <label for="order_status">Order Status</label>
                    <select class="form-control" id="order_status" name="order_status">
                        <option value="Pending" <?php if ($order['order_status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                        <option value="Completed" <?php if ($order['order_status'] == 'Completed') echo 'selected'; ?>>Completed</option>
                        <option value="Rejected" <?php if ($order['order_status'] == 'Rejected') echo 'selected'; ?>>Rejected</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="delivery_address">Delivery Address</label>
                    <input type="text" class="form-control" id="delivery_address" name="delivery_address" value="<?php echo $order['delivery_address']; ?>">
                </div>
                <div class="form-group">
                    <label for="delivery_time">Delivery Time</label>
                    <input type="datetime-local" class="form-control" id="delivery_time" name="delivery_time" value="<?php echo date('Y-m-d\TH:i', strtotime($order['delivery_time'])); ?>">
                </div>
                <button type="submit" class="btn btn-primary" name="submit">Update</button>
            </form>
        </section>
    </div>

    <!-- Include your footer -->
    <?php include("footer.php"); ?>
</div>
<!-- ./wrapper -->
