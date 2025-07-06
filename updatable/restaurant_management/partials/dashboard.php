    <?php
    session_start();
    if (!isset($_SESSION['manager'])&&!isset($_SESSION['username'])&&!isset($_SESSION['cashier'])) {
        header("Location: ../login.php");
        exit(); 
    }

    include "../connection/connect.php";    
    $_SESSION['rs_id']=$_GET['rs_id'];
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
            Dashboard
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
            <?php
            // Include your database connection file

            $rs_id = $_GET["rs_id"];
            // Assuming you have a variable $rs_id containing the restaurant ID
            // You can set this variable based on your needs, like from a session or a query parameter
            
            // Fetch and display data for Food Products
            $result = $db->query("SELECT COUNT(*) AS count FROM dishes WHERE rs_id = $rs_id");
            $row = $result->fetch_assoc();
            $totalFoodProducts = $row['count'];
            ?>
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3>
                            <?php echo $totalFoodProducts; ?>
                        </h3>
                        <p>Food Products</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-android-restaurant"></i>
                    </div>
                    <a href="your-link-for-food-products?rs_id=<?php echo $rs_id; ?>" class="small-box-footer">More Info
                        <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <?php
            // Fetch and display data for Total Paid Orders
            $result = $db->query("SELECT COUNT(*) AS count FROM users_orders WHERE status = 'closed' AND rs_id = $rs_id");
            $row = $result->fetch_assoc();
            $totalPaidOrders = $row['count'];
            ?>
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>
                            <?php echo $totalPaidOrders; ?>
                        </h3>
                        <p>Total Paid Orders</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-cash"></i>
                    </div>
                    <a href="your-link-for-paid-orders?rs_id=<?php echo $rs_id; ?>" class="small-box-footer">More Info
                        <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <?php
            // Fetch and display data for System Users (considering users who placed orders)
            $result = $db->query("SELECT COUNT(DISTINCT u_id) AS count FROM users_orders WHERE rs_id = $rs_id");
            $row = $result->fetch_assoc();
            $totalSystemUsers = $row['count'];
            ?>
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>
                            <?php echo $totalSystemUsers; ?>
                        </h3>
                        <p>System Users</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-android-people"></i>
                    </div>
                    <a href="your-link-for-system-users?rs_id=<?php echo $rs_id; ?>" class="small-box-footer">More Info
                        <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <?php
            // Fetch and display data for UnPaid Orders
            $result = $db->query("SELECT COUNT(*) AS count FROM users_orders WHERE status = 'in process' AND rs_id = $rs_id");
            $row = $result->fetch_assoc();
            $totalUnPaidOrders = $row['count'];
            ?>
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-navy">
                    <div class="inner">
                        <h3>
                            <?php echo $totalUnPaidOrders; ?>
                        </h3>
                        <p>UnPaid Orders</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-close-circled" style="color:rgb(177, 169, 169);"></i>
                    </div>
                    <a href="your-link-for-unpaid-orders?rs_id=<?php echo $rs_id; ?>" class="small-box-footer">More Info
                        <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <?php
            // Fetch and display data for Rejected Orders
            $result = $db->query("SELECT COUNT(*) AS count FROM users_orders WHERE status = 'rejected' AND rs_id = $rs_id");
            $row = $result->fetch_assoc();
            $totalRejectedOrders = $row['count'];
            ?>
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>
                            <?php echo $totalRejectedOrders; ?>
                        </h3>
                        <p>Rejected Orders</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-close-circled"></i>
                    </div>
                    <a href="your-link-for-rejected-orders?rs_id=<?php echo $rs_id; ?>" class="small-box-footer">More
                        Info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <?php
            // Fetch and display data for Booked Table Booking
            $result = $db->query("SELECT COUNT(*) AS count FROM tables WHERE is_booked = 1 AND rs_id = $rs_id");
            $row = $result->fetch_assoc();
            $totalBookedTables = $row['count'];
            ?>
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3>
                            <?php echo $totalBookedTables; ?>
                        </h3>
                        <p>Booked Tables </p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-calendar"></i>
                    </div>
                    <a href="your-link-for-booked-table-booking?rs_id=<?php echo $rs_id; ?>"
                        class="small-box-footer">View Booked Tables
                        <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <?php
            // Fetch and display data for Available Tables
            $result = $db->query("SELECT COUNT(*) AS count FROM tables WHERE is_booked = 0 AND rs_id = $rs_id");
            $row = $result->fetch_assoc();
            $totalAvailableTables = $row['count'];
            ?>

            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-teal">
                    <div class="inner">
                        <h3>
                            <?php echo $totalAvailableTables; ?>
                        </h3>
                        <p>Available Tables</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-grid-view"></i>
                    </div>
                    <a href="your-link-for-available-tables?rs_id=<?php echo $rs_id; ?>" class="small-box-footer">More
                        Info
                        <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <?php
            // Fetch and display data for Total Tables
            $result = $db->query("SELECT COUNT(*) AS count FROM tables WHERE rs_id = $rs_id");
            $row = $result->fetch_assoc();
            $totalTables = $row['count'];
            ?>

            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-purple">
                    <div class="inner">
                        <h3>
                            <?php echo $totalTables; ?>
                        </h3>
                        <p>Total Tables</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-grid-view"></i>
                    </div>
                    <a href="your-link-for-total-tables?rs_id=<?php echo $rs_id; ?>" class="small-box-footer">More Info
                        <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <?php
            // Fetch and display data for Restaurant Feedbacks
            $result = $db->query("SELECT COUNT(*) AS count FROM feedback WHERE rs_id = $rs_id");
            $row = $result->fetch_assoc();
            $totalRestaurantFeedbacks = $row['count'];
            ?>

            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-black">
                    <div class="inner">
                        <h3>
                            <?php echo $totalRestaurantFeedbacks; ?>
                        </h3>
                        <p>Restaurant Feedbacks</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-chatbubbles"></i>
                    </div>
                    <a href="your-link-for-restaurant-feedbacks?rs_id=<?php echo $rs_id; ?>"
                        class="small-box-footer">More Info
                        <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>




        </div>
        <!-- /.row -->

        <!-- Rest of your code remains unchanged... -->

    </section>
    <!-- /.content -->
    <?php include("footer.php"); ?>
</div>
<!-- /.content-wrapper -->

<script type="text/javascript">
    $(document).ready(function () {
        $("#dashboardMainMenu").addClass('active');
    });
</script>