<?php
// Start session
session_start();

// Check if username is not set in session, redirect to login page
if (!isset($_SESSION['manager'])&&!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}

// Include database configuration
include("../connection/connect.php");

// Fetch feedback data from the database
$sql = "SELECT * FROM feedback WHERE rs_id = ?";
$stmt = mysqli_prepare($db, $sql);
mysqli_stmt_bind_param($stmt, "i", $_SESSION['rs_id']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Close statement
mysqli_stmt_close($stmt);

// Close connection
mysqli_close($db);

// Include header and sidebar files
include("hel.php");
include('header_menu.php');
include('header.php');
include('sidebar.php');
?>

<head>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <!-- DataTables Buttons CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    <style>
        .buttons-copy,
        .buttons-csv,
        .buttons-pdf,
        .buttons-print {
            background-color: green !important;
            /* Background color */
            color: white !important;
            /* Text color */
            border: none;
            /* Remove border */
        }

        /* Hover effect */
        .buttons-copy:hover,
        .buttons-csv:hover,
        .buttons-pdf:hover,
        .buttons-print:hover {
            background-color: darkgreen;
            /* Darker background color on hover */
        }
    </style>
</head>

<div class="wrapper">
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>User Feedback</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">User Feedback</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container box mt-5 table-responsive">
                <h2 class="mb-4">Feedback List</h2>
                <table id="feedbackTable" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Rating</th>
                            <th>Message</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Display feedback data in table rows
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $row['id'] . "</td>";
                                echo "<td>" . $row['name'] . "</td>";
                                echo "<td>" . $row['feedback_email'] . "</td>";
                                echo "<td>" . $row['rating'] . "</td>";
                                echo "<td>" . $row['message'] . "</td>";
                                echo "<td>" . $row['submission_date'] . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>No feedback data found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
</div>
<!-- ./wrapper -->

<!-- Include necessary JavaScript libraries -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-1y7VlfF4d02F7fRS1Q9yb8ivu6D5sqU4RbdYZrP8XyJ2t7ugFyzjaP+x5Vc2sZbT"
    crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>

<!-- Custom script for initializing DataTable -->
<script>
    $(document).ready(function () {
        // Initialize DataTable for feedback table
        $('#feedbackTable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'pdf', 'print'
            ]
        });
    });
</script>
</body>

</html>
