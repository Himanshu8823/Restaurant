<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['manager'])&&!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}
$rs_id=$_SESSION['rs_id'];
// Include database connection
include("../connection/connect.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product']) && isset($_POST['type']) && isset($_POST['quantity']) && isset($_POST['date'])) {
    // Retrieve data from the form
    $product_id = $_POST['product'];
    $type = $_POST['type'];
    $quantity = $_POST['quantity'];
    $date = $_POST['date'];
    $notes = $_POST['notes'];

    // Insert data into the database
    $insert_query = "INSERT INTO inventory_transactions (product_id, transaction_type, quantity, transaction_date,rs_id, notes) VALUES ('$product_id', '$type', '$quantity', '$date','$rs_id', '$notes')";

    if (mysqli_query($db, $insert_query)) {
        // Transaction recorded successfully
        echo "<script>alert('Transaction recorded successfully');</script>";
    } else {
        // Error recording transaction
        echo "<script>alert('Error recording transaction');</script>";
    }
}

include("hel.php");
include('header_menu.php');
include('header.php');
include('sidebar.php');
?>

<div class="wrapper">

    <!-- Add your header and sidebar here -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Record Transaction</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Record Transaction</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-md-12 col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Enter Transaction Details</h3>
                        </div>
                        <form role="form" action="" method="post">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="product">Product</label>
                                    <select class="form-control" id="product" name="product">
                                        <option value="">Select Product</option>
                                        <!-- Fetch product options from database -->
                                        <?php
                                        $product_query = "SELECT * FROM inventory_products";
                                        $product_result = mysqli_query($db, $product_query);
                                        while ($row = mysqli_fetch_assoc($product_result)) {
                                            echo "<option value='" . $row['product_id'] . "'>" . $row['title'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="type">Transaction Type</label>
                                    <select class="form-control" id="type" name="type">
                                        <option value="income">Income</option>
                                        <option value="expense">Expense</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="quantity">Quantity</label>
                                    <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Enter quantity" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label for="date">Transaction Date</label>
                                    <input type="date" class="form-control" id="date" name="date" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label for="notes">Notes</label>
                                    <textarea class="form-control" id="notes" name="notes" placeholder="Enter notes"></textarea>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <button type="submit" class="btn btn-success">Record Transaction</button>
                                <a href="#" class="btn btn-danger">Cancel</a>
                            </div>
                        </form>
                    </div>
                    <!-- /.box -->
                </div>
                <!-- col-md-12 -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Add your footer here -->

</div>
<!-- ./wrapper -->

<!-- Add your scripts here -->

</body>
</html>
