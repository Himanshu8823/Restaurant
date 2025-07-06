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

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Retrieve data from the form
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $is_available = isset($_POST['is_available']) ? 1 : 0; // Check if item is available
    $rs_id = $_SESSION['rs_id']; // Get restaurant ID from session

    // Insert data into the database
    $insert_query = "INSERT INTO mess_menu_items (rs_id, item_name, item_description, item_price, item_category, is_available) 
                        VALUES ('$rs_id', '$name', '$description', '$price', '$category', '$is_available')";

    if (mysqli_query($db, $insert_query)) {
        // Item added successfully
        $message = "Menu item added successfully";
    } else {
        // Error adding item
        $message = "Error adding menu item: " . mysqli_error($db);
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
            <h1>Manage Menu Items</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Manage Menu Items</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Display message if set -->
            <?php if ($message): ?>
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <!-- Add Menu Item Form -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Add New Menu Item</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" method="post" action="">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="name">Item Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter item name"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <input type="text" class="form-control" id="description" name="description"
                                placeholder="Enter item description" required>
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" class="form-control" id="price" name="price" placeholder="Enter price"
                                min="0.01" step="0.01" required>
                        </div>
                        <div class="form-group">
                            <label for="category">Category</label>
                            <input type="text" class="form-control" id="category" name="category"
                                placeholder="Enter category" required>
                        </div>
                        <div class="form-group">
                            <label for="is_available">Available</label>
                            <input type="checkbox" id="is_available" name="is_available" value="1" checked>
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary" name="submit">Add Item</button>
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