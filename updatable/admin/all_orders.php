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
    <style>
        /* Styles for the modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 60%;
            text-align: center;
        }

        /* Styles for buttons */
        .modal-btn {
            padding: 10px 20px;
            margin: 5px;
            cursor: pointer;
            border: none;
            border-radius: 4px;
        }

        .confirm-btn {
            background-color: #4CAF50;
            color: #fff;
        }

        .reject-btn {
            background-color: #f44336;
            color: #fff;
        }
    </style>
     <!-- WebSocket Integration for Admin -->
     <script>
    const socket = new WebSocket('ws://localhost:8080');

    socket.addEventListener('message', (event) => {
        const orderDataArray = JSON.parse(event.data);
        console.log('Order data array:', JSON.stringify(orderDataArray));

        orderDataArray.forEach(orderData => {
            console.log('Order received:', orderData);
            displayModal(orderData);
        });
    });

    function displayModal(orderData) {
        const modal = document.getElementById('myModal');
        const modalMessage = document.getElementById('modalMessage');

        modalMessage.innerHTML = `Order received:<br>` +
            `ID: ${orderData.id}<br>` +
            `Product: ${orderData.product}\<br>` +
            `Price: ${orderData.price}<br>` +
            `Quantity: ${orderData.quantity}<br>`;

        modal.style.display = 'block';
    }

    function confirmOrder() {
        // Handle confirm logic here
        closeModal();
    }

    function rejectOrder() {
        // Handle reject logic here
        closeModal();
    }

    function closeModal() {
        const modal = document.getElementById('myModal');
        modal.style.display = 'none';
    }
</script>
    <!-- Add your existing head section... -->



</head>

<body class="fix-header fix-sidebar">
<div id="myModal" class="modal">
    <div class="modal-content">
        <p id="modalMessage"></p>
        <button class="modal-btn confirm-btn" onclick="confirmOrder()">Confirm</button>
        <button class="modal-btn reject-btn" onclick="rejectOrder()">Reject</button>
        <button class="modal-btn" onclick="closeModal()">Close</button>
    </div>
</div>
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
        <div class="page-wrapper" style="height:1200px;background: #87CEFA">
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
                                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered">
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
                                      ORDER BY users_orders.o_id DESC";
                              

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
                                                            <?php
                                                            $status = $rows['status'];
                                                            if ($status == "" or $status == "NULL") {
                                                                ?>
                                                                <button type="button" class="btn btn-info"
                                                                    style="font-weight:bold;"><span class="fa fa-bars"
                                                                        aria-hidden="true">Dispatch</button>
                                                                <?php
                                                            }
                                                            if ($status == "in process") {
                                                                ?>
                                                                <button type="button" class="btn btn-warning"><span
                                                                        class="fa fa-cog fa-spin" aria-hidden="true"></span>On a
                                                                    Way!</button>
                                                                <?php
                                                            }
                                                            if ($status == "closed") {
                                                                ?>
                                                                <button type="button" class="btn btn-success"><span
                                                                        class="fa fa-check-circle"
                                                                        aria-hidden="true">Delivered</button>
                                                                <?php
                                                            }
                                                            if ($status == "rejected") {
                                                                ?>
                                                                <button type="button" class="btn btn-danger"> <i
                                                                        class="fa fa-close"></i>Cancelled</button>
                                                                <?php
                                                            }
                                                            ?>
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
    // Check if DataTable is already initialized on #example23
    if (!$.fn.dataTable.isDataTable('#example23')) {
        $('#example23').DataTable({
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