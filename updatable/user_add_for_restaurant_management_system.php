<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>

    <meta name='viewport' content='width=device-width, initial-scale=1'>

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
    <style>
    label{
        font-size: 25px;

    }</style>
</head>
<body>
<div class="container mt-5">
    <h2>Add Restaurant</h2>
    <form>
        <!-- Restaurant Details -->
        <div class="form-group">
            <label for="restaurantName">Restaurant Name</label>
            <input type="text" class="form-control" id="restaurantName" placeholder="Enter restaurant name" required>
        </div>

        <div class="form-group">
            <label for="restaurantAddress">Restaurant Address</label>
            <input type="text" class="form-control" id="restaurantAddress" placeholder="Enter complete address" required>
        </div>

        <div class="form-group">
            <label for="locality">Locality</label>
            <input type="text" class="form-control" id="locality" placeholder="Enter locality" required>
        </div>

        <div class="form-group">
            <label for="pinCode">Pin Code</label>
            <input type="text" class="form-control" id="pinCode" placeholder="Enter pin code" required>
        </div>

        <!-- Contact Information -->
        <div class="form-group">
            <label for="contactNumber">Contact Number</label>
            <input type="tel" class="form-control" id="contactNumber" placeholder="Enter contact number" required>
        </div>

        <div class="form-group">
            <label for="ownerMobile">Owner's Mobile Number</label>
            <input type="tel" class="form-control" id="ownerMobile" placeholder="Enter owner's mobile number" required>
        </div>

        <!-- Owner Details -->
        <div class="form-group">
            <label for="ownerName">Owner's Full Name</label>
            <input type="text" class="form-control" id="ownerName" placeholder="Enter owner's full name" required>
        </div>

        <div class="form-group">
            <label for="ownerEmail">Owner's Email Address</label>
            <input type="email" class="form-control" id="ownerEmail" placeholder="Enter owner's email address" required>
        </div>

        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="receiveUpdates" style="width:25px;height:25px">
            <label class="form-check-label" for="receiveUpdates">I would like to receive updates and notifications from FoodDude on WhatsApp</label>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Submit</button>
    </form>
</div>


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
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
    <script src="css/reviewscript.js"></script>

</body>

</html>