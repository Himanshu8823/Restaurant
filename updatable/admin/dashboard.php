<!DOCTYPE html>
<html lang="en">
<?php
include("../connection/connect.php");
error_reporting(0);
session_start();
if (empty($_SESSION["adm_id"])) {
    header('location:index.php');
} else {
    ?>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <!-- Favicon icon -->
        <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
        <title>Ela - Bootstrap Admin Dashboard Template</title>
        <!-- Bootstrap Core CSS -->
        <link href="css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="css/helper.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:** -->
        <!--[if lt IE 9]>
    <script src="https:**oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https:**oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
    </head>

    <body class="fix-header fix-sidebar">
        <!-- Preloader - style you can find in spinners.css -->
        <div class="preloader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
            </svg>
        </div>
        <!-- Main wrapper  -->
        <div id="main-wrapper">
            <!-- header header  -->
            <?php include("header.php"); ?>
            <!-- End Left Sidebar  -->
            <!-- Page wrapper  -->
            <div class="page-wrapper"  style="background: #87CEFA">
                <!-- Bread crumb -->
                <div class="row page-titles">
                    <div class="col-md-5 align-self-center">
                        <h3 class="text-primary">Dashboard</h3>
                    </div>

                </div>
                <!-- End Bread crumb -->
                <!-- Container fluid  -->
                <div class="container-fluid" style="background: #87CEFA">
                    <!-- Start Page Content -->
                    <div class="row">

                        <div class="col-md-3">
                            <div class="card p-30">
                                <div class="media">
                                    <div class="media-left meida media-middle">
                                        <span><i class="fa fa-archive f-s-40 color-warning"></i></span>
                                    </div>
                                    <div class="media-body media-text-right">
                                        <h2>
                                            <?php $sql = "select * from restaurant";
                                            $result = mysqli_query($db, $sql);
                                            $rws = mysqli_num_rows($result);

                                            echo $rws; ?>
                                        </h2>
                                        <p class="m-b-0">Stores</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card p-30">
                                <div class="media">
                                    <div class="media-left meida media-middle">
                                        <span><i class="fa fa-cutlery f-s-40" aria-hidden="true"></i></span>
                                    </div>
                                    <div class="media-body media-text-right">
                                        <h2>
                                            <?php $sql = "select * from dishes";
                                            $result = mysqli_query($db, $sql);
                                            $rws = mysqli_num_rows($result);

                                            echo $rws; ?>
                                        </h2>
                                        <p class="m-b-0">Dishes</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card p-30">
                                <div class="media">
                                    <div class="media-left meida media-middle">
                                        <span><i class="fa fa-user f-s-40 color-danger"></i></span>
                                    </div>
                                    <div class="media-body media-text-right">
                                        <h2>
                                            <?php $sql = "select * from users";
                                            $result = mysqli_query($db, $sql);
                                            $rws = mysqli_num_rows($result);

                                            echo $rws; ?>
                                        </h2>
                                        <p class="m-b-0">Customer</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card p-30">
                                <div class="media">
                                    <div class="media-left meida media-middle">
                                        <span><i class="fa fa-shopping-cart f-s-40" aria-hidden="true"></i></span>
                                    </div>
                                    <div class="media-body media-text-right">
                                        <h2>
                                            <?php $sql = "select * from users_orders";
                                            $result = mysqli_query($db, $sql);
                                            $rws = mysqli_num_rows($result);

                                            echo $rws; ?>
                                        </h2>
                                        <p class="m-b-0">Orders</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card p-30">
                                <div class="media">
                                    <div class="media-left meida media-middle">
                                        <span><i style=" color: green;" class="fa fa-money f-s-40" aria-hidden="true"></i></span>
                                    </div>
                                    <div class="media-body media-text-right">
                                        <h2>
                                            <?php $websiteQuery = mysqli_query($db, "SELECT SUM(price) as total_turnover FROM users_orders WHERE status = 'closed'");
                                            while ($websiteRow = mysqli_fetch_assoc($websiteQuery)) {
                                                ?>
                                                <tr>
                                                    <td>
                                                        <?php echo 'Rs ' . $websiteRow['total_turnover']; ?>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                        </h2>
                                        <p class="m-b-0">Turn Over</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card p-30">
                                <div class="media">
                                    <div class="media-left meida media-middle">
                                        <span><i class="fa fa-clock-o f-s-40" aria-hidden="true"></i></span>
                                    </div>
                                    <div class="media-body media-text-right">
                                        <h2>
                                            <?php $websiteQuery = mysqli_query($db, "SELECT SUM(price) as total_turnover FROM users_orders WHERE status = 'in process'");
                                            while ($websiteRow = mysqli_fetch_assoc($websiteQuery)) {
                                                ?>
                                                <tr>
                                                    <td>
                                                        <?php echo 'Rs ' . $websiteRow['total_turnover']; ?>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                        </h2>
                                        <p class="m-b-0">Pending Amount</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card p-30">
                                <div class="media">
                                    <div class="media-left meida media-middle">
                                        <span><i style=" color: green;" class="fa fa-check f-s-40" aria-hidden="true"></i></span>
                                    </div>
                                    <div class="media-body media-text-right">
                                        <h2>
                                            <?php $sql = "select * from users_orders where status='closed'";
                                            $result = mysqli_query($db, $sql);
                                            $rws = mysqli_num_rows($result);

                                            echo $rws; ?>
                                        </h2>
                                        <p class="m-b-0">Completed Orders</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card p-30">
                                <div class="media">
                                    <div class="media-left meida media-middle">
                                        <span><i style=" color: magenta;" class="fa fa-spinner f-s-40" aria-hidden="true"></i></span>
                                    </div>
                                    <div class="media-body media-text-right">
                                        <h2>
                                            <?php $sql = "select * from users_orders where status='in process'";
                                            $result = mysqli_query($db, $sql);
                                            $rws = mysqli_num_rows($result);

                                            echo $rws; ?>
                                        </h2>
                                        <p class="m-b-0">Pending Orders</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card p-30">
                                <div class="media">
                                    <div class="media-left meida media-middle">
                                        <span><i style=" color: red;" class="fa fa-times f-s-40" aria-hidden="true"></i></span>
                                    </div>
                                    <div class="media-body media-text-right">
                                        <h2>
                                            <?php $sql = "select * from users_orders where status='rejected'";
                                            $result = mysqli_query($db, $sql);
                                            $rws = mysqli_num_rows($result);

                                            echo $rws; ?>
                                        </h2>
                                        <p class="m-b-0">Rejected Orders</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card p-30">
                                <div class="media">
                                    <div class="media-left meida media-middle">
                                        <span><i style=" color:blue;" class="fa fa-bars f-s-40" aria-hidden="true"></i></span>
                                    </div>
                                    <div class="media-body media-text-right">
                                        <h2>
                                            <?php $sql = "select * from res_category";
                                            $result = mysqli_query($db, $sql);
                                            $rws = mysqli_num_rows($result);

                                            echo $rws; ?>
                                        </h2>
                                        <p class="m-b-0">Categories</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card p-30">
                                <div class="media">
                                    <div class="media-left meida media-middle">
                                        <span><i style=" color:blue;" class="fa fa-comments f-s-40" aria-hidden="true"></i></span>
                                    </div>
                                    <div class="media-body media-text-right">
                                        <h2>
                                            <?php $sql = "select * from website_feedbacks";
                                            $result = mysqli_query($db, $sql);
                                            $rws = mysqli_num_rows($result);

                                            echo $rws; ?>
                                        </h2>
                                        <p class="m-b-0">Total Website Feedbacks</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card p-30">
                                <div class="media">
                                    <div class="media-left meida media-middle">
                                        <span><i style=" color:blue;" class="fa fa-comments f-s-40" aria-hidden="true"></i></span>
                                    </div>
                                    <div class="media-body media-text-right">
                                        <h2>
                                            <?php $sql = "select * from feedback";
                                            $result = mysqli_query($db, $sql);
                                            $rws = mysqli_num_rows($result);

                                            echo $rws; ?>
                                        </h2>
                                        <p class="m-b-0">Total Restaurants Feedbacks</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card p-30">
                                <div class="media">
                                    <div class="media-left meida media-middle">
                                        <span><i style=" color:blue;" class="fa fa-bar-chart f-s-40" aria-hidden="true"></i></span>
                                    </div>
                                    <div class="media-body media-text-right">
                                        <h2>
                                            <?php $sql = "select * from tables";
                                            $result = mysqli_query($db, $sql);
                                            $rws = mysqli_num_rows($result);

                                            echo $rws; ?>
                                        </h2>
                                        <p class="m-b-0">Total Tables</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card p-30">
                                <div class="media">
                                    <div class="media-left meida media-middle">
                                        <span><i style=" color:blue;" class="fa fa-bar-chart f-s-40" aria-hidden="true"></i></span>
                                    </div>
                                    <div class="media-body media-text-right">
                                        <h2>
                                            <?php $sql = "select * from tables where is_booked=1";
                                            $result = mysqli_query($db, $sql);
                                            $rws = mysqli_num_rows($result);

                                            echo $rws; ?>
                                        </h2>
                                        <p class="m-b-0">Booked Tables</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card p-30">
                                <div class="media">
                                    <div class="media-left meida media-middle">
                                        <span><i style=" color:blue;" class="fa fa-bar-chart f-s-40" aria-hidden="true"></i></span>
                                    </div>
                                    <div class="media-body media-text-right">
                                        <h2>
                                            <?php $sql = "select * from tables where is_booked=0";
                                            $result = mysqli_query($db, $sql);
                                            $rws = mysqli_num_rows($result);

                                            echo $rws; ?>
                                        </h2>
                                        <p class="m-b-0">Unbook Tables</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card p-30">
                                <div class="media">
                                    <div class="media-left meida media-middle">
                                        <span><i style=" color:blue;" class="fa fa-user f-s-40" aria-hidden="true"></i></span>
                                    </div>
                                    <div class="media-body media-text-right">
                                        <h2>
                                            <?php $sql = "select * from users";
                                            $result = mysqli_query($db, $sql);
                                            $rws = mysqli_num_rows($result);

                                            echo $rws; ?>
                                        </h2>
                                        <p class="m-b-0">Total Users</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- End PAge Content -->
                </div>
                <!-- End Container fluid  -->

            </div>
            <!-- End Page wrapper  -->
            <?php
}
?>
    </div>
    <?php include('footer.php'); ?>
    <!-- End Wrapper -->
    <!-- All Jquery -->
    <script src="js/lib/jquery/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="js/lib/bootstrap/js/popper.min.js"></script>
    <script src="js/lib/bootstrap/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="js/jquery.slimscroll.js"></script>
    <!--Menu sidebar -->
    <script src="js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <!--Custom JavaScript -->
    <script src="js/custom.min.js"></script>

</body>

</html>