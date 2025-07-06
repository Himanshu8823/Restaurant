<?php
session_start();
if (!isset($_SESSION['manager']) && !isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}
// Include database connection
include("../connection/connect.php");

// Fetch product data from the database
$sql = "SELECT * FROM inventory_products";
$result = mysqli_query($db, $sql);

// Prepare data array
$products = array();
while ($row = mysqli_fetch_assoc($result)) {
    $products[] = $row;
}

// Fetch supplier data from the database
$sql = "SELECT * FROM inventory_suppliers";
$result = mysqli_query($db, $sql);

// Prepare supplier data array
$suppliers = array();
while ($row = mysqli_fetch_assoc($result)) {
    $suppliers[] = $row;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product']) && isset($_POST['quantity']) && isset($_POST['supplier']) && isset($_POST['date'])) {
    // Retrieve data from the form
    $product_id = $_POST['product'];
    $quantity = $_POST['quantity'];
    $supplier_id = $_POST['supplier'];
    $date = $_POST['date'];

    // Fetch product price from the database
    $price_query = "SELECT unit_price FROM inventory_products WHERE product_id = '$product_id'";
    $price_result = mysqli_query($db, $price_query);
    $product_price = mysqli_fetch_assoc($price_result)['unit_price'];

    // Calculate total amount
    $total_amount = $product_price * $quantity;

    // Insert data into the database
    $insert_query = "INSERT INTO inventory_purchase_orders (supplier_id, order_date, delivery_date, total_amount, rs_id)
                     VALUES ('$supplier_id', '$date', '$date', '$total_amount', '$rs_id')";

    if (mysqli_query($db, $insert_query)) {
        // Purchase order created successfully
        echo "<script>alert('Purchase order created successfully');</script>";
    } else {
        // Error creating purchase order
        echo "<script>alert('Error creating purchase order');</script>";
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
            <h1>Create Purchase Order</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Create Purchase Order</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-md-12 col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Add Products to Purchase Order</h3>
                        </div>
                        <form role="form" action="" method="post">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="product">Select Product</label>
                                    <select class="form-control select2" style="width: 100%;" name="product" id="product">
                                        <option value="">Select Product</option>
                                        <?php foreach ($products as $product) : ?>
                                            <option value="<?php echo $product['product_id']; ?>"><?php echo $product['title']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="quantity">Quantity</label>
                                    <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Enter quantity" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label for="supplier">Supplier</label>
                                    <select class="form-control select2" style="width: 100%;" name="supplier" id="supplier">
                                        <option value="">Select Supplier</option>
                                        <?php foreach ($suppliers as $supplier) : ?>
                                            <option value="<?php echo $supplier['supplier_id']; ?>"><?php echo $supplier['name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="date">Purchase Date</label>
                                    <input type="date" class="form-control" id="date" name="date" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label for="total_amount">Total Amount</label>
                                    <input type="text" class="form-control" id="total_amount" name="total_amount" readonly>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <button type="submit" name="submit" class="btn btn-success">Create Purchase Order</button>
                                <a href="view_purchase_orders.php" class="btn btn-danger">Cancel</a>
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

<!-- ./wrapper -->

<!-- Add your scripts here -->

<!-- Add jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Add Select2 JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<!-- Initialize Select2 -->
<script type="text/javascript">
    $(document).ready(function() {
        // Initialize Select2 for product selection
        $('.select2').select2();

        // Calculate and update total amount on quantity change
        $('#quantity').on('change', function() {
            var quantity = $(this).val();
            var product_id = $('#product').val();
            var price = <?php echo json_encode($product_price); ?>;
            var total_amount = quantity * price;
            $('#total_amount').val(total_amount.toFixed(2));
        });
    });
</script>

</body>
</html>
