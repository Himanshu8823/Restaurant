<?php
session_start();

// Redirect to login page if user is not logged in
if (!isset($_SESSION['manager'])&&!isset($_SESSION['username'])&&!isset($_SESSION['cashier'])) {
    header("Location: ../login.php");
    exit();
}

// Include database connection
include("../connection/connect.php");

// Initialize variables
$message = '';

// Fetch customers
$rs_id = $_SESSION['rs_id'];
$customers_query = "SELECT * FROM mess_customers WHERE rs_id = $rs_id";
$customers_result = mysqli_query($db, $customers_query);

// Fetch menu items
$menu_items_query = "SELECT * FROM mess_menu_items WHERE rs_id = $rs_id";
$menu_items_result = mysqli_query($db, $menu_items_query);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Retrieve data from the form
    $rs_id = $_SESSION['rs_id'];
    $customer_id = $_POST['customer_id'];
    $item_id = $_POST['item_id'];
    $quantity = $_POST['quantity'];
    $order_date = date("Y-m-d");
    $order_status = 'Pending'; // Assuming the order is initially pending
    $delivery_address = $_POST['delivery_address'];
    $delivery_time = $_POST['delivery_time'];

    // Insert data into the database
    $insert_query = "INSERT INTO mess_orders (rs_id, customer_id, item_id, quantity, order_date, order_status, delivery_address, delivery_time,order_status) 
                     VALUES ('$rs_id', '$customer_id', '$item_id', '$quantity', '$order_date', '$order_status', '$delivery_address', '$delivery_time','pending')";

    if (mysqli_query($db, $insert_query)) {
        // Order added successfully
        $message = "Mess order added successfully";
    } else {
        // Error adding order
        $message = "Error adding mess order: " . mysqli_error($db);
    }
}

include("hel.php");
include('header_menu.php');
include('header.php');
include('sidebar.php');

?>

<div class="wrapper">
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Create Mess Order</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Create Mess Order</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Display message if set -->
            <?php if ($message) : ?>
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <!-- Add Order Form -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Add New Mess Order</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" method="post" action="">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="customer_id">Customer</label>
                            <select class="form-control select2" style="width: 100%;" id="customer_id" name="customer_id" required>
                                <option value="">Select Customer</option>
                                <?php while ($customer = mysqli_fetch_assoc($customers_result)) : ?>
                                    <option value="<?php echo $customer['customer_id']; ?>"><?php echo $customer['full_name']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="item_id">Item</label>
                            <select class="form-control select2" style="width: 100%;" id="item_id" name="item_id" required>
                                <option value="">Select Item</option>
                                <?php while ($item = mysqli_fetch_assoc($menu_items_result)) : ?>
                                    <option value="<?php echo $item['item_id']; ?>"><?php echo $item['item_name']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="quantity">Quantity</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Enter quantity" min="1" required>
                        </div>
                        <div class="form-group">
                            <label for="delivery_address">Delivery Address</label>
                            <input type="text" class="form-control" id="delivery_address" name="delivery_address" placeholder="Enter delivery address" required>
                        </div>
                        <div class="form-group">
                            <label for="delivery_time">Delivery Time</label>
                            <input type="datetime-local" class="form-control" id="delivery_time" name="delivery_time" required>
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary" name="submit">Create Order</button>
                    </div>
                </form>
            </div>
            <!-- /.box -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Add your footer here -->
    <?php include("footer.php"); ?>
</div>
<!-- ./wrapper -->

<!-- Add Select2 plugin -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize Select2 plugin
        $('.select2').select2();
    });
</script>
