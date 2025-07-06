<?php
// Start session
session_start();

// Check if username is not set in session, redirect to login page
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}
$rs_id = $_SESSION['rs_id'];
// Include database configuration
include("../connection/connect.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $employee_id = $_POST['employee_id'];
    $month = $_POST['month'];
    $year = $_POST['year'];
    $salary = $_POST['salary'];

    // Insert payroll data into database
    $sql = "INSERT INTO employee_payroll (rs_id, employee_id, month, year, salary) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($db, $sql);
    mysqli_stmt_bind_param($stmt, "iiiii", $_SESSION['rs_id'], $employee_id, $month, $year, $salary);
    mysqli_stmt_execute($stmt);

    // Check if insertion was successful
    if (mysqli_stmt_affected_rows($stmt) > 0) {
        $success = "Payroll data inserted successfully";
        header("location:employee_payroll.php?rs_id=$rs_id");
    } else {
        $error = "Failed to insert payroll data";
    }

    // Close statement
    mysqli_stmt_close($stmt);
}

// Fetch employees belonging to the current restaurant from the database
$sql = "SELECT * FROM employees WHERE rs_id = ?";
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
        .buttons-copy:hover,
        .buttons-csv:hover,
        .buttons-pdf:hover,
        .buttons-print:hover {
            background-color: darkgreen;
            /* Darker background color on hover */
        }

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
            <h1>Employee Payroll</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Employee Payroll</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container box mt-5">
                <h2 class="mb-4">Add Payroll</h2>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="mb-3 form-group">
                        <label for="employee_id" class="form-label">Select Employee:</label>
                        <select class="form-select" id="employee_id" name="employee_id" required>
                            <option value="">Select Employee</option>
                            <?php
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='" . $row['employee_id'] . "'>" . $row['name'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3 form-group">
                        <label for="month" class="form-label">Month:</label>
                        <select class="form-select" id="month" name="month" required>
                            <option value="">Select Month</option>
                            <?php
                            // Array of months
                            $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");

                            // Loop through months to generate options
                            foreach ($months as $index => $month) {
                                // Set the default selected month
                                $selected = ($index + 1 == date('n')) ? 'selected' : '';
                                echo "<option value='" . ($index + 1) . "' $selected>" . $month . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3 form-group">
                        <label for="year" class="form-label">Year:</label>
                        <select class="form-select" id="year" name="year" required>
                            <option value="">Select Year</option>
                            <?php
                            // Set the default selected year
                            $currentYear = date('Y');
                            $startYear = $currentYear - 10;
                            $endYear = $currentYear + 10;
                            for ($i = $startYear; $i <= $endYear; $i++) {
                                $selected = ($i == $currentYear) ? 'selected' : '';
                                echo "<option value='$i' $selected>$i</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3 form-group">
                        <label for="salary" class="form-label">Salary:</label>
                        <input type="number" class="form-control" id="salary" name="salary" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a class="btn btn-primary" href="employee_salary.php?rs_id=<?php echo $rs_id; ?>">Calculate Salary</a>
                </form>
                <?php if (isset($success)) { ?>
                    <div class="mt-4">
                        <div class="alert alert-success" role="alert">
                            <?php echo $success; ?>
                        </div>
                    </div>
                <?php } ?>
                <?php if (isset($error)) { ?>
                    <div class="mt-4">
                        <div class="alert alert-danger" role="alert">
                            <?php echo $error; ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <!-- Display Payroll Table -->
            <div class="container table-responsive box mt-5">
                <h2 class="mb-4">Payroll List</h2>
                <table id="payrollTable" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Payroll ID</th>
                            <th>Employee ID</th>
                            <th>Month</th>
                            <th>Year</th>
                            <th>Salary</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Include database configuration
                        include("../connection/connect.php");

                        // Fetch payroll data from the database
                        $sql = "SELECT ep.*, e.name AS employee_name
                                FROM employee_payroll AS ep
                                INNER JOIN employees AS e ON ep.employee_id = e.employee_id
                                WHERE ep.rs_id = ?";

                        $stmt = mysqli_prepare($db, $sql);
                        mysqli_stmt_bind_param($stmt, "i", $_SESSION['rs_id']);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);

                        // Display payroll data in table rows
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $row['payroll_id'] . "</td>";
                                echo "<td>" . $row['employee_name'] . "</td>";
                                echo "<td>" . $row['month'] . "</td>";
                                echo "<td>" . $row['year'] . "</td>";
                                echo "<td>" . $row['salary'] . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>No payroll data found</td></tr>";
                        }

                        // Close statement
                        mysqli_stmt_close($stmt);

                        // Close connection
                        mysqli_close($db);
                        ?>
                    </tbody>
                </table>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php include("footer.php"); ?>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>

<!-- Custom script for initializing DataTable and Select2 -->
<script>
    $(document).ready(function () {
        // Initialize Select2 for employee selection
        $('#employee_id').select2();
        $('#month').select2({
            placeholder: 'Select Month',

        });

        // Initialize Select2 for year selection
        $('#year').select2({
            placeholder: 'Select Year',

        });

        // Initialize DataTable for payroll table
        $('#payrollTable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'pdf', 'print'
            ]
        });
    });
</script>
</body>

</html>