<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    echo "User is not logged in";
    exit(); 
}

// Include the database connection
include("../connection/connect.php");

// Retrieve form data
$username = $_SESSION['username'];
$email = $_POST['email'];
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$phone = $_POST['phone'];
$gender = $_POST['gender'];

// Update user information in the database
$update_sql = "UPDATE restaurant_admins SET email = '$email', firstname = '$fname', lastname = '$lname', phone = '$phone', gender = '$gender' WHERE username = '$username'";
if (mysqli_query($db, $update_sql)) {
    echo "success";

    // Check if password is being updated
    if (!empty($_POST['password']) && !empty($_POST['cpassword'])) {
        $password = $_POST['password'];
        $cpassword = $_POST['cpassword'];

        // Validate if password and confirm password match
        if ($password != $cpassword) {
            echo "Password and confirm password do not match";
            exit();
        }

        // Encrypt the password using MD5 hash
        $encrypted_password = md5($password);

        // Update password in the database
        $update_password_sql = "UPDATE restaurant_admins SET password = '$encrypted_password' WHERE username = '$username'";
        if (mysqli_query($db, $update_password_sql)) {
            echo "Password updated successfully";
        } else {
            echo "Error updating password: " . mysqli_error($db);
        }
    }
} else {
    echo "Error updating user information: " . mysqli_error($db);
}
?>
