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
                    <h3 class="text-primary">All Bookings</h3>
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
                                                <th>Restaurant Name</th>
                                                <th>Customer Name</th>
                                                <th>Feedback Email</th>
                                                <th>Rating</th>
                                                <th>Feedback Message</th>
                                                <th>Feedback Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql = "SELECT feedback.*, restaurant.title as restaurant_name
        FROM feedback
        INNER JOIN restaurant ON feedback.rs_id = restaurant.rs_id";
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
                                                            <?php echo $rows['restaurant_name']; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $rows['name']; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $rows['feedback_email']; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $rows['rating']; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $rows['message']; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $rows['submission_date']; ?>
                                                        </td>
                                                        <td><button class="btn btn-danger btn-sm" onclick="deleteFeedback(<?php echo $rows['id']; ?>)"><i class='fa fa-trash-o' style="font-size:16px"></i></button></i></a>

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
    <script>
        function deleteFeedback(feedbackId) {
            if (confirm('Are you sure you want to delete this feedback?')) {
                // Send an AJAX request to the server to delete the feedback
                $.ajax({
                    type: 'POST',
                    url: 'delete_feedback.php', // Specify the server-side script to handle deletion
                    data: { feedbackId: feedbackId },
                    success: function (response) {
                        // Reload the page or update the table after successful deletion
                        location.reload();
                    },
                    error: function (error) {
                        console.error('Error deleting feedback:', error);
                        alert('Error deleting feedback. Please try again.');
                    }
                });
            }
        }
    </script>

</body>

</html>