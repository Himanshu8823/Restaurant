<?php
session_start();
include("../connection/connect.php");

if (!isset($_SESSION['manager'])&&!isset($_SESSION['username'])&&!isset($_SESSION['cashier'])) {
    // Redirect to login page if session is not set
    header("Location: ../login.php");
    exit();
}

$rs_id = $_SESSION['rs_id'];

// Fetch order ID from GET parameter
if (isset($_GET['id'])) {
    $order_id = $_GET['id'];

    // Initialize $order variable
    $order = array();

    // Fetch order details from the database using SQL join
    $sql = "SELECT o.order_id, o.order_date, o.gross_amount, o.discount, o.net_amount, d.title AS dish_name, d.price, o.quantity
            FROM offline_orders o 
            JOIN dishes d ON o.d_id = d.d_id
            WHERE o.order_id = ? LIMIT 1";
    $stmt = mysqli_prepare($db, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $order_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            $order = mysqli_fetch_assoc($result);
        } else {
            // Redirect with error message if order not found
            header("location: orders_show.php?rs_id=$rs_id&error=1");
            exit();
        }
    } else {
        // Redirect with error message if statement preparation fails
        header("location: orders_show.php?rs_id=$rs_id&error=1");
        exit();
    }
} else {
    // Redirect if order ID is not provided
    header("location: orders_show.php?rs_id=$rs_id");
    exit();
}


// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input data
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
    $discount = isset($_POST['discount']) ? floatval($_POST['discount']) : 0;

    // Validate input data
    if ($quantity <= 0 || $discount < 0) {
        // Redirect with error message if input is invalid
        header("location: ".$_SERVER['PHP_SELF']."?id=$order_id&rs_id=$rs_id&error=1");
        exit();
    }

    // Calculate gross amount
    $price = floatval($order['price']);
    $gross_amount = $quantity * $price;

    // Calculate net amount
    $net_amount = $gross_amount - $discount;

    // Update order in the database
    $sql = "UPDATE offline_orders SET quantity = ?, gross_amount = ?, discount = ?, net_amount = ? WHERE order_id = ?";
    $stmt = mysqli_prepare($db, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ididi", $quantity, $gross_amount, $discount, $net_amount, $order_id);
        mysqli_stmt_execute($stmt);

        // Redirect with success message after updating the order        
        header("location: ".$_SERVER['PHP_SELF']."?id=$order_id&rs_id=$rs_id&success=1");
        exit();
    } else {
        // Redirect with error message if statement preparation fails        
        header("location: ".$_SERVER['PHP_SELF']."?id=$order_id&rs_id=$rs_id&error=1");
        exit();
    }
}

include("hel.php");
include('header_menu.php');
include('header.php');
include('sidebar.php');
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Edit Order</h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Order Details</h3>
                    </div>
                    <form role="form" method="post">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="order_id">Order ID</label>
                                <input type="text" class="form-control" id="order_id" name="order_id" value="<?php echo $order['order_id']; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="order_date">Order Date</label>
                                <input type="text" class="form-control" id="order_date" name="order_date" value="<?php echo $order['order_date']; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="dish_name">Dish Name</label>
                                <input type="text" class="form-control" id="dish_name" name="dish_name" value="<?php echo $order['dish_name']; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="quantity">Quantity</label>
                                <input type="number" class="form-control" id="quantity" name="quantity" value="<?php echo $order['quantity']; ?>" min="1">
                            </div>
                            <div class="form-group">
                                <label for="price">Price</label>
                                <input type="text" class="form-control" id="price" name="price" value="<?php echo $order['price']; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="gross_amount">Gross Amount</label>
                                <input type="text" class="form-control" id="gross_amount" name="gross_amount" value="<?php echo $order['gross_amount']; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="discount">Discount</label>
                                <input type="number" class="form-control" id="discount" name="discount" value="<?php echo $order['discount']; ?>" min="0">
                            </div>
                            <div class="form-group">
                                <label for="net_amount">Net Amount</label>
                                <input type="text" class="form-control" id="net_amount" name="net_amount" value="<?php echo $order['net_amount']; ?>" readonly>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Update Order</button>
                            <a href="orders_show.php?rs_id=<?php echo $rs_id; ?>" class="btn btn-default">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include('footer.php'); ?>

<script>
    // Calculate net amount and gross amount based on quantity and price
    function calculateAmounts() {
        var quantity = parseInt(document.getElementById('quantity').value);
        var price = parseFloat(document.getElementById('price').value);
        var discount = parseFloat(document.getElementById('discount').value);

        var grossAmount = quantity * price;
        var netAmount = grossAmount - discount;

        document.getElementById('gross_amount').value = grossAmount.toFixed(2);
        document.getElementById('net_amount').value = netAmount.toFixed(2);
    }

    // Add event listener to quantity and discount fields
    document.getElementById('quantity').addEventListener('input', calculateAmounts);
    document.getElementById('discount').addEventListener('input', calculateAmounts);

    // Initial calculation on page load
    calculateAmounts();
</script>
