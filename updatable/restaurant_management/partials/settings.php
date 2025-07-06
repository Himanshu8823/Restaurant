<?php
session_start();
include("hel.php");
include('header_menu.php');
include('header.php');
include('sidebar.php');

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit(); 
}

// Include the database connection
include("../connection/connect.php");

// Retrieve the user's current information from the database
$username = $_SESSION['username'];
$sql = "SELECT * FROM restaurant_admins WHERE username = '$username'";
$result = mysqli_query($db, $sql);
$user = mysqli_fetch_assoc($result);
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>User <small>Setting</small></h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Setting</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Update Information</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <form id="settingsForm">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email" autocomplete="off" value="<?php echo $user['email']; ?>">
                            </div>

                            <div class="form-group">
                                <label for="fname">First name</label>
                                <input type="text" class="form-control" id="fname" name="fname" placeholder="First name" autocomplete="off" value="<?php echo $user['firstname']; ?>">
                            </div>

                            <div class="form-group">
                                <label for="lname">Last name</label>
                                <input type="text" class="form-control" id="lname" name="lname" placeholder="Last name" autocomplete="off" value="<?php echo $user['lastname']; ?>">
                            </div>

                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone" autocomplete="off" value="<?php echo $user['phone']; ?>">
                            </div>

                            <div class="form-group">
                                <label for="gender">Gender</label>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="gender" value="Male" <?php if($user['gender'] == 'Male') echo "checked"; ?>>
                                        Male
                                    </label>
                                    <label>
                                        <input type="radio" name="gender" value="Female" <?php if($user['gender'] == 'Female') echo "checked"; ?>>
                                        Female
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="alert alert-danger alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    Leave the PASSWORD FIELD <b>"EMPTY"</b> if you don't want to change the password!
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password">New Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password" autocomplete="off">
                            </div>

                            <div class="form-group">
                                <label for="cpassword">Confirm password</label>
                                <input type="password" class="form-control" id="cpassword" name="cpassword" placeholder="Confirm Password" autocomplete="off">
                            </div>

                            <div class="box-footer">
                                <button id="submitBtn" type="submit" class="btn btn-success">Save Changes</button>
                                <a href="#" class="btn btn-danger">Back</a>
                            </div>
                        </form>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Submit form using AJAX
    $('#settingsForm').submit(function(event) {
        event.preventDefault(); // Prevent default form submission

        // Serialize form data
        var formData = $(this).serialize();

        // Send AJAX request
        $.ajax({
            type: 'POST',
            url: 'update_settings.php', // Backend PHP script for updating settings
            data: formData,
            success: function(response) {
                // Handle success response
                console.log(response);
                // Check if the response indicates success
                if (response.trim() === 'success') {
                    // Show success alert
                    alert('User information updated successfully');
                } else {
                    // Handle other responses (e.g., errors)
                    console.error('Update failed: ' + response);
                }
            },
            error: function(xhr, status, error) {
                // Handle error response
                console.error(xhr.responseText);
                // You can display error message to the user
            }
        });
    });
});

</script>