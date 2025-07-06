<?php
require_once('../../../tcpdf/tcpdf.php'); // Include TCPDF library

// Include database connection
include("../../connection/connect.php");

// Retrieve selected year from POST data
$selected_year = $_POST['selected_year'];

// Query to fetch data for selected year from users_orders table
$query_users_orders = "SELECT MONTH(date) AS month, SUM(price) AS total_amount
                      FROM users_orders
                      WHERE YEAR(date) = '$selected_year' AND status = 'closed'
                      GROUP BY MONTH(date)";
$result_users_orders = mysqli_query($db, $query_users_orders);

// Query to fetch data for selected year from offline_orders table
$query_offline_orders = "SELECT MONTH(order_date) AS month, SUM(net_amount) AS total_amount
                        FROM offline_orders
                        WHERE YEAR(order_date) = '$selected_year' AND status = 'paid'
                        GROUP BY MONTH(order_date)";
$result_offline_orders = mysqli_query($db, $query_offline_orders);

// Combine data from both tables
$combined_data = array_fill(0, 12, 0); // Initialize with zeros for all months
while ($row = mysqli_fetch_assoc($result_users_orders)) {
    $month = $row['month'] - 1; // Adjust month index to match array index
    $combined_data[$month] += $row['total_amount']; // Add amount from users_orders
}
while ($row = mysqli_fetch_assoc($result_offline_orders)) {
    $month = $row['month'] - 1; // Adjust month index to match array index
    $combined_data[$month] += $row['total_amount']; // Add amount from offline_orders
}

// Create a new PDF instance
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Monthly Income Report');

// Add a page
$pdf->AddPage();

// Set font
$pdf->SetFont('helvetica', '', 12);

// Generate PDF content
$html = '<h1>Monthly Income Report - Year ' . $selected_year . '</h1>';
$html .= '<table border="1" cellspacing="0" cellpadding="5">
            <thead>
                <tr>
                    <th>Month</th>
                    <th>Income</th>
                </tr>
            </thead>
            <tbody>';
$total_income = 0;
$months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
foreach ($combined_data as $month => $income) {
    $html .= '<tr>
                <td>' . $months[$month] . '</td>
                <td>' . $income . '</td>
              </tr>';
    $total_income += $income;
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
$pdf->Output('monthly_income_report.pdf', 'D'); // D for download
?>
