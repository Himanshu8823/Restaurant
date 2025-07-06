<?php
session_start();
if (!isset($_SESSION['manager']) && !isset($_SESSION['username'])) {
  header("Location: ../login.php");
  exit();
}
$rs_id=$_GET['rs_id'];
// Include database connection
include("../connection/connect.php");

// Fetch suppliers from the database
$sql = "SELECT supplier_id, name FROM inventory_suppliers";
$result = mysqli_query($db, $sql);
$suppliers = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['title']) && isset($_POST['unit_price'])) {
  // Retrieve data from the form
  $title = $_POST['title'];
  $description = isset($_POST['description']) ? $_POST['description'] : "";
  $category = isset($_POST['category']) ? $_POST['category'] : "";
  $unit_price = $_POST['unit_price'];
  $supplier_id = isset($_POST['supplier_id']) ? $_POST['supplier_id'] : null;

  // Insert data into the database
  $insert_query = "INSERT INTO inventory_products (title, description, category, unit_price, supplier_id, rs_id)
                     VALUES ('$title', '$description', '$category', '$unit_price', '$supplier_id', '{$_SESSION['rs_id']}')";

  if (mysqli_query($db, $insert_query)) {
    // Product added successfully
    echo "<script>alert('Product added successfully');</script>";
    // No need to redirect, just exit
    exit();
  } else {
    // Error adding product
    echo "<script>alert('Error adding product');</script>";
    exit();
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
      <h1>
        Manage
        <small>Products</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Products</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-12 col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Add Product</h3>
            </div>
            <form role="form" action="" method="post">
              <div class="box-body">
                <div class="form-group">
                  <label for="title">Product Title</label>
                  <input type="text" class="form-control" id="title" name="title" placeholder="Enter product title"
                    autocomplete="off" required>
                </div>
                <div class="form-group">
                  <label for="description">Description</label>
                  <textarea class="form-control" id="description" name="description" rows="3"
                    placeholder="Enter product description"></textarea>
                </div>
                <div class="form-group">
                  <label for="category">Category</label>
                  <input type="text" class="form-control" id="category" name="category" placeholder="Enter category"
                    autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="unit_price">Unit Price</label>
                  <input type="text" class="form-control" id="unit_price" name="unit_price"
                    placeholder="Enter unit price" autocomplete="off" required>
                </div>
                <div class="form-group">
                  <label for="supplier_id">Supplier</label>
                  <select class="form-control select2" id="supplier_id" name="supplier_id" style="width: 100%;">
                    <option value="">Select Supplier</option>
                    <?php foreach ($suppliers as $supplier): ?>
                    <option value="<?php echo $supplier['supplier_id']; ?>"><?php echo $supplier['name']; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" name="submit" class="btn btn-success">Save Product</button>
                <a href="view_supplier_product.php?rs_id=<?php echo $rs_id; ?>" class="btn btn-danger">Cancel</a>
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
<!-- Select2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
  $(document).ready(function () {
    // Initialize Select2
    $('.select2').select2();
  });
</script>

</html>
