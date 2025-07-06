<?php
require_once('../tcpdf/tcpdf.php');
include("../connection/connect.php");

if (isset($_GET['restaurant_id'])) {
    $restaurantId = $_GET['restaurant_id'];

    // Get restaurant details
    $restaurantSql = "SELECT * FROM restaurant WHERE rs_id = '$restaurantId'";
    $restaurantQuery = mysqli_query($db, $restaurantSql);
    $restaurant = mysqli_fetch_array($restaurantQuery);

    // Get orders for the selected restaurant with user details
    $orderSql = "SELECT users_orders.*, users.username, users.address
                FROM users_orders
                INNER JOIN users ON users_orders.u_id = users.u_id
                WHERE users_orders.rs_id = '$restaurantId' AND users_orders.status = 'closed'";
    $orderQuery = mysqli_query($db, $orderSql);

    // Create PDF
    $pdf = new TCPDF();
    $pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);
    $pdf->AddPage();

    // Add restaurant image to PDF above the name
    $imagePath = 'Res_img/' . $restaurant['image'];
    if (file_exists($imagePath)) {
        $pdf->Image($imagePath, 0, 0, 10, 10, 'JPG');
    }

    // Add restaurant details to PDF
    $pdf->SetFont('helvetica', 'B', 16);
    $pdf->Cell(0, 10, 'Restaurant: ' . $restaurant['title'], 0, 1, 'C');

    // Add table headers
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(20, 10, 'Order ID', 1);
    $pdf->Cell(40, 10, 'Username', 1);
    $pdf->Cell(30, 10, 'Title', 1);
    $pdf->Cell(30, 10, 'Quantity', 1);
    $pdf->Cell(30, 10, 'Price', 1);
    $pdf->Cell(40, 10, 'Address', 1);
    $pdf->Ln();

    // Add orders to PDF
    while ($order = mysqli_fetch_array($orderQuery)) {
        $pdf->Cell(20, 10, $order['o_id'], 1);
        $pdf->Cell(40, 10, $order['username'], 1);
        $pdf->Cell(30, 10, $order['title'], 1);
        $pdf->Cell(30, 10, $order['quantity'], 1);
        $pdf->Cell(30, 10, 'Rs ' . $order['price'], 1);

        // Use MultiCell for the address
        $pdf->MultiCell(40, 10, $order['address'], 1);
        $pdf->Ln();  // Move to the next row
    }

    // Output PDF
    $pdf->Output('restaurant_report_' . $restaurant['title'] . '.pdf', 'D');
} else {
    // Redirect or display an error message if restaurant_id is not set
    header('Location: index.php');
    exit();
}
?>
