<?php
session_start();
$rs_id = $_SESSION['rs_id'];

// Check if the user is logged in
if (!isset($_SESSION['manager'])&&!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}

// Include database connection
include("../connection/connect.php");
if(isset($_GET['success']) && $_GET['success'] == 1) {
    echo "<script>alert('Order updated successfully');</script>";
}

// Fetch order details from the database
if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];
    $query = "SELECT * FROM users_orders WHERE o_id = '$order_id'";
    $result = mysqli_query($db, $query);
    $order = mysqli_fetch_assoc($result);
}

// Predefined remarks for the restaurant owner
$remarks = array("Order received, will be processed soon.", "Preparing your order, please wait.", "Order dispatched for delivery.", "Order delivered successfully.", "Customer feedback received.");

// Check if the form is submitted for updating order status
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['order_id']) && isset($_POST['status']) && isset($_POST['remark'])) {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];
    $remark = $_POST['remark'];

    // Update the order status in the database
    $update_query = "UPDATE users_orders SET status = '$status' WHERE o_id = '$order_id'";
    mysqli_query($db, $update_query);

    // Update the remark in the users_orders table
    $update_remark_query = "UPDATE remark SET remark = '$remark',status='$status' WHERE o_id = '$order_id'";
    mysqli_query($db, $update_remark_query);

    // Redirect to view_orders.php after updating
   
    header("Location: view_order.php?rs_id=$rs_id&&order_id=$order_id&success=1");
    exit();
}

// Include header files
include("hel.php");
include('header_menu.php');
include('header.php');
include('sidebar.php');
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Update Order
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <form role="form" action="" method="post">
                            <div class="form-group">
                                <label for="order_id">Order ID:</label>
                                <input type="text" class="form-control" id="order_id" name="order_id"
                                    value="<?php echo $order['o_id']; ?>" readonly>
                            </div>
                            <!-- Fetch dish details from the database -->
                            <?php
                            $dish_id = $order['d_id'];
                            $dish_query = "SELECT title, price FROM dishes WHERE d_id = '$dish_id'";
                            $dish_result = mysqli_query($db, $dish_query);
                            $dish_info = mysqli_fetch_assoc($dish_result);
                            ?>

                            <!-- Dish details -->
                            <div class="form-group">
                                <label for="dish_info">Dish Information:</label>
                                <textarea class="form-control" id="dish_info" name="dish_info" rows=4
                                    readonly><?php echo "Title: " . $dish_info['title'] . "\n" . "Price: " . $dish_info['price'] . "\nQuantity:" . $order["quantity"] . "\nTotal Price:" . $order["quantity"] * $dish_info['price']; ?></textarea>
                            </div>
                            <?php
                            $user_id = $order['u_id'];
                            $user_query = "SELECT * FROM users WHERE u_id = '$user_id'";
                            $user_result = mysqli_query($db, $user_query);
                            $user_info = mysqli_fetch_assoc($user_result);
                            ?>

                            <!-- User information -->
                            <div class="form-group">
                                <label for="user_info">User Information:</label>
                                <textarea rows="5" class="form-control" id="user_info" name="user_info"
                                    readonly><?php echo "Name: " . $user_info['f_name'] . " " . $user_info['l_name'] . "\n" . "Email: " . $user_info['email'] . "\n" . "Phone: " . $user_info['phone'] . "\n" . "Address: " . $user_info['address']; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="status">Status:</label>
                                <select class="form-control" id="status" name="status">


                                    <option value="in process" <?php if ($order['status'] == 'in process')
                                        echo 'selected'; ?>>in process</option>
                                    <option value="closed" <?php if ($order['status'] == 'closed')
                                        echo 'selected'; ?>>
                                        closed</option>
                                    <option value="rejected" <?php if ($order['status'] == 'rejected')
                                        echo 'selected'; ?>>rejected</option>
                                </select>
                            </div>


                            <!-- Remark dropdown -->
                            <div class="form-group">
                                <label for="remark">Remark:</label>
                                <select class="form-control" id="remark" name="remark">
                                    <option value="Thank you for your order.">Thank you for your order.</option>
                                    <option value="We appreciate your business.">We appreciate your business.</option>
                                    <option value="Thank you for choosing us.">Thank you for choosing us.</option>
                                    <option value="We value your patronage.">We value your patronage.</option>
                                    <option value="Your satisfaction is our priority.">Your satisfaction is our
                                        priority.</option>
                                </select>
                            </div>

                            <button type="submit" name="submit" class="btn btn-primary">Update Order</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include('footer.php'); ?>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>


</body>

</html>