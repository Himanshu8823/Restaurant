<!DOCTYPE html>
<html lang="en">
<?php
include("connection/connect.php");
error_reporting(0);
session_start();

if (empty($_SESSION['user_id'])) {
    header('location:login.php');
} else {
    ?>

    <head>
        <!-- Add your head content here -->
        <style>
            .page-wrapper {
                font-size: 20px;
                color: black;
                padding-top: 0px;
            }
        </style>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="#">
        <title>Starter Template for Bootstrap</title>
        <!-- Bootstrap core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/font-awesome.min.css" rel="stylesheet">
        <link href="css/animsition.min.css" rel="stylesheet">
        <link href="css/animate.css" rel="stylesheet">
        <!-- Custom styles for this template -->
        <link href="css/style.css" rel="stylesheet">
        <style type="text/css" rel="stylesheet">
            
        </style>
    </head>

    <body style="background-image: url('images/background_image.gif') !important;">
        <?php
        include("header.php");
        ?>
        <div class="page-wrapper">
            <!-- Inner page hero -->
            <div class="inner-page-hero bg-image" data-image-src="https://live.staticflickr.com/1972/44129810855_56f6e449c5_b.jpg">
                <div class="container"> </div>
            </div>

            <!-- Results show -->
            <div class="container mt-3" style="background-color:skyblue">
                <?php if (!empty($_SESSION['success_msg'])): ?>
                    <div class="alert alert-success">
                        <?php echo $_SESSION['success_msg']; ?>
                    </div>
                <?php endif ?>
                <?php if (!empty($_SESSION['error_msg'])): ?>
                    <div class="alert alert-danger">
                        <?php echo $_SESSION['error_msg']; ?>
                    </div>
                <?php endif ?>

                <!-- Tabs -->
                <ul class="nav nav-tabs" id="myTabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="currentOrders-tab" data-toggle="tab" href="#currentOrders" role="tab"
                            aria-controls="currentOrders" aria-selected="true">Current Orders</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="previousOrders-tab" data-toggle="tab" href="#previousOrders" role="tab"
                            aria-controls="previousOrders" aria-selected="false">Completed Orders</a>
                    </li>

                </ul>
                <!-- Add the search input field -->
                <div class="form-group" style="padding-left:3%">
                    <label for="orderSearch">Search:</label>
                    <input type="text" class="form-control" id="orderSearch" placeholder="Enter keywords" style="width:30%">
                </div>

                <div class="tab-content mt-2">
                    <!-- Current Orders Tab -->
                    <div class="tab-pane fade show active in" id="currentOrders" role="tabpanel"
                        aria-labelledby="currentOrders-tab">
                        <div class="container shadow-container">
                            <h2 class="text-center">Current Orders</h2>
                            <div class="table-responsive-sm">
                                <table class="table table-bordered table-hover table-striped" id="ordersTable">
                                    <!-- ... (your existing table structure) -->
                                    <tbody id="myTable">
                                        <?php
                                        $query_res = mysqli_query($db, "SELECT * FROM users_orders WHERE u_id='$user_id' ORDER BY date DESC");
                                        if (!empty($query_res) && mysqli_num_rows($query_res) > 0):
                                            while ($row = mysqli_fetch_array($query_res)):
                                                $status = $row['status'];
                                                if (empty($status) || $status == "NULL" || $status == "in process" || $status == "rejected"):
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo $row['title']; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $row['quantity']; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo '$' . $row['price']; ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            if (empty($status) || $status == "NULL") {
                                                                echo '<button type="button" class="btn  btn-secondary cancel" style="font-weight:bold;background-color:lightyellow"><i class="fas fa-bars"></i> Dispatch</button>';
                                                            } elseif ($status == "in process") {
                                                                echo '<button type="button" class="btn cancel btn-warning" style="background-color:orange"><span class="fa fa-cog fa-spin" aria-hidden="true"></span> On Your Way!</button>';
                                                            } elseif ($status == "rejected") {
                                                                    echo '<button type="button" class="btn btn-danger cancel" style="background-color:magenta"> <i class="far fa-times-circle"></i> Cancelled</button>';
                                                            }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $row['date']; ?>
                                                        </td>
                                                        <td>
                                                            <a href="javascript:void(0);"
                                                                onclick="deleteOrder(<?php echo $row['o_id']; ?>)"
                                                                class="btn btn-danger" style="font-size:20px;background-color:red;"><i
                                                                    class="fas fa-trash-alt"></i> Cancel</a>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                endif;
                                            endwhile;

                                            // Rewind the result set
                                            mysqli_data_seek($query_res, 0);

                                        else:
                                            ?>
                                            <tr>
                                                <td colspan="6">Records not found</td>
                                            </tr>
                                            <?php
                                        endif;
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Previous Orders Tab -->
                    <div class="tab-pane fade" id="previousOrders" role="tabpanel" aria-labelledby="previousOrders-tab">
                        <div class="container shadow-container">
                            <h2 class="text-center">Completed Orders</h2>
                            <div class="table-responsive-sm">
                                <table class="table table-bordered table-hover table-striped">
                                    <!-- ... (your existing table structure) -->
                                    <tbody id="myTable">
                                        <?php
                                        if (!empty($query_res) && mysqli_num_rows($query_res) > 0):
                                            while ($row = mysqli_fetch_array($query_res)):
                                                $status = $row['status'];
                                                if ($status == "closed"):
                                                    ?>
                                                    <tr>
                                                        <?php $cDate = strtotime($row['date']); ?>
                                                        <td>
                                                            <?php echo date('d-M-Y', $cDate); ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $row['title']; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $row['quantity']; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo '₹ ' . $row['price']; ?>
                                                        </td>
                                                        <td> <button type="button" class="btn btn-success"
                                                                style="font-size:20px;background-color:green;"><i
                                                                    class="fas fa-check"></i> Delivered</button>
                                                        <td><a href="invoice.php?order_id=<?php echo $row['o_id']; ?>"
                                                                class="btn btn-info" style="font-size:20px;background-color:#1F51FF;"><i
                                                                    class="fas fa-file-alt"></i> Invoice</a></td>

                                                    </tr>
                                                    <?php
                                                endif;
                                            endwhile;
                                        else:
                                            ?>
                                            <tr>
                                                <td colspan="5">Records not found</td>
                                            </tr>
                                            <?php
                                        endif;
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include('footer.php'); ?>

        <!-- Bootstrap core JavaScript -->
        <script src="js/jquery.min.js"></script>
        <script src="js/tether.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/animsition.min.js"></script>
        <script src="js/bootstrap-slider.min.js"></script>
        <script src="js/jquery.isotope.min.js"></script>
        <script src="js/headroom.js"></script>
        <script src="js/foodpicky.min.js"></script>
        <!-- WebSocket Connection Script -->
        <script>
            const socket = new WebSocket('ws://localhost:8080');

            // Connection opened
            socket.addEventListener('open', (event) => {
                console.log('WebSocket connection opened:', event);
            });

            // Listen for messages from the server
            socket.addEventListener('message', (event) => {
                console.log('Message from server:', event.data);

                // Trigger table refresh when a message is received
                refreshTable();
            });

            // Connection closed
            socket.addEventListener('close', (event) => {
                console.log('WebSocket connection closed:', event);
            });

            function refreshTable() {
                // Use AJAX to fetch updated data from the server
                $.ajax({
                    url: 'fetch_updated_data.php', // Replace with your server endpoint
                    type: 'GET',
                    success: function (data) {
                        // Update the table content with the fetched data
                        $('#ordersTable').html(data);
                    },
                    error: function (xhr, status, error) {
                        console.error('Error fetching data:', error);
                    }
                });
            }
        </script>
        <script>
            $(document).ready(function () {
                // Live search functionality
                $('#orderSearch').on('input', function () {
                    var searchValue = $(this).val().toLowerCase();
                    $('#myTable tr').filter(function () {
                        $(this).toggle($(this).text().toLowerCase().indexOf(searchValue) > -1);
                    });
                });

            });
            function deleteOrder(id) {
                if (confirm("Are you sure you want to cancel this order?")) {
                    window.location.href = 'delete_orders.php?order_del=' + id;
                }
            }
        </script>
        <style>
            .cancel {
                font-size: 20px;
                background-color: gray;
            }
        </style>

    </body>

    </html>
    <?php
}
?>