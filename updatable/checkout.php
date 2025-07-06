<?php 
   require_once __DIR__ . '/ratchet/vendor/autoload.php';   
    use Ratchet\Client\Connector;
    use Ratchet\Client\WebSocket;
    use React\EventLoop\Factory;
    require_once __DIR__ . '/twillio/whatsapp_order_confirmation.php';
    ?>
<!DOCTYPE html>
    <html lang="en">
        <style>
            /* Style for the centered modal */
.custom-modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.4);
}
p{
    font-size: 25px;
}
.modal-content {
    background-color: #fefefe;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    padding: 20px;
    border: 1px solid #888;
    width: 500px; /* Adjust the width based on your preference */
    max-width: 100%;
    text-align: center;
    
}
h1{
    font-size: 40px;
}
.close {
    color: #aaa;
    position: absolute;
    top: 10px;
    right: 15px;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
}

button {
    background-color: #4CAF50;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 3px;
    cursor: pointer;
    margin-top: 15px;
    margin-left: 25px;
    font-size: 20px;
}

button:hover {
    background-color: #45a049;
}

        </style>
    <?php
    
    include("connection/connect.php");
    include_once 'product-action.php';
    error_reporting(0);
    session_start();
    if(empty($_SESSION["user_id"]))
    {
        header('location:login.php');
    }
    // Initialize item_total
$item_total = 0;

