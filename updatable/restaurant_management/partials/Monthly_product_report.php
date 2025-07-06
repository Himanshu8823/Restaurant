<?php

// Include database connection
include("../connection/connect.php");

// Initialize variables for selected year and month
$selected_year = isset($_POST['select_year']) ? $_POST['select_year'] : date('Y');
$selected_month = isset($_POST['select_month']) ? $_POST['select_month'] : date('m');

// Calculate the number of days in the selected month
$num_days_in_month = cal_days_in_month(CAL_GREGORIAN, $selected_month, $selected_year);

// Calculate the number of weeks in the selected month
$num_weeks_in_month = ceil($num_days_in_month / 7);

// Define an array to hold weekly income
$weekly_income = array_fill(0, $num_weeks_in_month, 0); // Initialize with zeros for all weeks

// Loop through each week of the month
for ($week = 1; $week <= min($num_weeks_in_month, 4); $week++) {
    // Calculate start and end dates for the week
    $start_date = date('Y-m-d', strtotime("{$selected_year}-{$selected_month}-01 +".(($week-1)*7)." days"));
    $end_date = date('Y-m-d', strtotime("{$selected_year}-{$selected_month}-01 +".$week*7 ." days"));

    // Check if the selected month is February and the week is beyond the fourth week
    if ($selected_month == 2 && $week > 4) {
        break; // Exit the loop if beyond the fourth week in February
    }

    // Query to fetch data for the selected week from users_orders table
    $query_users = "SELECT SUM(price * quantity) AS weekly_income
                    FROM users_orders
                    WHERE date >= '$start_date' AND date <= '$end_date' AND status = 'closed'";
    $result_users = mysqli_query($db, $query_users);
    $row_users = mysqli_fetch_assoc($result_users);
    $weekly_income[$week - 1] += $row_users['weekly_income'];

    // Query to fetch data for the selected week from offline_orders table
    $query_offline = "SELECT SUM(net_amount) AS weekly_income
                      FROM offline_orders
                      WHERE order_date >= '$start_date' AND order_date <= '$end_date' AND status = 'paid'";
    $result_offline = mysqli_query($db, $query_offline);
    $row_offline = mysqli_fetch_assoc($result_offline);
    $weekly_income[$week - 1] += $row_offline['weekly_income'];
}

// Include other necessary files
include("hel.php");
include('header_menu.php');
include('header.php');
include('sidebar.php');

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Reports</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Reports</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <!-- Form for selecting year and month -->
                <form class="form-inline" action="" method="POST">
                    <div class="form-group">
                        <label for="select_year">Year</label>
                        <select class="form-control" name="select_year" id="select_year">
                            <?php
                            // Generate options for years
                            for ($i = date('Y'); $i >= 2000; $i--) {
                                echo "<option value='$i'";
                                if ($selected_year == $i) echo " selected";
                                echo ">$i</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="select_month">Month</label>
                        <select class="form-control" name="select_month" id="select_month">
                            <?php
                            // Generate options for months
                            for ($m = 1; $m <= 12; $m++) {
                                $month_name = date("F", mktime(0, 0, 0, $m, 1));
                                echo "<option value='$m'";
                                if ($selected_month == $m) echo " selected";
                                echo ">$month_name</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-default">Submit</button>
                </form>
            </div>

            <br /> <br />

            <div class="col-md-12 col-xs-12">
                <!-- Table to display report data -->
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Total Paid Orders - Report Data</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="datatables" class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>Week</th>
                                    <th>Income</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Table data -->
                                <?php
                                // Loop to populate table rows with weekly income data
                                for ($week = 1; $week <= min($num_weeks_in_month, 4); $week++) {
                                    echo "<tr>";
                                    echo "<td>Week $week</td>";
                                    echo "<td>{$weekly_income[$week - 1]} ₹</td>";
                                    echo "</tr>";
                                }
                                ?>
                                <tr>
                                    <th>Total Amount</th>
                                    <th>
                                        <?php
                                        // Calculate total amount
                                        $total_amount = array_sum($weekly_income);
                                        echo $total_amount . ' ₹'; // Display the combined total amount
                                        ?>
                                    </th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
                <!-- Button to download PDF -->
                <form action="pdf/generate_monthly_report_pdf.php" method="POST">
                    <input type="hidden" name="selected_year" value="<?php echo $selected_year; ?>">
                    <input type="hidden" name="selected_month" value="<?php echo $selected_month; ?>">
                    <button type="submit" class="btn btn-primary">Download PDF Report</button>
                </form>
            </div>
            <!-- col-md-12 -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
