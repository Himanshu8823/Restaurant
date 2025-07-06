<?php
// Start session
session_start();

// Include database configuration
include("../connection/connect.php");

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect user to login page or handle authentication as per your system
    header("Location: login.php");
    exit();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Process form data
    // Example: Leave allowance functionality

    // Get form data
    $employee_id = $_POST['employee_id'];
    $date = $_POST['date'];
    $annual_leave_count = $_POST['annual_leave_count'];

    // Check if leave allowance record already exists for the current employee and year
    $sql = "SELECT * FROM employee_leave_allowance WHERE employee_id = ? AND date = ?";
    $stmt = mysqli_prepare($db, $sql);
    mysqli_stmt_bind_param($stmt, "is", $employee_id, $date);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $rs_id=$_SESSION['rs_id'];
    if (mysqli_num_rows($result) > 0) {
        // Update existing leave allowance record
        $sql = "UPDATE employee_leave_allowance SET annual_leave_count = ? WHERE employee_id = ? AND date = ?";
        $stmt = mysqli_prepare($db, $sql);
        mysqli_stmt_bind_param($stmt, "iis", $annual_leave_count, $employee_id, $date);
        mysqli_stmt_execute($stmt);
        $success = "Leave allowance updated successfully";
    } else {
        // Insert new leave allowance record
        $sql = "INSERT INTO employee_leave_allowance (rs_id, employee_id, date, annual_leave_count) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($db, $sql);
        mysqli_stmt_bind_param($stmt, "iisi", $_SESSION['rs_id'], $employee_id, $date, $annual_leave_count);
        mysqli_stmt_execute($stmt);
        $success = "Leave allowance recorded successfully";
        header("location:leave_allowance.php?rs_id=$rs_id");
    }

    // Close statement
    mysqli_stmt_close($stmt);
}

// Fetch employees belonging to the current restaurant from database
$sql = "SELECT * FROM employees";
$result = mysqli_query($db, $sql);

// Fetch attendance records with employee names for the current restaurant
$rs_id = $_SESSION['rs_id']; // Get restaurant ID from session variable
$sql = "SELECT ea.attendance_id, e.name as employee_name, ea.date, ea.status 
        FROM employee_attendance ea
        INNER JOIN employees e ON ea.employee_id = e.employee_id
        WHERE ea.rs_id = ?";
$stmt = mysqli_prepare($db, $sql);
mysqli_stmt_bind_param($stmt, "i", $rs_id);
mysqli_stmt_execute($stmt);
$attendance_result = mysqli_stmt_get_result($stmt);

// Include header and sidebar files
include("hel.php");
include("header.php");
include("header_menu.php");
include("sidebar.php");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Employee Leave Allowance</title>
    <!-- Bootstrap CSS -->
    <!-- Select2 CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
</head>
<body>
<div class="wrapper">
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Manage Employee Leave Allowance</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Employee Leave Allowance</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="box #container mt-5">
                <h2 class="mb-4">Manage Employee Leave Allowance</h2>
                <?php if (isset($success)) { ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                <?php } ?>
                <!-- Leave Allowance Form -->
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="mb-3 form-group">
                        <label for="employee_id" class="form-label">Select Employee:</label>
                        <select class="form-control select2" id="employee_id" name="employee_id" required>
                            <option value="">Select Employee</option>
                            <?php
                            // Display employees in dropdown
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='" . $row['employee_id'] . "'>" . $row['name'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3 form-group">
    <label for="date" class="form-label">Date:</label>
    <input type="date" class="form-control" id="date" name="date" required>
</div>

                    <div class="mb-3 form-group">
                        <label for="annual_leave_count" class="form-label">Annual Leave Count:</label>
                        <input type="number" class="form-control" id="annual_leave_count" name="annual_leave_count" required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="submit">Record Leave Allowance</button>
                </form>
            </div>
        </section>
        <!-- /.content -->

    <!-- Leave Allowance Records Table -->
<section class="content">
    <div class="container box mt-5">
        <h3 class="mb-4">Leave Allowance Records</h3>
        <div class="table-responsive">
            <table id="leaveAllowanceTable" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Employee Name</th>
                        <th>Date</th>
                        <th>Annual Leave Count</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch leave allowance records
                    $sql = "SELECT * FROM employee_leave_allowance";
                    $result = mysqli_query($db, $sql);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['leave_id'] . "</td>"; // Change 'id' to the appropriate column name
                        $emp=$row['employee_id'];
                        $query="SELECT * FROM employees WHERE employee_id=$emp";
                        $res=mysqli_query($db,$query);
                        while($rows=mysqli_fetch_assoc($res)){                        
                        echo "<td>" . $rows['name'] . "</td>"; // Change 'employee_name' to the appropriate column name
                        }
                        echo "<td>" . $row['date'] . "</td>"; // Change 'date' to the appropriate column name
                        echo "<td>" . $row['annual_leave_count'] . "</td>";
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
