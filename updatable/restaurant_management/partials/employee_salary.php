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
    $salary_per_day = $_POST['salary_per_day'];

    // Fetch employee's attendance from the database for the selected month and year
    $sql = "SELECT COUNT(*) AS days_present FROM employee_attendance WHERE employee_id = ? AND MONTH(date) = ? AND YEAR(date) = ?";
    $stmt = mysqli_prepare($db, $sql);
    mysqli_stmt_bind_param($stmt, "iii", $employee_id, $month, $year);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    $days_present = $row['days_present'];

    // Calculate salary based on attendance
    $total_salary = $days_present * $salary_per_day;
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
include("hel.php");
include('header_menu.php');
include('header.php');
include('sidebar.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Salary</title>
    <!-- Include CSS stylesheets if needed -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
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
        #month,#year {
            width: 100% !important;
            border: 1px solid silver;
            font-size: 18px;
        }
    </style>
</head>

    <div class="wrapper">
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>Employee Salary</h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Employee Salary</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container box mt-5">
                    <h2 class="mb-4">Calculate Salary</h2>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?rs_id=' . $rs_id; ?>"
                        method="post">
                        <div class="mb-3 form-group">
                            <label for="employee_id" class="form-label">Select Employee:</label>
                            <select class="form-select select2" id="employee_id" name="employee_id" required>
                                <option value="">Select Employee</option>
                                <?php
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<option value='" . $row['employee_id'] . "'>" . $row['name'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3 form-group">
                            <label for="salary_per_day" class="form-label">Enter Salary per Day:</label>
                            <input type="number" class="form-control" id="salary_per_day" name="salary_per_day"
                                placeholder="Enter Salary per Day" required>
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
                        </div>
                        &nbsp;<button type="submit" class="btn btn-primary">Calculate Salary</button>
                        <a class="btn btn-primary" href="employee_payroll.php?rs_id=<?php echo $rs_id; ?>">Payroll</a>
                    </form>
                    <?php if (isset($total_salary)) { ?>
                        <div class="mt-4">
                            <div class="alert alert-success" role="alert">
                                Total Salary: ₹
                                <?php echo $total_salary; ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <!-- Include footer file -->
        <?php include("footer.php"); ?>
    </div>
    <!-- ./wrapper -->
    <!-- Include JavaScript files -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
                        
    <script>
        $(document).ready(function () {
            $('.select2').select2();
        });
    </script>
</body>

</html>