// Check if the cart is empty
if (empty($_SESSION["cart_item"])) {
    // Redirect to a page indicating an empty cart
    header('location:empty_cart.php');
    exit();
}
    else{
        $user_id = $_SESSION["user_id"];
        $query = "SELECT * FROM users WHERE u_id = '$user_id'";
        $result = mysqli_query($db, $query);
        $user_info = mysqli_fetch_assoc($result);
    
        // Check if the user's address is not present
        if (empty($user_info['address'])) {
            echo '<div id="custom-modal" class="custom-modal">
                    <div class="modal-content">
                        <span class="close" onclick="closeModal()">&times;</span>
                        <h1>Address Information Missing</h1>
                        <p>Your address information is missing. Please fill it before proceeding to checkout.</p>
                        <button onclick="redirectToProfile()">Go to Profile</button>
                        <button onclick="redirectToRestaurants()">Continue to Restaurants</button>
                    </div>
                </div>';
            echo '<script>
                    document.addEventListener("DOMContentLoaded", function() {
                        document.getElementById("custom-modal").style.display = "block";
                    });
        
                    function closeModal() {
                        document.getElementById("custom-modal").style.display = "none";
                        // Redirect back to the previous page
                        history.go(-1);
                    }
        
                    function redirectToProfile() {
                        window.location.href = "profile.php";
                    }
        
                    function redirectToRestaurants() {
                        window.location.href = "restaurants.php";
                    }
                    
                    // Close the modal if the user clicks outside of it
                    window.onclick = function(event) {
                        var modal = document.getElementById("custom-modal");
                        if (event.target == modal) {
                            closeModal();
                        }
                    };
                  </script>';
            exit(); // Stop executing the rest of the code
        }

                                            
        $orderSuccess = false;

        foreach ($_SESSION["cart_item"] as $item) { 
            $item_total += ($item["price"] * $item["quantity"]);
    
            if ($_POST['submit']) {
                // Insert the order into the database
                $orderDescription = $_POST['description'];
                $SQL = "INSERT INTO users_orders(u_id, title, quantity, price, order_description) VALUES('".$_SESSION["user_id"]."', '".$item["title"]."', '".$item["quantity"]."', '".$item["price"]."', '$orderDescription')";
                mysqli_query($db, $SQL);
    
                // Notify admin through WhatsApp
                $adminPhoneNumber = 'admin_whatsapp_number'; // Replace with the actual admin WhatsApp number
    
                $orderDetailsText = "New Order Received:\n";
                foreach ($_SESSION["cart_item"] as $item) {
                    $orderDetailsText .= "- {$item['title']}, Quantity: {$item['quantity']}, Price: ₹{$item['price']}\n";
                }
                $orderDetailsText .= "Please confirm the order in 5 minutes for better user experience http://192.168.29.14:80/realtime/updatable/admin";
    
                // Send WhatsApp message
                sendWhatsAppMessage($adminPhoneNumber, $orderDetailsText);
    
                // Set the flag to true
                $orderSuccess = true;
            }
        }
    
        // Clear cart after successful checkout
        if ($orderSuccess) {
            $_SESSION["cart_item"] = array();
        }
    
        if ($orderSuccess) {
            // Display success message
            echo '<div id="success-dialog" class="custom-modal">
                    <div class="modal-content">
                        <span class="close" onclick="closeSuccessDialog()">&times;</span>
                        <h1>Thank you for your order!</h1>
                        <p>Your order has been placed successfully.</p>
                        <button onclick="redirectToHome()">Go to Home</button>
                    </div>
                </div>';
    
            echo '<script>
                    document.addEventListener("DOMContentLoaded", function() {
                        document.getElementById("success-dialog").style.display = "block";
                    });
    
                    function closeSuccessDialog() {
                        document.getElementById("success-dialog").style.display = "none";
                        // Redirect to home or any other page after closing the dialog
                        redirectToHome();
                    }
    
                    function redirectToHome() {
                        window.location.href = "index.php"; // Change the URL to your home page
                    }
                  </script>';
            
            exit(); // Stop executing the rest of the code
    }
    ?>
    <script>
    const socket = new WebSocket('ws://localhost:8080');

    // Connection opened
    socket.addEventListener('open', (event) => {
        console.log('WebSocket connection opened:', event);

        // Send order data to the admin page
    });

    // Listen for messages from the admin page
    socket.addEventListener('message', (event) => {
        console.log('Message from admin:', event.data);
        // Handle the received message as needed on the ordering page
    });

    // Connection closed
    socket.addEventListener('close', (event) => {
        console.log('WebSocket connection closed:', event);
    });

    
    function confirmOrder() {
    var flag = confirm('Are you sure?');
    if (flag) {
        const cartItems = <?php echo json_encode($_SESSION["cart_item"]); ?>;
        const orderDataArray = [];

        // Loop through cart items and create orderData for each item
        for (const itemId in cartItems) {
            const item = cartItems[itemId];
            const orderData = {
                id: item.d_id,
                product: item.title,
                price: item.price,
                quantity: item.quantity
            };

            orderDataArray.push(orderData);
        }

        // Send the array of orderData to the server
        socket.send(JSON.stringify(orderDataArray));
    }
    return flag;
}

                   
function updateOrderStatus(orderId, status) {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', `update_order_status.php?orderId=${orderId}&status=${status}`, true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                const response = xhr.responseText.trim();
                if (response === 'success') {
                    alert('Order status updated successfully!');
                    // You can perform additional actions or UI updates here if needed
                } else {
                    alert('Error updating order status. Please try again.');
                }
            } else {
                alert('Error communicating with the server. Please try again.');
            }
        }
    };

    xhr.send();
}

