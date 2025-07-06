<?php
session_start();

// Redirect to login page if user is not logged in
if (!isset($_SESSION['manager'])&&!isset($_SESSION['username'])&&!isset($_SESSION['cashier'])) {
    header("Location: ../login.php");
    exit();
}

// Include database connection
include("../connection/connect.php");

// Fetch all mess customers for the logged-in restaurant
$rs_id = $_SESSION['rs_id'];
$customers_query = "SELECT * FROM mess_customers WHERE rs_id = $rs_id";
$customers_result = mysqli_query($db, $customers_query);

include("hel.php");
include('header_menu.php');
include('header.php');
include('sidebar.php');

?>

<head>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <!-- Add DataTables Buttons CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
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
            <h1>View Mess Customers</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">View Mess Customers</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Display mess customers in a table -->
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Mess Customers</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body table-responsive">
                            <table id="customersTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Customer ID</th>
                                        <th>Username</th>
                                        <th>Full Name</th>
                                        <th>Email</th>
                                        <th>Phone Number</th>
                                        <th>Address</th>
                                        <th>Registration Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Display mess customers fetched from the database
                                    while ($row = mysqli_fetch_assoc($customers_result)) {
                                        echo "<tr>";
                                        echo "<td>" . $row['customer_id'] . "</td>";
                                        echo "<td>" . $row['username'] . "</td>";
                                        echo "<td>" . $row['full_name'] . "</td>";
                                        echo "<td>" . $row['email'] . "</td>";
                                        echo "<td>" . $row['phone_number'] . "</td>";
                                        echo "<td>" . $row['customer_address'] . "</td>";
                                        echo "<td>" . $row['registration_date'] . "</td>";
                                        echo "</tr>";
                                    }
                                    ?>
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
        $('#customersTable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'pdf', 'print'
            ]
        });
    });
</script>
</body>
</html>
