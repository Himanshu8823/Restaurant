<!DOCTYPE html>
<html lang="en">

<?php
include("../connection/connect.php");
error_reporting(0);
session_start();
?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <title>Ela - Bootstrap Admin Dashboard Template</title>
    <link href="css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="css/helper.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
    <!-- WebSocket Integration for Admin -->
   <!-- Add this script to your HTML file -->
<script>
    const socket = new WebSocket('ws://localhost:8080');

    // Connection opened
    socket.addEventListener('open', (event) => {
        console.log('WebSocket connection opened:', event);
    });

    // Listen for messages from the ordering page
    socket.addEventListener('message', (event) => {
        console.log('Order received:', event.data);

        // Update the table content
        updateTable();
    });

    // Connection closed
    socket.addEventListener('close', (event) => {
        console.log('WebSocket connection closed:', event);
    });

    // Function to update the table content
    function updateTable() {
        // Use AJAX to fetch the updated data from the server
        $.ajax({
            url: 'get_pending_orders.php', // Replace with the actual URL to fetch data
            method: 'GET',
            success: function (data) {
                // Replace the table content with the updated data
                $('#example23').DataTable().destroy(); // Destroy the DataTable instance
                $('#example23 tbody').html(data); // Update the table body
                $('#example23').DataTable(); // Reinitialize the DataTable
            },
            error: function (xhr, status, error) {
                console.error('Error fetching data:', error);
            }
        });
    }
</script>


    <!-- Add your existing head section... -->



</head>

<body class="fix-header fix-sidebar">
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
        </svg>
    </div>
    <div id="main-wrapper">
        <!-- Navigation -->
        <?php include("header.php"); ?>
        <!-- End Left Sidebar -->

        <!-- Page wrapper  -->
        <div class="page-wrapper">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary">Dashboard</h3>
                </div>
            </div>

            <div class="container-fluid" style="background: #87CEFA">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">All user Orders</h4>
                                <h6 class="card-subtitle">Export data to Copy, CSV, Excel, PDF & Print</h6>
                                <div class="table-responsive m-t-40">
                                    <table id="example23"
                                        class="display nowrap table table-hover table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Username</th>
                                                <th>Title</th>
                                                <th>Quantity</th>
                                                <th>Price</th>
                                                <th>Address</th>
                                                <th>Status</th>
                                                <th>Reg-Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql = "SELECT users.*, users_orders.* 
                                            FROM users 
                                            INNER JOIN users_orders ON users.u_id = users_orders.u_id  
                                            WHERE users_orders.status = '' OR users_orders.status IS NULL
                                            ORDER BY users_orders.date DESC";
                                    
                                            $query = mysqli_query($db, $sql);

                                            if (!mysqli_num_rows($query) > 0) {
                                                echo '<td colspan="8"><center>No Orders-Data!</center></td>';
                                            } else {
                                                while ($rows = mysqli_fetch_array($query)) {
                                                    ?>
                                                    <tr data-order-id="<?php echo $rows['o_id']; ?>">
                                                        <td>
                                                            <?php echo $rows['username']; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $rows['title']; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $rows['quantity']; ?>
                                                        </td>
                                                        <td>Rs
                                                            <?php echo $rows['price']; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $rows['address']; ?>
                                                        </td>
                                                        <td class="status-cell">
                                                            <button type="button" class="btn btn-info"
                                                                style="font-weight:bold;"><span class="fa fa-bars"
                                                                    aria-hidden="true">Dispatch
                                                            </button>

                                                        </td>
                                                        <td>
                                                            <?php echo $rows['date']; ?>
                                                        </td>
                                                        <td>
                                                            <a href="delete_orders.php?order_del=<?php echo $rows['o_id']; ?>"
                                                                onclick="return confirm('Are you sure?');"
                                                                class="btn btn-danger btn-flat btn-addon btn-xs m-b-10"><i
                                                                    class="fa fa-trash-o" style="font-size:16px"></i></a>
                                                            <a href="view_order.php?user_upd=<?php echo $rows['o_id']; ?>"
                                                                class="btn btn-info btn-flat btn-addon btn-sm m-b-10 m-l-5"><i
                                                                    class="ti-settings"></i></a>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include("footer.php"); ?>
        </div>
    </div>
    <script src="js/lib/jquery/jquery.min.js"></script>
    <script src="js/lib/bootstrap/js/popper.min.js"></script>
    <script src="js/lib/bootstrap/js/bootstrap.min.js"></script>
    <script src="js/jquery.slimscroll.js"></script>
    <script src="js/sidebarmenu.js"></script>
    <script src="js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <script src="js/custom.min.js"></script>
    <script src="js/lib/datatables/datatables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
    <script src="js/lib/datatables/datatables-init.js"></script>
    <!-- Initialize DataTables with export options -->
    <script>
        $(document).ready(function () {
            // Check if DataTable is already initialized on #myTable
            if (!$.fn.dataTable.isDataTable('#myTable')) {
                $('#myTable').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ]
                });
            }
        });
    </script>
</body>

</html>