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
                    <h3 class="text-primary">All Website Feedbacks</h3>
                </div>
            </div>

            <div class="container-fluid" style="background: #87CEFA">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">All Bookings Details</h4>
                                <div class="table-responsive m-t-40">
                                    <table id="example23"
                                        class="display nowrap table table-hover table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Feedback ID</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Rating</th>
                                                <th>Ease of use</th>
                                                <th>Design Feedback</th>
                                                <th>Suggestions</th>
                                                <th>Review Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql = "SELECT * FROM website_feedbacks ORDER BY created_at DESC";
                                            $query = mysqli_query($db, $sql);

                                            if (!mysqli_num_rows($query) > 0) {
                                                echo '<td colspan="8"><center>No Feedback Data!</center></td>';
                                            } else {
                                                while ($rows = mysqli_fetch_array($query)) {
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo $rows['id']; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $rows['name']; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $rows['email']; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $rows['rating'].'/5'; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $rows['ease_of_use'].'/10'; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $rows['design_feedback']; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $rows['suggestions']; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $rows['created_at']; ?>
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
    <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
    <script src="js/lib/datatables/cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="js/lib/datatables/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="js/lib/datatables/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
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