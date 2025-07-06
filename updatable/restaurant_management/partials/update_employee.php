<?php
// Start session
session_start();

// Check if username is not set in session, redirect to login page
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}
$rs_id=$_SESSION['rs_id'];

// Include database configuration
include("../connection/connect.php");

// Check if the form is submitted for editing an employee
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process edit employee form data
    $employeeId = $_POST["employee_id"];
    $name = $_POST["name"];
    $role = $_POST["role"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $password = $_POST['password'];
    $encrypted_password = md5($password);    

    // Validate input (you can add more validation as needed)
    if (empty($name) || empty($role) || empty($email) || empty($phone)||empty($encrypted_password)) {
        $error = "Please fill in all fields";
    } else {
        // Update employee details in the database
        $sql = "UPDATE employees SET name=?, role=?, email=?, phone=?,password='$encrypted_password' WHERE employee_id=? AND rs_id=$rs_id";
        if ($stmt = mysqli_prepare($db, $sql)) {
            // Bind parameters
            mysqli_stmt_bind_param($stmt, "ssssi", $name, $role, $email, $phone, $employeeId);
            // Execute statement
            if (mysqli_stmt_execute($stmt)) {
                $success = "Employee details updated successfully";
            } else {
                $error = "Something went wrong. Please try again later.";
            }
        }
        // Close statement
        mysqli_stmt_close($stmt);
    }
}

// Close connection
mysqli_close($db);

// Redirect back to the employee management page
header("Location: employees.php?rs_id=$rs_id");
exit();
?>
