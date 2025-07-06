<?php
session_start();
if (!isset($_SESSION['manager'])&&!isset($_SESSION['username'])&&!isset($_SESSION['cashier'])) {
    header("Location: ../login.php");
    exit(); 
}

include_once "../connection/connect.php";

$_SESSION['rs_id']=$_GET['rs_id'];

// Fetching data related to menu items
$rs_id = $_GET['rs_id'];

// Total number of menu items
$sql_total_items = "SELECT COUNT(*) AS total_items FROM mess_menu_items WHERE rs_id = $rs_id";
$result_total_items = mysqli_query($db, $sql_total_items);
if(!$result_total_items) {
    die("Query failed: " . mysqli_error($db));
}
$row_total_items = mysqli_fetch_assoc($result_total_items);
$total_items = $row_total_items['total_items'];

// Total available menu items
$sql_available_items = "SELECT COUNT(*) AS available_items FROM mess_menu_items WHERE rs_id = $rs_id AND is_available = 1";
$result_available_items = mysqli_query($db, $sql_available_items);
if(!$result_available_items) {
    die("Query failed: " . mysqli_error($db));
}
$row_available_items = mysqli_fetch_assoc($result_available_items);
$available_items = $row_available_items['available_items'];

// Total unavailable menu items
$sql_unavailable_items = "SELECT COUNT(*) AS unavailable_items FROM mess_menu_items WHERE rs_id = $rs_id AND is_available = 0";
$result_unavailable_items = mysqli_query($db, $sql_unavailable_items);
if(!$result_unavailable_items) {
    die("Query failed: " . mysqli_error($db));
}
$row_unavailable_items = mysqli_fetch_assoc($result_unavailable_items);
$unavailable_items = $row_unavailable_items['unavailable_items'];


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
           Mess Dashboard
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-4 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3><?php echo $total_items; ?></h3>
                        <p>Total Menu Items</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-android-restaurant"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-4 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3><?php echo $available_items; ?></h3>
                        <p>Available Menu Items</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-android-restaurant"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-4 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3><?php echo $unavailable_items; ?></h3>
                        <p>Unavailable Menu Items</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-android-restaurant"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
    <?php include("footer.php"); ?>
</div>
<!-- /.content-wrapper -->
