<?php
session_start();

// Redirect to login page if user is not logged in
if (!isset($_SESSION['manager'])&&!isset($_SESSION['username'])&&!isset($_SESSION['cashier'])) {
    header("Location: ../login.php");
    exit();
}

// Include database connection
include("../connection/connect.php");

// Fetch all customers for managing attendance
$rs_id = $_SESSION['rs_id'];
$customers_query = "SELECT * FROM mess_customers WHERE rs_id = $rs_id";
$customers_result = mysqli_query($db, $customers_query);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Iterate through each customer to update attendance
    while ($row = mysqli_fetch_assoc($customers_result)) {
        $customer_id = $row['customer_id'];
        $attendance_status = $_POST['attendance_status'][$customer_id];

        // Insert or update attendance record in the database for the current date
        $attendance_query = "INSERT INTO attendance (customer_id, attendance_date, attendance_status) 
                             VALUES ($customer_id, CURDATE(), '$attendance_status')
                             ON DUPLICATE KEY UPDATE attendance_status = '$attendance_status'";
        mysqli_query($db, $attendance_query);
    }

    // Redirect back to mess_attendance.php after updating attendance
    header("Location: mess_attendance.php?rs_id=$rs_id");
    exit();
}

// Include header, menu, and sidebar files
include("hel.php");
include('header_menu.php');
include('header.php');
include('sidebar.php');
?>

<head>
    <!-- Add DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <!-- Add DataTables Buttons CSS -->
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
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
            <h1>Manage Attendance</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Manage Attendance</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Attendance Records</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <!-- Form to take attendance -->
                    <form method="post" action="">
                        <table id="attendanceTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Customer ID</th>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Phone Number</th>
                                    <th>Attendance Status for
                                        <?php echo date("Y-m-d"); ?>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = mysqli_fetch_assoc($customers_result)): ?>
                                    <tr>
                                        <td>
                                            <?php echo $row['customer_id']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['full_name']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['email']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['phone_number']; ?>
                                        </td>
                                        <td>
                                            <select class="form-control"
                                                name="attendance_status[<?php echo $row['customer_id']; ?>]">
                                                <option value="Present">Present</option>
                                                <option value="Absent">Absent</option>
                                            </select>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                        <button type="submit" class="btn btn-primary" name="submit">Submit Attendance for
                            <?php echo date("Y-m-d"); ?>
                        </button>
                    </form>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->

            <!-- Attendance Report -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Attendance Report for
                        <?php echo date("F Y"); ?>
                    </h3>
                </div>
                <div class="box-body table-responsive">
                    <table id="attendanceReportTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Customer ID</th>
                                <th>Full Name</th>
                                <th>Attendance Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Fetch attendance records for the current month
                            $current_month = date('Y-m');
                            $attendance_query = "SELECT a.attendance_date, c.customer_id, c.full_name, a.attendance_status
                                     FROM attendance a
                                     INNER JOIN mess_customers c ON a.customer_id = c.customer_id
                                     WHERE a.attendance_date LIKE '$current_month%'
                                     ORDER BY a.attendance_date DESC";
                            $attendance_result = mysqli_query($db, $attendance_query);

                            // Output attendance records
                            while ($attendance_row = mysqli_fetch_assoc($attendance_result)):
                                ?>
                                <tr>
                                    <td>
                                        <?php echo $attendance_row['attendance_date']; ?>
                                    </td>
                                    <td>
                                        <?php echo $attendance_row['customer_id']; ?>
                                    </td>
                                    <td>
                                        <?php echo $attendance_row['full_name']; ?>
                                    </td>
                                    <td>
                                        <?php echo $attendance_row['attendance_status']; ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Include your footer -->
    <?php include("footer.php"); ?>
</div>
<!-- ./wrapper -->

<!-- Add your scripts here -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>

<script>
    $(document).ready(function () {
        // Initialize DataTable with buttons for attendance table
        $('#attendanceTable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'pdf', 'print'
            ]
        });

        // Initialize DataTable for attendance report table
        $('#attendanceReportTable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'pdf', 'print'
            ]
        });

        
    });
</script>

</body>

</html>