<?php
session_start();
if (!isset($_SESSION['manager']) && !isset($_SESSION['username'])) {
  header("Location: ../login.php");
  exit();
}
// Include database connection
include("../connection/connect.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['name']) && isset($_POST['contact_person']) && isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['address'])) {
  // Retrieve data from the form
  $name = $_POST['name'];
  $contact_person = $_POST['contact_person'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $address = $_POST['address'];

  // Insert data into the database
  $insert_query = "INSERT INTO inventory_suppliers (name, contact_person, email, phone, address, rs_id)
                     VALUES ('$name', '$contact_person', '$email', '$phone', '$address', '$rs_id')";

  if (mysqli_query($db, $insert_query)) {
    // Supplier added successfully
    echo "<script>alert('Supplier added successfully');</script>";
    // No need to redirect, just exit
    exit();
  } else {
    // Error adding supplier
    echo "not possible insertion";
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
              <h3 class="box-title">Add Supplier</h3>
            </div>
            <form role="form" action="" method="post">
              <div class="box-body">
                <div class="form-group">
                  <label for="name">Supplier Name</label>
                  <input type="text" class="form-control" id="name" name="name" placeholder="Enter supplier name"
                    autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="contact_person">Contact Person</label>
                  <input type="text" class="form-control" id="contact_person" name="contact_person"
                    placeholder="Enter contact person name" autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="email">Email</label>
                  <input type="email" class="form-control" id="email" name="email" placeholder="Enter email"
                    autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="phone">Phone</label>
                  <input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter phone number"
                    autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="address">Address</label>
                  <textarea class="form-control" id="address" name="address" rows="3"
                    placeholder="Enter address"></textarea>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" name="submit" class="btn btn-success">Save Supplier</button>
                <a href="view_suppliers.php" class="btn btn-danger">Cancel</a>
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