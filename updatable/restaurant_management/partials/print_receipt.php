<?php
session_start();
include("../connection/connect.php");

if (!isset($_SESSION['manager'])&&!isset($_SESSION['username'])&&!isset($_SESSION['cashier'])) {
    header("Location: ../login.php");
    exit();
}

if (!isset($_GET['rs_id']) || !isset($_GET['order_id'])) {
    // Redirect if rs_id or order_id is not provided
    header("Location: orders_show.php?error=1");
    exit();
}

$rs_id = $_GET['rs_id'];
$order_id = $_GET['order_id'];

// Fetch order details from the database including restaurant name and address
$sql = "SELECT o.order_id, d.title AS dish_name, r.title AS restaurant_name, r.address AS restaurant_address, 
               o.order_date, o.quantity, o.gross_amount, o.discount, o.net_amount,o.name
        FROM offline_orders o 
        JOIN dishes d ON o.d_id = d.d_id
        JOIN restaurant r ON o.rs_id = r.rs_id
        WHERE o.order_id = ? AND o.rs_id = ?";
$stmt = mysqli_prepare($db, $sql);
mysqli_stmt_bind_param($stmt, "ii", $order_id, $rs_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result || mysqli_num_rows($result) != 1) {
    // Redirect if order not found
    header("Location: orders_show.php?rs_id=$rs_id&error=1");
    exit();
}

$order = mysqli_fetch_assoc($result);

// Update the status to 'paid'
$updateStatusSql = "UPDATE offline_orders SET status = 'paid' WHERE order_id = ?";
$updateStatusStmt = mysqli_prepare($db, $updateStatusSql);
mysqli_stmt_bind_param($updateStatusStmt, "i", $order_id);
mysqli_stmt_execute($updateStatusStmt);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Receipt</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            padding: 20px;
        }

        .container {
            max-width: 700px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border: 1px solid #dee2e6;
            border-radius: 5px;
        }

        .restaurant-info {
            text-align: center;
            margin-bottom: 20px;
        }

        .restaurant-name {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .restaurant-address {
            font-size: 14px;
            color: #666;
        }

        .bill-details {
            margin-bottom: 20px;
        }

        .item {
            margin-bottom: 10px;
        }

        .item-name {
            display: inline-block;
            width: 150px;
        }

        .item-price {
            float: right;
        }

        .total {
            font-weight: bold;
            font-size: 20px;
            border-top: 1px solid #dee2e6;
            padding-top: 10px;
            text-align: right;
        }

        .status {
            text-align: center;
            margin-top: 20px;
            font-weight: bold;
            color: green;
        }
        .item{
            padding-top: 10px;
            font-size: 20px;
        }
    </style>
</head>

<body>
    <div class="container"  style="border:2px solid green">
    <div class="restaurant-info">
        <h2 class="restaurant-name"><?php echo $order['restaurant_name']; ?></h2>
        <br>
        <span style="float:right">Date : <?php echo $order['order_date'];?> </span>
        <p class="restaurant-address"  style="margin-top:10%;:;margin-left:50%"><label style="color:black;font-style:bold;font-size:18px;padding-right:5px">Address : </label><?php echo $order['restaurant_address']; ?></p>
    </div>
    <div class="bill-details">
        <table class="table table-borderless">
            <div style="margin-left:10px;font-size:20px;"> Customer Name:<?php echo "<span style='padding-left:10px'>".$order['name']."</span>";?></div>
            <thead>
                <tr>
                    <th>Dish</th>
                    <th>Quantity</th>
                    <th>Gross Amount (Rs.)</th>
                    <th>Discount</th>
                    <th>Net Amount (Rs.)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo $order['dish_name']; ?></td>
                    <td><?php echo $order['quantity']; ?></td>
                    <td><?php echo $order['gross_amount']; ?></td>
                    <td><?php echo $order['discount']; ?></td>
                    <td><?php echo $order['net_amount']; ?></td>
                </tr>
                <!-- You can add more rows for additional items here if needed -->
            </tbody>
        </table>
    </div>
    <div class="total">Total: Rs. <?php echo $order['net_amount']; ?></div>
    <div class="status">Status: Paid</div>
    <div class="status" id="printButton"><button type="button" class="btn btn-success" onclick="window.print()">Print</button></div>
</div>

<style>
    @media print {
        #printButton {
            display: none;
        }
    }
</style>
</body>

</html>
