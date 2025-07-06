<?php

// Include database connection
include("../connection/connect.php");

// Set the selected year to 2024
$selected_year = "2024";

// Query to fetch data for the selected year from users_orders table
$query = "SELECT MONTH(date) AS month, SUM(price) AS total_amount
          FROM users_orders
          WHERE YEAR(date) = '$selected_year' AND status = 'closed'
          GROUP BY MONTH(date)";
$result = mysqli_query($db, $query);

// Query to fetch data for the selected year from offline_orders table
$q = "SELECT MONTH(order_date) AS month, SUM(net_amount) AS total_amount
      FROM offline_orders
      WHERE YEAR(order_date) = '$selected_year' AND status = 'paid'
      GROUP BY MONTH(order_date)";
$res = mysqli_query($db, $q);

// Check if the queries were successful
if ($result === false || $res === false) {
    die("Database query failed. Error: " . mysqli_error($db));
}

// Initialize report_data array
$report_data = array_fill(0, 12, 0); // Initialize with zeros for all months

// Fetch data from users_orders table and populate report_data array
while ($row = mysqli_fetch_assoc($result)) {
    $month = $row['month'] - 1; // Adjust month index to match array index
    $report_data[$month] += $row['total_amount']; // Combine amounts for the same month
}

// Fetch data from offline_orders table and update report_data array
while ($row = mysqli_fetch_assoc($res)) {
    $month = $row['month'] - 1; // Adjust month index to match array index
    $report_data[$month] += $row['total_amount']; // Combine amounts for the same month
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
                <!-- Form for selecting year -->
                <form class="form-inline" action="" method="POST">
                    <div class="form-group">
                        <label for="select_year">Year</label>
                        <select class="form-control" name="select_year" id="select_year" disabled>
                            <!-- Only one option for 2024, selected by default -->
                            <option value="2024" selected>2024</option>
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
                                    <th>Month - Year</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Table data -->
                                <?php
                                // Loop to populate table rows with report data
                                $months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
                                for ($i = 0; $i < 12; $i++) {
                                    echo "<tr>";
                                    echo "<td>{$months[$i]} - $selected_year</td>";
                                    echo "<td>{$report_data[$i]} ₹</td>";
                                    echo "</tr>";
                                }
                                ?>
                                <tr>
                                    <th>Total Amount</th>
                                    <th>
                                        <?php
                                        // Calculate total amount
                                        if (isset($report_data)) {
                                            $total_amount = array_sum($report_data);
                                            echo $total_amount.' ₹'; // Display the combined total amount
                                        } else {
                                            echo "0";
                                        }
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
                <form action="pdf/generate_pdf.php" method="POST">
                    <input type="hidden" name="selected_year" value="<?php echo $selected_year; ?>">
                    <button type="submit" class="btn btn-primary">Download PDF Report</button>
                </form>
                <?php include("footer.php"); ?>
            </div>
            <!-- col-md-12 -->
            
        </div>
        <!-- /.row -->    
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->