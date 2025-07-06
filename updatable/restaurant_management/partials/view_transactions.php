<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['manager'])&&!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}


// Include database connection
include("../connection/connect.php");

$rs_id=$_SESSION['rs_id'];

// Fetch transaction data from the database with joins
$sql = "SELECT t.transaction_id, t.transaction_type, t.quantity, t.transaction_date, t.notes, p.title AS product_name 
        FROM inventory_transactions t 
        LEFT JOIN inventory_products p ON t.product_id = p.product_id";
$result = mysqli_query($db, $sql);

// Prepare data array
$transactions = array();
while ($row = mysqli_fetch_assoc($result)) {
    $transactions[] = $row;
}
include("hel.php");
include('header_menu.php');
include('header.php');
include('sidebar.php');

?>

<head>
    <!-- Add DataTables CSS -->
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

    <!-- Add your header and sidebar here -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>View Transactions</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">View Transactions</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-md-12 col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">List of Transactions</h3>
                        </div>
                        <div class="box-body table-responsive">
                            <table id="transactionTable" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Transaction ID</th>
                                        <th>Product Name</th>
                                        <th>Transaction Type</th>
                                        <th>Quantity</th>
                                        <th>Transaction Date</th>
                                        <th>Notes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($transactions as $transaction) : ?>
                                        <tr>
                                            <td><?php echo $transaction['transaction_id']; ?></td>
                                            <td><?php echo $transaction['product_name']; ?></td>
                                            <td><?php echo $transaction['transaction_type']; ?></td>
                                            <td><?php echo $transaction['quantity']; ?></td>
                                            <td><?php echo $transaction['transaction_date']; ?></td>
                                            <td><?php echo $transaction['notes']; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.box-body -->
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
<!-- Add jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Add DataTables JS -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<!-- Add DataTables Buttons JS -->
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>

<!-- Initialize DataTable with buttons -->
<script type="text/javascript">
    $(document).ready(function() {
        // Initialize DataTable with buttons
        $('#transactionTable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'pdf', 'print'
            ]
        });
    });
</script>

</body>
</html>
