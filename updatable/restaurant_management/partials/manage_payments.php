<?php
session_start();

// Redirect to login page if user is not logged in
if (!isset($_SESSION['manager'])&&!isset($_SESSION['username'])&&!isset($_SESSION['cashier'])) {
    header("Location: ../login.php");
    exit();
}

// Include database connection
include("../connection/connect.php");

// Fetch all customers for managing payments
$rs_id = $_SESSION['rs_id'];
$customers_query = "SELECT * FROM mess_customers WHERE rs_id = $rs_id";
$customers_result = mysqli_query($db, $customers_query);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Retrieve payment details from the form
    $customer_id = $_POST['customer_id'];
    $payment_date = $_POST['payment_date'];
    $payment_status = $_POST['payment_status'];
    $payment_amount = $_POST['payment_amount'];

    // Insert payment record into the database
    $payment_query = "INSERT INTO payments (customer_id, payment_date, payment_status, payment_amount) 
                      VALUES ($customer_id, '$payment_date', '$payment_status', $payment_amount)";
    mysqli_query($db, $payment_query);

    // Redirect back to manage_payments.php after adding payment
    header("Location: manage_payments.php?rs_id=$rs_id");
    exit();
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
            <h1>Manage Payments</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Manage Payments</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Add Payment</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <form method="post" action="">
                        <div class="form-group">
                            <label for="customer_id">Customer</label>
                            <select class="form-control" id="customer_id" name="customer_id" required>
                                <?php while ($row = mysqli_fetch_assoc($customers_result)) : ?>
                                    <option value="<?php echo $row['customer_id']; ?>"><?php echo $row['full_name']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="payment_date">Payment Date</label>
                            <input type="date" class="form-control" id="payment_date" name="payment_date" required>
                        </div>
                        <div class="form-group">
                            <label for="payment_status">Payment Status</label>
                            <select class="form-control" id="payment_status" name="payment_status" required>
                                <option value="Pending">Pending</option>
                                <option value="Paid">Paid</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="payment_amount">Payment Amount</label>
                            <input type="number" class="form-control" id="payment_amount" name="payment_amount" required>
                        </div>
                        <button type="submit" class="btn btn-primary" name="submit">Add Payment</button>
                    </form>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Include your footer -->
    <?php include("footer.php"); ?>
</div>
<!-- ./wrapper -->

<!-- Add Select2 JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<!-- Initialize Select2 -->
<script>
    $(document).ready(function() {
        $('#customer_id').select2();
    });
</script>

</body>
</html>
