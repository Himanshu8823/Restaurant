<?php

session_start();
include("../connection/connect.php");

if (!isset($_SESSION['manager'])&&!isset($_SESSION['username'])&&!isset($_SESSION['cashier'])) {
    header("Location: ../login.php");
    exit();
}

// Fetch current restaurant's rs_id
$rs_id = $_SESSION['rs_id'];

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['remove_order'])) {
    $order_id = $_POST['order_id'];

    // Prepare and execute SQL statement to remove the order
    $sql = "DELETE FROM offline_orders WHERE order_id = ? AND rs_id = ?";
    $stmt = mysqli_prepare($db, $sql);

    if ($stmt) {
        // Bind parameters and execute the statement
        mysqli_stmt_bind_param($stmt, "ii", $order_id, $rs_id);
        mysqli_stmt_execute($stmt);

        // Check if any rows affected
        if (mysqli_stmt_affected_rows($stmt) > 0) {
            // Redirect with success message
            header("location: orders_show.php?rs_id=$rs_id&success=1");
            exit();
        } else {
            // Redirect with error message
            header("location: orders_show.php?rs_id=$rs_id&error=1");
            exit();
        }
    } else {
        // Redirect with error message if statement preparation fails
        header("location: orders_show.php?rs_id=$rs_id&error=1");
        exit();
    }
}

// Fetch orders from the database for the current restaurant only
$sql = "SELECT o.order_id, d.title AS dish_name, o.order_date, o.quantity, o.gross_amount, o.discount, o.net_amount, o.status, o.name
        FROM offline_orders o 
        JOIN dishes d ON o.d_id = d.d_id
        WHERE o.rs_id = ?
        ORDER BY o.order_date DESC";

$stmt = mysqli_prepare($db, $sql);
mysqli_stmt_bind_param($stmt, "i", $rs_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Check if the query executed successfully and returned results
if (!$result) {
    // Redirect with error message if query failed
    header("location: orders_show.php?rs_id=$rs_id&error=1");
    exit();
}

include("hel.php");
include('header_menu.php');
include('header.php');
include('sidebar.php');

?>


<head>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <!-- Add DataTables Buttons CSS -->
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
    <style>
        .buttons-copy,
        .buttons-csv,
        .buttons-pdf,
        .buttons-print,.buttons-excel {
            background-color: green !important;
            /* Background color */
            color: white !important;
            /* Text color */
            border: none;
            /* Remove border */
        }

        /* Hover effect */
        .buttons-copy:hover,
        .buttons-csv:hover,
        .buttons-pdf:hover,
        .buttons-print:hover ,.buttons-excel{
            background-color: darkgreen;
            /* Darker background color on hover */
        }
    </style>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Manage
                <small>Orders</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Orders</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-md-12 col-xs-12">

                    <div id="messages"></div>

                    <?php if (isset($_GET['success']) && $_GET['success'] == 1) { ?>
                        <!-- Success message -->
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                            Order removed successfully.
                        </div>
                    <?php } elseif (isset($_GET['error']) && $_GET['error'] == 1) { ?>
                        <!-- Error message -->
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                            Error occurred. Unable to remove order.
                        </div>
                    <?php } ?>

                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Manage Orders</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body table-responsive">
                            <table id="manageTable" class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>                                        
                                        <th>Customer Name</th>
                                        <th>Dish Name</th>
                                        <th>Quantity</th>
                                        <th>Gross Amount</th>
                                        <th>Discount</th>
                                        <th>Net Amount</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                        <th>Order Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                        <tr>                                            
                                            <td>
                                                <?php echo $row['name']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['dish_name']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['quantity']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['gross_amount']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['discount']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['net_amount']; ?>
                                            </td>
                                            
                                            <td>
                                                <?php if($row['status']=="unpaid")
                                                {
                                                    echo "<span class='btn btn-danger'><i class='fa fa-bell'></i></span>";
                                                }
                                                    else{
                                                        echo "<span class='btn btn-success'><i class='fa fa-check'></i></span>";
                                                    }
                                                ?>
                                            </td>
                                            <td>
                                            <a href="print_receipt.php?rs_id=<?php echo $rs_id; ?>&order_id=<?php echo $row['order_id']; ?>" class="btn btn-info" target="_blank" style="font-size:16px"><i class="fa fa-print"></i></a>
                                                <a href="edit_offline_order.php?rs_id=<?php echo $rs_id; ?>&id=<?php echo $row['order_id']; ?>"
                                                    class="btn btn-primary btn-sm" style="font-size:16px"><i class="fa fa-pencil"></i></a>
                                                <form method="post" style="display:inline-block;"
                                                    onsubmit="return confirm('Are you sure you want to remove this order?');">
                                                    <input type="hidden" name="order_id"
                                                        value="<?php echo $row['order_id']; ?>">
                                                    <button type="submit" name="remove_order"
                                                        class="btn btn-danger btn-sm" style="font-size:16px"><i class="fa fa-trash"></i>
                                                        </button>
                                                </form>
                                            </td>
                                            <td>
                                                <?php echo $row['order_date']; ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
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

    <?php include('footer.php'); ?>
<!-- Add your scripts here -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.7.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
<!-- Add Select2 JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#manageTable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
        });
    </script>
