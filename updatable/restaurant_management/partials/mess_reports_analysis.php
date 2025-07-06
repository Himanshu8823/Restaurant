<?php
session_start();

// Redirect to login page if user is not logged in
if (!isset($_SESSION['manager'])&&!isset($_SESSION['username'])&&!isset($_SESSION['cashier'])) {
    header("Location: ../login.php");
    exit();
}

// Include database connection
include("../connection/connect.php");

// Fetch the restaurant ID from session
$rs_id = $_SESSION['rs_id'];

// Fetch total number of orders
$total_orders_query = "SELECT COUNT(*) AS total_orders FROM mess_orders WHERE rs_id = $rs_id";
$total_orders_result = mysqli_query($db, $total_orders_query);
$total_orders = mysqli_fetch_assoc($total_orders_result)['total_orders'];

// Fetch total revenue
$total_revenue_query = "SELECT SUM(quantity * item_price) AS total_revenue FROM mess_orders 
                        JOIN mess_menu_items ON mess_orders.item_id = mess_menu_items.item_id
                        WHERE mess_orders.rs_id = $rs_id";
$total_revenue_result = mysqli_query($db, $total_revenue_query);
$total_revenue = mysqli_fetch_assoc($total_revenue_result)['total_revenue'];

// Fetch orders by status
$orders_by_status_query = "SELECT order_status, COUNT(*) AS num_orders FROM mess_orders 
                           WHERE rs_id = $rs_id GROUP BY order_status";
$orders_by_status_result = mysqli_query($db, $orders_by_status_query);
$orders_by_status = [];
while ($row = mysqli_fetch_assoc($orders_by_status_result)) {
    $orders_by_status[$row['order_status']] = $row['num_orders'];
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
            <h1>Mess Reports Analysis</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Mess Reports Analysis</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-4">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Total Orders</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <h2><?php echo $total_orders; ?></h2>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->

                <div class="col-md-4">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Total Revenue</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <h2><?php echo '₹' . number_format($total_revenue, 2); ?></h2>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row">
                <div class="col-md-6">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Orders by Status</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Status</th>
                                        <th>Number of Orders</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($orders_by_status as $status => $num_orders) : ?>
                                        <tr>
                                            <td><?php echo $status; ?></td>
                                            <td><?php echo $num_orders; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Add your footer here -->
    <?php include("footer.php"); ?>
</div>
<!-- ./wrapper -->
