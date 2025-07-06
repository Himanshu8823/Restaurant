<?php
require_once('../../../tcpdf/tcpdf.php'); // Include TCPDF library

// Include database connection
include("../../connection/connect.php");

// Retrieve selected year and month from POST data
$selected_year = $_POST['selected_year'];
$selected_month = $_POST['selected_month'];

// Calculate the number of days in the selected month
$num_days_in_month = cal_days_in_month(CAL_GREGORIAN, $selected_month, $selected_year);

// Calculate the number of weeks in the selected month
$num_weeks_in_month = ceil($num_days_in_month / 7);

// Create a new PDF instance
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Weekly Income Report');

// Add a page
$pdf->AddPage();

// Set font
$pdf->SetFont('helvetica', '', 12);

// Generate PDF content
$html = '<h1>Weekly Income Report - ' . date("F", mktime(0, 0, 0, $selected_month, 1)) . ' ' . $selected_year . '</h1>';
$html .= '<table border="1" cellspacing="0" cellpadding="5">
            <thead>
                <tr>
                    <th>Week</th>
                    <th>Income</th>
                </tr>
            </thead>
            <tbody>';
$total_income = 0;
for ($week = 1; $week <= $num_weeks_in_month; $week++) {
    // Calculate start and end dates for the week
    $start_date = date('Y-m-d', strtotime("{$selected_year}-{$selected_month}-01 +".(($week-1)*7)." days"));
    $end_date = date('Y-m-d', strtotime("{$selected_year}-{$selected_month}-01 +".$week*7 ." days"));

    // Query to fetch data for the selected week from users_orders table
    $query_users_orders = "SELECT SUM(price * quantity) AS weekly_income
                           FROM users_orders
                           WHERE date >= '$start_date' AND date <= '$end_date' AND status = 'closed'";
    $result_users_orders = mysqli_query($db, $query_users_orders);
    $row_users_orders = mysqli_fetch_assoc($result_users_orders);
    $income = $row_users_orders['weekly_income'];

    // Query to fetch data for the selected week from offline_orders table
    $query_offline_orders = "SELECT SUM(net_amount) AS weekly_income
                             FROM offline_orders
                             WHERE order_date >= '$start_date' AND order_date <= '$end_date' AND status = 'paid'";
    $result_offline_orders = mysqli_query($db, $query_offline_orders);
    $row_offline_orders = mysqli_fetch_assoc($result_offline_orders);
    $income += $row_offline_orders['weekly_income'];

    // Add income to total
    $total_income += $income;

    // Add row to PDF content
    $html .= '<tr>
                <td>Week ' . $week . '</td>
                <td>' . $income . '</td>
              </tr>';
}
$html .= '</tbody>
            <tfoot>
                <tr>
                    <th>Total Income</th>
                    <th>' . $total_income . '</th>
                </tr>
            </tfoot>
          </table>';

// Output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// Close and output PDF document
$pdf->Output('weekly_income_report.pdf', 'D'); // D for download
?>
