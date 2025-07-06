<?php
session_start();
if (!isset($_SESSION['manager']) && !isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}
$rs_id=$_SESSION['rs_id'];
// Include database connection
include("../connection/connect.php");

// Fetch purchase order data from the database
$order_id = $_GET['id'];
$sql = "SELECT * FROM inventory_purchase_orders WHERE order_id = '$order_id'";
$result = mysqli_query($db, $sql);
$order = mysqli_fetch_assoc($result);

// Fetch product data from the database
$product_id = $order['product_id'];
$product_query = "SELECT title FROM inventory_products WHERE product_id = '$product_id'";
$product_result = mysqli_query($db, $product_query);
$product = mysqli_fetch_assoc($product_result);

// Fetch supplier data from the database
$supplier_id = $order['supplier_id'];
$supplier_query = "SELECT name FROM inventory_suppliers WHERE supplier_id = '$supplier_id'";
$supplier_result = mysqli_query($db, $supplier_query);
$supplier = mysqli_fetch_assoc($supplier_result);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['quantity']) && isset($_POST['date'])) {
    // Retrieve data from the form
    $quantity = $_POST['quantity'];
    $date = $_POST['date'];

    // Update data in the database
    $update_query = "UPDATE inventory_order_items 
                     SET quantity = '$quantity'
                     WHERE order_id = '$order_id'";

    if (mysqli_query($db, $update_query)) {
        // Purchase order updated successfully
        $message = "Purchase order updated successfully";
    } else {
        // Error updating purchase order
        $message = "Error updating purchase order: " . mysqli_error($db);
    }
}

include("hel.php");
include('header_menu.php');
include('header.php');
include('sidebar.php');

?>

<div class="wrapper">

    <!-- Add your header and sidebar here -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Edit Purchase Order</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Edit Purchase Order</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-md-12 col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Edit Purchase Order</h3>
                        </div>
                        <form role="form" action="" method="post">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="product">Product</label>
                                    <input type="text" class="form-control" id="product" name="product" value="<?php echo $product['title']; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="quantity">Quantity</label>
                                    <input type="number" class="form-control" id="quantity" name="quantity" value="<?php echo $order['quantity']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="supplier">Supplier</label>
                                    <input type="text" class="form-control" id="supplier" name="supplier" value="<?php echo $supplier['name']; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="date">Purchase Date</label>
                                    <input type="date" class="form-control" id="date" name="date" value="<?php echo $order['purchase_date']; ?>">
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <button type="submit" class="btn btn-success">Update Purchase Order</button>
                                <a href="inventory_view_purchase_orders.php?rs_id=<?php echo $rs_id;?>" class="btn btn-danger">Cancel</a>
                            </div>
                        </form>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Show alert message if set
        <?php if (isset($message)) : ?>
            alert("<?php echo $message; ?>");
        <?php endif; ?>
    });
</script>
</body>
</html>
