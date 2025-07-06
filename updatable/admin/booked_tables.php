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
    <title>Ela - Bootstrap Admin Dashboard Template</title>
    <link href="css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="css/helper.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">

    <!-- Add your existing head section... -->

</head>

<body class="fix-header fix-sidebar">
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
        </svg>
    </div>
    <div id="main-wrapper">
        <!-- Navigation -->
        <?php include("header.php"); ?>
        <!-- End Left Sidebar -->

        <!-- Page wrapper -->
        <div class="page-wrapper" style="height:1200px;background: #87CEFA">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary">All Tables</h3>
                </div>
            </div>

            <div class="container-fluid" style="background: #87CEFA">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">All Tables Details</h4>
                                <div class="table-responsive m-t-40">
                                    <table id="example23"
                                        class="display nowrap table table-hover table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Table ID</th>
                                                <th>Restaurant Name</th>
                                                <th>Capacity</th>
                                                <th>Description</th>
                                                <th>Table Name</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql = "SELECT tables.*, restaurant.title
                                                    FROM tables 
                                                    INNER JOIN restaurant ON tables.rs_id = restaurant.rs_id WHERE tables.is_booked=1";
                                            $query = mysqli_query($db, $sql);

                                            if (!mysqli_num_rows($query) > 0) {
                                                echo '<td colspan="8"><center>No Tables Data!</center></td>';
                                            } else {
                                                while ($rows = mysqli_fetch_array($query)) {
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo $rows['table_id']; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $rows['title']; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $rows['capacity']; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $rows['table_name']; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $rows['description']; ?>
                                                        </td>
                                                        <td>
                                                            <?php                                                            
                                                                echo '<button type="button" class="btn btn-success"><span
                                                            class="fa fa-check-circle"
                                                            aria-hidden="true">Booked</button>';
                                                            
                                                            ?>
                                                        </td>

                                                        <td>
                                                            <a href="delete_table.php?table_del=<?php echo $rows['table_id']; ?>"
                                                                onclick="return confirm('Are you sure?');"
                                                                class="btn btn-danger btn-flat btn-addon btn-xs m-b-10"><i
                                                                    class="fa fa-trash-o" style="font-size:16px"></i></a>
                                                            <a href="view_table.php?table_upd=<?php echo $rows['table_id']; ?>"
                                                                class="btn btn-info btn-flat btn-addon btn-sm m-b-10 m-l-5">
                                                                <i class="ti-settings"></i> View
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
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

        </div>
    </div>
    <?php include("footer.php"); ?>
    <script src="js/lib/jquery/jquery.min.js"></script>
    <script src="js/lib/bootstrap/js/popper.min.js"></script>
    <script src="js/lib/bootstrap/js/bootstrap.min.js"></script>
    <script src="js/jquery.slimscroll.js"></script>
    <script src="js/sidebarmenu.js"></script>
    <script src="js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <script src="js/custom.min.js"></script>
    <script src="js/lib/datatables/datatables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
    <script src="js/lib/datatables/datatables-init.js"></script>

    <!-- Initialize DataTables with export options -->
    <script>
        $(document).ready(function () {
            if (!$.fn.dataTable.isDataTable('#example23')) {
                $('#example23').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ]
                });
            }
        });
    </script>
</body>

</html>