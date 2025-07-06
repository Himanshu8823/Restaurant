<!DOCTYPE html>
<html lang="en">
<?php
include("../connection/connect.php");
error_reporting(0);
session_start();
?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <title>Your Dashboard Title</title>
    <link href="css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="css/helper.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body class="fix-header fix-sidebar">
    <div id="main-wrapper">
        <!-- Navigation -->
        <?php include("header.php"); ?>
        <!-- End Left Sidebar -->

        <!-- Page wrapper  -->
        <div class="page-wrapper">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary">Dashboard</h3>
                </div>
            </div>

            
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary">Restaurant-wise Food Reports</h3>
                </div>
            </div>

            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive m-t-40">
                                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Logo</th>
                                                <th>Name</th>
                                                <th>Total Orders</th>
                                                <th>Total Income</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $restaurantSql = "SELECT * FROM restaurant";
                                            $restaurantQuery = mysqli_query($db, $restaurantSql);

                                            while ($restaurant = mysqli_fetch_array($restaurantQuery)) {
                                                $restaurantId = $restaurant['rs_id'];
                                                $restaurantName = $restaurant['title'];
                                                $restaurantLogo = $restaurant['image'];

                                                // Get total orders and income for each restaurant
                                                $orderSql = "SELECT COUNT(*) as total_orders, SUM(price) as total_income FROM users_orders WHERE rs_id = '$restaurantId' AND status = 'closed'";
                                                $orderQuery = mysqli_query($db, $orderSql);
                                                $orderData = mysqli_fetch_array($orderQuery);

                                                $totalOrders = $orderData['total_orders'];
                                                $totalIncome = $orderData['total_income'];
                                            ?>
                                                <tr>
                                                    <td><img src="Res_img/<?php echo $restaurantLogo; ?>" alt="Restaurant Logo" style="width: 50px; height: 50px;"></td>
                                                    <td><?php echo $restaurantName; ?></td>
                                                    <td><?php echo $totalOrders; ?></td>
                                                    <td>Rs <?php echo $totalIncome; ?></td>
                                                    <td>
                                                        <a href="generate_pdf.php?restaurant_id=<?php echo $restaurantId; ?>" class="btn btn-primary btn-flat btn-addon btn-xs m-b-10"><i class="fa fa-download" style="font-size:16px"></i> Download PDF</a>
                                                    </td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include("footer.php"); ?>
        </div>
    </div>
    
    <script src="js/lib/jquery/jquery.min.js"></script>
    <script src="js/lib/bootstrap/js/popper.min.js"></script>
    <script src="js/lib/bootstrap/js/bootstrap.min.js"></script>
    <script src="js/jquery.slimscroll.js"></script>
    <script src="js/sidebarmenu.js"></script>
    <script src="js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <script src="js/custom.min.js"></script>
</body>

</html>
