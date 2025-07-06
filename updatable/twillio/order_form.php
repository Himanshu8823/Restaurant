<!-- public/index.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
</head>
<body>
    <h1>Order Confirmation Page</h1>
    
    <!-- Your order form or UI here... -->

    <form action="process_order.php" method="post">
        <!-- Include form fields for order processing -->
        <input type="hidden" name="order_status" value="confirmed">
        <button type="submit">Confirm Order</button>
    </form>
</body>
</html>
