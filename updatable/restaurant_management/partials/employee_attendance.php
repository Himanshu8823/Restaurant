<?php
// Start session
session_start();

// Check if user is logged in and rs_id is set in session
if (!isset($_SESSION['rs_id'])) {
    // Redirect user to login page or handle authentication as per your system
    header("Location: login.php");
    exit();
}

// Include database configuration
include("../connection/connect.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Process form data
    // Example: Attendance functionality
    // (You can add more attendance-related operations similarly)

    // Get employee ID and attendance status from form
    $employee_id = $_POST['employee_id'];
    $status = $_POST['status'];

    // Get current date
    $date = date("Y-m-d");

    // Check if attendance record already exists for the current date and employee
    $sql = "SELECT * FROM employee_attendance WHERE rs_id = ? AND employee_id = ? AND date = ?";
    $stmt = mysqli_prepare($db, $sql);
    mysqli_stmt_bind_param($stmt, "iis", $_SESSION['rs_id'], $employee_id, $date);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        // Update existing attendance record
        $sql = "UPDATE employee_attendance SET status = ? WHERE rs_id = ? AND employee_id = ? AND date = ?";
        $stmt = mysqli_prepare($db, $sql);
        mysqli_stmt_bind_param($stmt, "siss", $status, $_SESSION['rs_id'], $employee_id, $date);
        mysqli_stmt_execute($stmt);
        $success = "Attendance updated successfully";
        header("location:employee_attendance.php?rs_id=$rs_id");
    } else {
        // Insert new attendance record
        $sql = "INSERT INTO employee_attendance (rs_id, employee_id, date, status) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($db, $sql);
        mysqli_stmt_bind_param($stmt, "iiss", $_SESSION['rs_id'], $employee_id, $date, $status);
        mysqli_stmt_execute($stmt);
        $success = "Attendance recorded successfully";
        header("location:employee_attendance.php?rs_id=$rs_id");
    }

    // Close statement
    mysqli_stmt_close($stmt);
}

// Fetch employees belonging to the current restaurant from database
$rs_id = $_SESSION['rs_id']; // Get restaurant ID from session variable
$sql = "SELECT * FROM employees WHERE rs_id = ?";
$stmt = mysqli_prepare($db, $sql);
mysqli_stmt_bind_param($stmt, "i", $rs_id);
mysqli_stmt_execute($stmt);
$employees = mysqli_stmt_get_result($stmt);

// Fetch attendance records with employee names for the current restaurant
$sql = "SELECT ea.attendance_id, e.name as employee_name, ea.date, ea.status 
        FROM employee_attendance ea
        INNER JOIN employees e ON ea.employee_id = e.employee_id
        WHERE ea.rs_id = ?";
$stmt = mysqli_prepare($db, $sql);
mysqli_stmt_bind_param($stmt, "i", $rs_id);
mysqli_stmt_execute($stmt);
$attendance_result = mysqli_stmt_get_result($stmt);

// Close statement
mysqli_stmt_close($stmt);

// Include header and sidebar files
include("hel.php");
include("header.php");
include("header_menu.php");
include("sidebar.php");
?>

<head>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <!-- DataTables Buttons CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    <!-- Select2 CSS -->
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

        /* Set the width of the Select2 container to 100% */
        /* Set the width of the Select2 container to 100% */
        .select2-container {
            width: 100% !important;
        }

        /* Set the width of the Select2 dropdown to match its container */
        .select2-dropdown {
            max-width: 100% !important;
        }
    </style>
</head>
<div class="wrapper">
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Manage Employee Attendance</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Employee Attendance</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container box mt-5">
                <h3 class="mb-4">Record Attendance</h3>
                <?php if (isset($success)) { ?>
                    <div class="alert alert-success">
                        <?php echo $success; ?>
                    </div>
                <?php } ?>
                <!-- Attendance Form -->
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="mb-3 form-group">
                        <label for="employee_id" class="form-label">Select Employee:</label>
                        <select class="form-control select2" id="employee_id" name="employee_id" required>
                            <option value="">Select Employee</option>
                            <?php
                            // Display employees in dropdown
                            while ($row = mysqli_fetch_assoc($employees)) {
                                echo "<option value='" . $row['employee_id'] . "'>" . $row['name'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3 form-group">
                        <label for="status" class="form-label">Attendance Status:</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="">Select Status</option>
                            <option value="Present">Present</option>
                            <option value="Absent">Absent</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary" name="submit">Submit Attendance</button>
                </form>
                <hr>
                <!-- Attendance Records Table -->
                <h2 class="mt-4">Attendance Records</h2>
                <div class="table-responsive">
                    <table id="attendanceTable" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Employee Name</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($row = mysqli_fetch_assoc($attendance_result)) {
                                echo "<tr>";
                                echo "<td>" . $row['attendance_id'] . "</td>";
                                echo "<td>" . $row['employee_name'] . "</td>";
                                echo "<td>" . $row['date'] . "</td>";
                                echo "<td>" . $row['status'] . "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>  
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php include("footer.php"); ?>
</div>
</body>
<!-- ./wrapper -->

<!-- Include footer -->


<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<!-- DataTables Buttons JS -->
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
<!-- Select2 JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
    $(document).ready(function () {
        // Initialize Select2 for the employee dropdown
        $('.select2').select2();

        // Initialize DataTable for attendance table
        $('#attendanceTable').DataTable({
            dom: 'Bfrtip', // Add buttons to the table
            buttons: [
                'copy', 'csv', 'pdf', 'print' // Define buttons for copy, CSV export, PDF export, and print
            ]
        });
    });
</script>