<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Food Ordering System </title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animsition.min.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
    <link rel="stylesheet" href="path/to/style.css">
</head>

<body>
    <?php
    include("connection/connect.php");
    error_reporting(0);
    session_start();

    if (empty($_SESSION['user_id'])) {
        header('location: login.php');
    } else {
        $orderIdToShow = $_GET['order_id'];
        $userId = $_SESSION['user_id']; // Add this line to get the user ID from the session
    
        $query = mysqli_query($db, "SELECT users_orders.*, users.*
                            FROM users_orders
                            JOIN users ON users_orders.u_id = users.u_id
                            WHERE users_orders.o_id='$orderIdToShow' AND users_orders.u_id='$userId'");

        if (!$query) {
            die("Query Failed: " . mysqli_error($db));
        }

        $order = mysqli_fetch_assoc($query);
        ?>
        <div class="container my-3"
            style="border: 2px outset green;margin: auto; padding: auto;padding-left:35px;font-size:20px;">
            <header class="mt-1 text-right">
            </header>
            <div class="invoice mb-3">
                <div class="row mb-3 ">
                    <div class="col-6">
                        <h3 style="color:purple"><b>Online Restaurant Management System</b></h3>
                    </div>
                    <div class="col-6">
                        <!-- Your restaurant information -->
                    </div>
                    <table border="0">
                        <tr>
                            <td colspan="6">
                                <div class="col-6">
                                    <h3>INVOICE:</h3>
                                    <!-- Display customer information -->
                                    <p class="mb-0"><b>User Information:</b></p>
                                    <p class="mb-0"><b>User ID:</b>
                                        <?php echo $order['u_id']; ?>
                                    </p>
                                    <p class="mb-0"><b>Name:</b>
                                        <?php echo $order['f_name'] . " " . $order['l_name']; ?>
                                    </p>
                                    <p class="mb-0"><b>Email:</b>
                                        <?php echo $order['email'] ?>;
                                    <p class="mb-0"><b>Address:</b>
                                        <?php echo $order['address'] ?>;
                                </div>
                            </td>
                            <td colspan="6">
                                <div class="col-6">
                                    <br>
                                    <p class="mb-0"><b>Order Number:</b>
                                        <?php echo "#" . $order['o_id']; ?>
                                    </p>
                                    <?php $cDate = strtotime($order['success-date']); ?>
                                    <p class="mb-0"><b>Order Date:</b>
                                        <?php echo date('d-M-Y', $cDate); ?>
                                    </p>
                                    <p class="mb-0"><b>Payment Mode:</b> Cash On Delivery</p>
                                </div>
                            </td>
                        </tr>
                    </table>

                    <div class="col-12" style="width:100%">
                        <hr>
                        <table class="table responsive">
                            <thead class="bg-dark text-white">
                                <tr style="background-color:Gray;">

                                    <th>Dish</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>

                                    <td>
                                        <?php echo $order['title']; ?>
                                    </td>
                                    <td>
                                        <?php echo $order['quantity']; ?>
                                    </td>
                                    <td>
                                        <?php echo '₹' . $order['price']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="1"></td>
                                    <td class="font-weight-bold">Total</td>
                                    <td class="font-weight-bold">
                                        <?php echo '₹' . $order['price'] ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <hr class="my-4">
            <footer class="text-center">
                <a href="your_orders.php" id="backToOrdersLink" class="btn btn-sm btn-warning"
                    style="font-size:28px;padding-left:20px">
                    <i class="fas fa-angle-left"></i> Back to Orders
                </a>
                <button onclick="printReceipt()" id="printButton" style="color:white;background-color:magenta;font-size:30px;float:right;margin-right:20px;">Print Receipt</button>
                <center>
                    <p class="mb-0">Thank You For Your Orders and Choosing Us!</p>
                    <p>We Hope To See You Again</p>
                    <p>For terms & conditions Please visit www.onlinefoodierestro.com</p>
                </center>
            </footer>
        </div>
        <?php
    }
    ?>

<script>
    function printReceipt() {
        // Disable buttons before printing
        document.getElementById('printButton').disabled = true;
        document.getElementById('backToOrdersLink').disabled = true;

        // Add event listener for beforeprint
        window.addEventListener('beforeprint', function () {
            // Hide buttons before printing
            document.getElementById('printButton').style.display = 'none';
            document.getElementById('backToOrdersLink').style.display = 'none';
        });

        // Add event listener for afterprint
        window.addEventListener('afterprint', function () {
            // Show buttons after printing
            document.getElementById('printButton').style.display = 'inline';
            document.getElementById('backToOrdersLink').style.display = 'inline';

            // Enable buttons after printing
            document.getElementById('printButton').disabled = false;
            document.getElementById('backToOrdersLink').disabled = false;

            // Remove event listeners to avoid memory leaks
            window.removeEventListener('beforeprint', function () {});
            window.removeEventListener('afterprint', function () {});
        });

        // Print the invoice
        window.print();
    }
</script>

</body>

</html>