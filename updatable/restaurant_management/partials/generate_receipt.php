<?php
// Include database connection
include("../connection/connect.php");

// Check if payment ID is provided in the URL
if (!isset($_GET['payment_id'])) {
    header("Location: view_payments.php");
    exit();
}

// Fetch payment details from the database
$payment_id = $_GET['payment_id'];
$payment_query = "SELECT p.payment_id, c.full_name AS customer_name, c.email AS customer_email, c.phone_number AS customer_phone, p.payment_date, p.payment_status, p.payment_amount 
                    FROM payments p 
                    INNER JOIN mess_customers c ON p.customer_id = c.customer_id 
                    WHERE p.payment_id = $payment_id";
$payment_result = mysqli_query($db, $payment_query);

// Check if payment exists
if (mysqli_num_rows($payment_result) == 0) {
    header("Location: view_payments.php");
    exit();
}

// Fetch payment details
$payment_row = mysqli_fetch_assoc($payment_result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            padding: 20px;
        }
        .receipt {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .receipt-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .receipt-info {
            margin-bottom: 30px;
        }
        .receipt-info p {
            margin: 5px 0;
            font-size: 16px;
        }
        .btn-print {
            float: right;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="receipt">
            <div class="receipt-header">
                <h1 class="mb-4">Payment Receipt</h1>
            </div>
            <div class="receipt-info">
                <p><strong>Payment ID:</strong> <?php echo $payment_row['payment_id']; ?></p>
                <p><strong>Customer Name:</strong> <?php echo $payment_row['customer_name']; ?></p>
                <p><strong>Email:</strong> <?php echo $payment_row['customer_email']; ?></p>
                <p><strong>Phone Number:</strong> <?php echo $payment_row['customer_phone']; ?></p>
                <p><strong>Payment Date:</strong> <?php echo $payment_row['payment_date']; ?></p>
                <p><strong>Payment Amount:</strong> $<?php echo $payment_row['payment_amount']; ?></p>
                <p><strong>Payment Status:</strong> <?php echo $payment_row['payment_status']; ?></p>
            </div>
            <button class="btn btn-primary btn-print" onclick="this.style='display:none';window.print()">Print Receipt</button>
            <div class="clearfix"></div>
        </div>
    </div>
</body>
</html>
