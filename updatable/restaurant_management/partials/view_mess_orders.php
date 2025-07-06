<?php
session_start();

// Redirect to login page if user is not logged in
if (!isset($_SESSION['manager'])&&!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}

// Include database connection
include("../connection/connect.php");

// Include header, menu, and sidebar files
include("hel.php");
include('header_menu.php');
include('header.php');
include('sidebar.php');

// Fetch all mess orders for the logged-in restaurant
$rs_id = $_SESSION['rs_id'];
$orders_query = "SELECT * FROM mess_orders WHERE rs_id = $rs_id";
$orders_result = mysqli_query($db, $orders_query);

?>

<head>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
  <!-- Add DataTables Buttons CSS -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
  <style>
    .buttons-copy, .buttons-csv, .buttons-pdf, .buttons-print {
        background-color: green !important; /* Background color */
        color: white !important; /* Text color */
        border: none; /* Remove border */
    }
    /* Hover effect */
    .buttons-copy:hover, .buttons-csv:hover, .buttons-pdf:hover, .buttons-print:hover {
        background-color: darkgreen; /* Darker background color on hover */
    }
    
  </style>
</head>
<div class="wrapper">
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>View Mess Orders</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">View Mess Orders</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Mess Orders</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table id="messOrdersTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Customer ID</th>
                                <th>Item ID</th>
                                <th>Quantity</th>
                                <th>Order Date</th>
                                <th>Order Status</th>
                                <th>Delivery Address</th>
                                <th>Delivery Time</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($orders_result)) : ?>
                                <tr>
                                    <td><?php echo $row['order_id']; ?></td>
                                    <td><?php echo $row['customer_id']; ?></td>
                                    <td><?php echo $row['item_id']; ?></td>
                                    <td><?php echo $row['quantity']; ?></td>
                                    <td><?php echo $row['order_date']; ?></td>
                                    <td><?php echo $row['order_status']; ?></td>
                                    <td><?php echo $row['delivery_address']; ?></td>
                                    <td><?php echo $row['delivery_time']; ?></td>
                                    <td>
                                        <a href="edit_mess_order.php?rs_id=<?php echo $_SESSION['rs_id']; ?>&id=<?php echo $row['order_id']; ?>" class="btn btn-primary btn-xs" ><i style="font-size: 20px;" class="fa fa-pencil"></i></a>
                                        <a href="delete_mess_order.php?rs_id=<?php echo $_SESSION['rs_id']; ?>&id=<?php echo $row['order_id']; ?>" class="btn btn-danger btn-xs"><i style="font-size: 20px;" class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
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

<!-- Add your scripts here -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>

<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#messOrdersTable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'pdf', 'print'
            ]
        });
    });
</script>
</body>
</html>
