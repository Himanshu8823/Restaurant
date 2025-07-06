<?php
session_start();
if (!isset($_SESSION['manager'])&&!isset($_SESSION['username'])) {
  header("Location: ../login.php");
  exit();
}
include("hel.php");
include('header_menu.php');
include('header.php');
include('sidebar.php');

// Include database connection
include("../connection/connect.php");

// Check if supplier ID is provided
if(isset($_GET['supplier_id']) && !empty($_GET['supplier_id'])) {
    $supplier_id = $_GET['supplier_id'];

    // Retrieve supplier details from the database
    $sql = "SELECT * FROM inventory_suppliers WHERE supplier_id = '$supplier_id' AND rs_id = '$rs_id'";
    $result = mysqli_query($db, $sql);
    $supplier = mysqli_fetch_assoc($result);

    if(!$supplier) {
        // Supplier not found, redirect to view suppliers page
        exit();
    }
} else {
    // Supplier ID not provided, redirect to view suppliers page
    exit();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['name']) && isset($_POST['contact_person']) && isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['address'])) {
    // Retrieve data from the form
    $name = $_POST['name'];
    $contact_person = $_POST['contact_person'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // Update supplier details in the database
    $update_query = "UPDATE inventory_suppliers 
                     SET name = '$name', contact_person = '$contact_person', email = '$email', phone = '$phone', address = '$address'
                     WHERE supplier_id = '$supplier_id' AND rs_id = '$rs_id'";

    if (mysqli_query($db, $update_query)) {
        // Supplier updated successfully
        echo "<script>alert('Supplier updated successfully');</script>";
        header("Location: view_suppliers.php");
        exit();
    } else {
        // Error updating supplier
        echo "<script>alert('Error updating supplier');</script>";
        header("Location: edit_supplier.php?id=$supplier_id");
        exit();
    }
}
?>

  <div class="wrapper">

    <!-- Add your header and sidebar here -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Manage
          <small>Suppliers</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">Suppliers</li>
        </ol>
      </section>

      <!-- Main content -->
      <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-md-12 col-xs-12">
            <div class="box">
              <div class="box-header">
                <h3 class="box-title">Edit Supplier</h3>
              </div>
              <form role="form" action="edit_supplier.php?id=<?php echo $supplier_id; ?>" method="post">
                <div class="box-body">
                  <div class="form-group">
                    <label for="name">Supplier Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter supplier name" autocomplete="off" value="<?php echo $supplier['name']; ?>">
                  </div>
                  <div class="form-group">
                    <label for="contact_person">Contact Person</label>
                    <input type="text" class="form-control" id="contact_person" name="contact_person" placeholder="Enter contact person name" autocomplete="off" value="<?php echo $supplier['contact_person']; ?>">
                  </div>
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" autocomplete="off" value="<?php echo $supplier['email']; ?>">
                  </div>
                  <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter phone number" autocomplete="off" value="<?php echo $supplier['phone']; ?>">
                  </div>
                  <div class="form-group">
                    <label for="address">Address</label>
                    <textarea class="form-control" id="address" name="address" rows="3" placeholder="Enter address"><?php echo $supplier['address']; ?></textarea>
                  </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                  <button type="submit" class="btn btn-success">Save Changes</button>
                  <a href="view_suppliers.php?rs_id=<?php echo $rs_id; ?>" class="btn btn-danger">Cancel</a>
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

</html>
