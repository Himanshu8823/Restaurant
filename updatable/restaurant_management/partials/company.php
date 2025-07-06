<?php
session_start();
if (!isset($_SESSION['username'])) {
  header("Location: ../login.php");
  exit(); 
}
include("hel.php");
include('header_menu.php');
include('header.php');
include('sidebar.php');

// Include database connection and initialize error/success variables
include("../connection/connect.php");
$error = '';
$success = '';
$rs_id=$_SESSION['rs_id'];
// Fetch previously stored restaurant information from the database
$sql = "SELECT * FROM restaurant WHERE rs_id =$rs_id";
$result = mysqli_query($db, $sql);
$row = mysqli_fetch_assoc($result);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['title'], $_POST['email'], $_POST['phone'], $_POST['url'], $_POST['o_hr'], $_POST['c_hr'], $_POST['o_days'], $_POST['address'])) {
  // Validate and sanitize form data
  $title = mysqli_real_escape_string($db, $_POST['title']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $phone = mysqli_real_escape_string($db, $_POST['phone']);
  $url = mysqli_real_escape_string($db, $_POST['url']);
  $o_hr = mysqli_real_escape_string($db, $_POST['o_hr']);
  $c_hr = mysqli_real_escape_string($db, $_POST['c_hr']);
  $o_days = mysqli_real_escape_string($db, $_POST['o_days']);
  $address = mysqli_real_escape_string($db, $_POST['address']);
  
  // Update restaurant information in the database
  $sql_update = "UPDATE restaurant SET 
                  c_id=9,
                  title='$title', 
                  email='$email', 
                  phone='$phone', 
                  url='$url', 
                  o_hr='$o_hr', 
                  c_hr='$c_hr', 
                  o_days='$o_days', 
                  address='$address'
                WHERE rs_id=$rs_id";
  if (mysqli_query($db, $sql_update)) {
    $success = '<script>      
    alert("Restaurant information updated successfully.");
        </script>';
    echo $success;
  } else {
    $error = '<script> alert("Try Again Later !!!");</script> ' ;
  }
}
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Manage
      <small>Restaurant</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Restaurant</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">

        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Manage Restaurant Information</h3>
          </div>
          <form role="form" action="" method="post">
            <div class="box-body">

              <div class="form-group">
                <label for="title">Restaurant Name</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Enter restaurant name" value="<?php echo $row['title']; ?>" autocomplete="off">
              </div>
              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" value="<?php echo $row['email']; ?>" autocomplete="off">
              </div>
              <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter phone" value="<?php echo $row['phone']; ?>" autocomplete="off">
              </div>
              <div class="form-group">
                <label for="url">Website URL</label>
                <input type="text" class="form-control" id="url" name="url" placeholder="Enter website URL" value="<?php echo $row['url']; ?>" autocomplete="off">
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="o_hr">Open Hours</label>
                    <select name="o_hr" class="form-control custom-select" data-placeholder="Choose Open Hours">
                      <option value="6am">6am</option>
                      <option value="7am">7am</option>
                      <option value="8am">8am</option>
                      <option value="9am">9am</option>
                      <option value="10am">10am</option>
                      <option value="11am">11am</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="c_hr">Close Hours</label>
                    <select name="c_hr" class="form-control custom-select" data-placeholder="Choose Close Hours">
                      <option value="3pm">3pm</option>
                      <option value="4pm">4pm</option>
                      <option value="5pm">5pm</option>
                      <option value="6pm">6pm</option>
                      <option value="7pm">7pm</option>
                      <option value="8pm">8pm</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="o_days">Opening Days</label>
                <select name="o_days" class="form-control custom-select" data-placeholder="Choose Open Days">
                  <option value="mon-tue">Mon-Tue</option>
                  <option value="mon-wed">Mon-Wed</option>
                  <option value="mon-thu">Mon-Thu</option>
                  <option value="mon-fri">Mon-Fri</option>
                  <option value="mon-sat">Mon-Sat</option>
                  <option value="24hr-x7">24hr-x7</option>
                </select>
              </div>
              <div class="form-group">
                <label for="address">Address</label>
                <input type="text" class="form-control" id="address" name="address" placeholder="Enter address" value="<?php echo $row['address']; ?>" autocomplete="off">
              </div>              
              
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
              <button type="submit" class="btn btn-success">Save Changes</button>
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

<script type="text/javascript">
  $(document).ready(function() {
    $("#restaurantMainNav").addClass('active');
  });
</script>
