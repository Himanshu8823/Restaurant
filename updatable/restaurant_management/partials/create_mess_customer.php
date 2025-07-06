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
    $rs_id = $_SESSION['rs_id'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password_md5 = md5($password); // MD5 hash the password
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $customer_address = $_POST['customer_address'];
    $registration_date = date("Y-m-d");

    // Insert data into the database
    $insert_query = "INSERT INTO mess_customers (rs_id, username, password_hash, full_name, email, phone_number, customer_address, registration_date) 
                     VALUES ('$rs_id', '$username', '$password_md5', '$full_name', '$email', '$phone_number', '$customer_address', '$registration_date')";

    if (mysqli_query($db, $insert_query)) {
        // Customer added successfully
        $message = "Mess customer added successfully";
    } else {
        // Error adding customer
        $message = "Error adding mess customer: " . mysqli_error($db);
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
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Create Mess Customer</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Create Mess Customer</li>
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

            <!-- Add Customer Form -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Add New Mess Customer</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" method="post" action="">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
                        </div>
                        <div class="form-group">
                            <label for="full_name">Full Name</label>
                            <input type="text" class="form-control" id="full_name" name="full_name" placeholder="Enter full name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
                        </div>
                        <div class="form-group">
                            <label for="phone_number">Phone Number</label>
                            <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Enter phone number" required>
                        </div>
                        <div class="form-group">
                            <label for="customer_address">Customer Address</label>
                            <input type="text" class="form-control" id="customer_address" name="customer_address" placeholder="Enter customer address" required>
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary" name="submit">Create Customer</button>
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
