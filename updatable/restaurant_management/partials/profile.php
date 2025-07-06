<?php
session_start();
include("../connection/connect.php");

// Check if user is logged in and get their ID
if (isset($_SESSION['manager'])) {
  $employee_id = $_SESSION['employee_id'];
}else if(isset($_SESSION['cashier']))
{
  $employee_id = $_SESSION['employee_id'];
}
 else if (!isset($_SESSION['ad_id'])) {
  header("Location: ../login.php");
  exit;
}else{
  $ad_id = $_SESSION['ad_id'];
}

$is_manager = false;
// Query to fetch profile information of the restaurant admin
if (isset($_SESSION['manager']) || isset($_SESSION['cashier'])) {
  $query = "SELECT * FROM employees WHERE employee_id = $employee_id";
  $result = mysqli_query($db, $query);
  $is_manager = true;
} else {
  $query = "SELECT * FROM restaurant_admins WHERE ad_id = $ad_id";
  $result = mysqli_query($db, $query);
}

// Check if query was successful
if ($result) {
  $row = mysqli_fetch_assoc($result); // Fetch profile data

  include("hel.php");
  include('header_menu.php');
  include('header.php');
  include('sidebar.php');
  // Display profile information in the table
  ?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        User
        <small>Profile</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Profile</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-12 col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Profile</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered table-condensed table-hover table-hovered">
                <tr>
                  <th>Username</th>
                  <td>
                    <?php echo $row['username']; ?>
                  </td>
                </tr>                
                <?php if (!$is_manager) { ?>
                  <tr>
                    <th>First Name</th>
                    <td>
                      <?php echo $row['firstname']; ?>
                    </td>
                  </tr>
                  <tr>
                    <th>Last Name</th>
                    <td>
                      <?php echo $row['lastname']; ?>
                    </td>
                  </tr>
                  <tr>
                    <th>Gender</th>
                    <td>
                      <?php echo $row['gender']; ?>
                    </td>
                  <tr>
                    <th>Address</th>
                    <td>
                      <?php echo $row['address']; ?>
                    </td>
                  </tr>
                  <tr>
                    <th>Group</th>
                    <td><span class="label label-success">Restaurant Admin</span></td>
                  </tr>
                  
                  <?php
                } 
                else if(isset($_SESSION['cashier']))
                { ?>
                  <tr>
                    <th>Role</th>
                    <td><span class="label label-success">Cashier</span></td>
                  </tr>
                  <tr>
                    <th>Name</th>
                    <td>
                      <?php echo $row['name']; ?>
                    </td>
                  </tr>
                  <?php
                }
                else { ?>
                  <tr>
                    <th>Name</th>
                    <td>
                      <?php echo $row['name']; ?>
                    </td>
                  </tr>
                
                  <tr>
                  <th>Role</th>
                  <td><span class="label label-success">Restaurant Manager</span></td>
                </tr>
                <?php } ?>

                <tr>
                  <th>Email</th>
                  <td>
                    <?php echo $row['email']; ?>
                  </td>
                </tr>
                <tr>
                  <th>Phone</th>
                  <td>
                    <?php echo $row['phone']; ?>
                  </td>
                </tr>

              </table>
            </div>
            <!-- /.box-body -->
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
  <?php
} else {
  echo "Error: " . mysqli_error($db);
}

// Close connection
mysqli_close($db);
?>

<script type="text/javascript">
  $(document).ready(function () {
    $("#profileMainNav").addClass('active');
  });
</script>