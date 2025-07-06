<?php
session_start();
$rs_id=$_GET["rs_id"];
include("../connection/connect.php");

if (!isset($_SESSION['manager'])&&!isset($_SESSION['username'])&&!isset($_SESSION['cashier'])) {
    header("Location: ../login.php");
    exit(); 
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $table_id = $_POST['table_id'];
    $customer_name = $_POST['customer_name'];
    $contact_number = $_POST['contact_number'];
    $email = $_POST['email'];
    $booking_date = $_POST['booking_date'];
    $booking_time = $_POST['booking_time'];
    $party_size = $_POST['party_size'];
    $special_requests = $_POST['special_requests'];
    
    // Prevent SQL injection
    $table_id = mysqli_real_escape_string($db, $table_id);
    $customer_name = mysqli_real_escape_string($db, $customer_name);
    $contact_number = mysqli_real_escape_string($db, $contact_number);
    $email = mysqli_real_escape_string($db, $email);
    $booking_date = mysqli_real_escape_string($db, $booking_date);
    $booking_time = mysqli_real_escape_string($db, $booking_time);
    $party_size = mysqli_real_escape_string($db, $party_size);
    $special_requests = mysqli_real_escape_string($db, $special_requests);
    
    // Insert booking into database
    $insert_query = "INSERT INTO bookings (table_id, customer_name, contact_number, email, booking_date, booking_time, party_size, special_requests)
                    VALUES ('$table_id', '$customer_name', '$contact_number', '$email', '$booking_date', '$booking_time', '$party_size', '$special_requests')";
    
    if (mysqli_query($db, $insert_query)) {
        // Update the 'is_booked' field in the 'tables' table
        $update_table_query = "UPDATE tables SET is_booked = '1' WHERE table_id = '$table_id'";
        mysqli_query($db, $update_table_query);
        
        // Booking successful
        echo '<script>alert("Table booked successfully!");</script>';
    } else {
        // Booking failed
        echo '<script>alert("Error booking table: ' . mysqli_error($db) . '");</script>';
    }
}
// Include header files
include("hel.php");
include('header_menu.php');
include('header.php');
include('sidebar.php'); 
?>

<!-- Select2 CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Book Table
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <div id="messages"></div>
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Book a Table</h3>
                    </div>
                    <div class="box-body table-responsive">
                        <form role="form" action="" method="post" id="bookTableForm">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="table_id">Table Name:</label>
                                    <select class="form-control select2" id="table_id" name="table_id" required>
                                        <option value="">Select Table</option>
                                        <?php
                                            $query = mysqli_query($db, "SELECT table_id, table_name FROM tables WHERE rs_id=$rs_id AND is_booked=0");
                                            while ($row = mysqli_fetch_assoc($query)) {
                                                echo '<option value="'.$row['table_id'].'">'.$row['table_name'].'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="customer_name">Customer Name:</label>
                                    <input type="text" name="customer_name" class="form-control" placeholder="Customer Name" required>
                                </div>
                                <div class="form-group">
                                    <label for="contact_number">Contact Number:</label>
                                    <input type="text" name="contact_number" class="form-control" placeholder="Contact Number" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email:</label>
                                    <input type="email" name="email" class="form-control" placeholder="Email">
                                </div>
                                <div class="form-group">
                                    <label for="booking_date">Booking Date:</label>
                                    <input type="date" name="booking_date" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="booking_time">Booking Time:</label>
                                    <input type="time" name="booking_time" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="party_size">Party Size:</label>
                                    <input type="number" name="party_size" class="form-control" placeholder="Party Size" required>
                                </div>  
                                <div class="form-group">
                                    <label for="special_requests">Special Requests:</label>
                                    <textarea name="special_requests" class="form-control" placeholder="Special Requests"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">                    
                                <button type="submit" name="submit" class="btn btn-success">Book Table</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Select2 JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    // Initialize Select2 for table selection
    $('.select2').select2();

    // Focus on the Select2 dropdown when the page loads
    $('#table_id').select2('open');

    // Add event listener for when the Select2 dropdown is opened
    $('.select2').on('select2:open', function() {
        // Focus on the search input
        $('.select2-search__field').focus();
    });
});

</script>