function handleButtonClick(orderId, status) {
    updateOrderStatus(orderId, status);
    // Handle the rest of your code (if any) based on the button click
}

    </script>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="#">
        <title>Starter Template for Bootstrap</title>
        <!-- Bootstrap core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/font-awesome.min.css" rel="stylesheet">
        <link href="css/animsition.min.css" rel="stylesheet">
        <link href="css/animate.css" rel="stylesheet">
        <!-- Custom styles for this template -->
        <link href="css/style.css" rel="stylesheet">
         
                          
    </head>
    <body>
        
        <div class="site-wrapper">
        
        <?php
            include("header.php");
        ?>
            <div class="page-wrapper">
                
                    <div class="container">
                    
                        <span style="color:green;">
                                    <?php echo $success;                                                                        
                                    ?>
                                            </span>
                        
                    </div>              
                <div class="container m-t-30">
                <form action="" method="post">
                    <div class="widget clearfix">
                        
                        <div class="widget-body">
                            <!-- Display details of the dishes -->
                <div class="row">
                    <div class="col-sm-12 table-responsive">
                        <h4>Ordered Dishes</h4>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Dish</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Sub Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include_once "product-action.php";
                                  foreach ($_SESSION["cart_item"] as $item) {
                                    $d_id = $item["d_id"];
                                    $query = "SELECT rs_id, img FROM dishes WHERE d_id = $d_id";
                                    $result = mysqli_query($db, $query);
                                    if ($result && mysqli_num_rows($result) > 0) {
                                        $row = mysqli_fetch_assoc($result);
                                        $image_url = $row['img'];
                                        $res_id = $row['rs_id'];
                                        
                                        echo '<tr>';                                        
                                        echo '<td><img src="admin/Res_img/dishes/' . $image_url . '" alt="' . $item["title"] . '" style="width: 100px; height: 50px;"></td>';
                                        echo '<td>' . $item["title"] . '</td>';
                                        echo '<td>' . $item["quantity"] . '</td>';
                                        echo '<td>' . '₹' . $item["price"]  . '</td>';
                                        echo '<td>' . '₹' . $item["price"] * $item["quantity"] . '</td>';
                                        echo '<td>'; // Start of new column for delete button
                                        echo '<a href="checkout.php?res_id='.$res_id.'&action=remove&id=' . $item["d_id"] . '">'; // Link to trigger remove action in product-action.php
                                        echo '<i class="fa fa-trash"></i>';
                                        echo '</a>';
                                        echo '</td>'; 
                                        echo '</tr>';
                                    } else {
                                        // Handle case where the dish with the specified ID is not found
                                    }
                                }                                
                                ?>
                                 <tr>
            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                                <div class="row">
                                    
                                    <div class="col-sm-12">
                                        <div class="cart-totals margin-b-20">
                                            <div class="cart-totals-title">
                                                <h4>Cart Summary</h4> </div>
                                            <div class="cart-totals-fields">
                                            
                                                <table class="table">
                                                <tbody>
                                            
                                                    
                                                
                                                        <tr>
                                                            <td>Cart Subtotal</td>
                                                            <td> <?php echo "₹".$item_total; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Shipping &amp; Handling</td>
                                                            <td>₹60  Delivery charge</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-color"><strong>Total</strong></td>
                                                            <td class="text-color"><strong> <?php echo "₹".($item_total+60); ?></strong></td>        
                                                        </tr>
                                                        <tr>
                                                            <td class="text-color">Order Description (if any)</td>
                                                            <td class="text-color"> <input type="text" id="description" name="description" placeholder="descriptions(eg. Less salt)" style="width:100%">
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                    
                                                    
                                                    
                                                    
                                                </table>
                                            </div>
                                        </div>
                                        <!--cart summary-->
                                        <div class="payment-option">
                                            <ul class=" list-unstyled">
                                                <li>
                                                    <label class="custom-control custom-radio  m-b-20">
                                                        <input name="mod" id="radioStacked1" checked value="COD" type="radio" class="custom-control-input"> <span class="custom-control-indicator"></span> <span class="custom-control-description">Cash on Delivery</span>
                                                        <br> 
                                                     </label>
                                                </li>
                                                <li>
                                                    <label class="custom-control custom-radio  m-b-10">
                                                        <input name="mod"  type="radio" value="paypal" disabled class="custom-control-input"> <span class="custom-control-indicator"></span> <span class="custom-control-description">Paypal <img src="images/paypal.jpg" alt="" width="90"></span> </label>
                                                </li>
                                            </ul>
                                            <p class="text-xs-center"> <input type="submit" onclick="return confirmOrder()" name="submit"  class="btn btn-outline-success btn-block" value="Order now"> </p>
                                        </div>
                                    </div>
                                </div>
                     </div>
                    </div>
                    </form>
                </div>
                <?php include('footer.php'); ?>
                <!-- end:Footer -->
            </div>
            <!-- end:page wrapper -->
            </div>

        <!-- Bootstrap core JavaScript
        ================================================== -->
        <script src="js/jquery.min.js"></script>
        <script src="js/tether.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/animsition.min.js"></script>
        <script src="js/bootstrap-slider.min.js"></script>
        <script src="js/jquery.isotope.min.js"></script>
        <script src="js/headroom.js"></script>
        <script src="js/foodpicky.min.js"></script>
    </body>

    </html>

    <?php
    }
    ?>
