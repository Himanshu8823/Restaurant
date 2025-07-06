<?php
session_start();

// Redirect to login page if user is not logged in
if (!isset($_SESSION['manager'])&&!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}

// Include database connection
include("../connection/connect.php");

// Fetch all payments for the current restaurant with customer names
$rs_id = $_SESSION['rs_id'];
$payments_query = "SELECT p.payment_id, c.full_name AS customer_name, p.payment_date, p.payment_status, p.payment_amount 
                    FROM payments p 
                    INNER JOIN mess_customers c ON p.customer_id = c.customer_id 
                    WHERE c.rs_id = $rs_id";
$payments_result = mysqli_query($db, $payments_query);

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
            <h1>View Payments</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">View Payments</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">All Payments</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="paymentsTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Payment ID</th>
                                <th>Customer Name</th>
                                <th>Payment Date</th>
                                <th>Payment Amount</th>
                                <th>Payment Status</th>   
                                <th>Action</th>
                             
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($payments_result)) : ?>
                                <tr>
                                    <td><?php echo $row['payment_id']; ?></td>
                                    <td><?php echo $row['customer_name']; ?></td>
                                    <td><?php echo $row['payment_date']; ?></td>
                                    <td><?php echo $row['payment_amount']; ?></td>
                                    <td><?php echo $row['payment_status']; ?></td>
                                    <td><a class="btn btn-success" href="generate_receipt.php?rs_id=<?php echo $rs_id?>&payment_id=<?php echo $row['payment_id']; ?>" target="_blank">Generate Receipt</a></td>                          
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

    <!-- Include your footer -->
    <?php include("footer.php"); ?>
</div>
<!-- ./wrapper -->

<!-- Add DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

<!-- Add DataTables Buttons CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">

<!-- Add Select2 CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">

<!-- Add your custom styles here -->
<style>
    .buttons-copy,
    .buttons-csv,
    .buttons-pdf,
    .buttons-print {
        background-color: green !important;
        color: white !important;
        border: none;
    }

    .buttons-copy:hover,
    .buttons-csv:hover,
    .buttons-pdf:hover,
    .buttons-print:hover {
        background-color: darkgreen;
    }
</style>

<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<!-- Include DataTables JS -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<!-- Include DataTables Buttons JS -->
<script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>

<!-- Include Select2 JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<!-- Initialize DataTable -->
<script>
    $(document).ready(function() {
        $('#paymentsTable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'pdf', 'print'
            ]
        });
    });
</script>

<!-- Initialize Select2 -->
<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>

</body>
</html>
`