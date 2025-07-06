<?php
// Include database configuration
include("../connection/connect.php");
$rs_id=$_SESSION['rs_id'];
// Check if the employee ID is provided
if(isset($_GET['id'])) {
    // Get employee ID
    $employeeId = $_GET['id'];

    // Delete employee from database
    $sql = "DELETE FROM employees WHERE employee_id=?";
    $stmt = mysqli_prepare($db, $sql);
    mysqli_stmt_bind_param($stmt, "i", $employeeId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    // Close database connection
    mysqli_close($db);
    // Redirect back to employees.php after deletion
    header("Location: employees.php?rs_id=$rs_id");
    exit();
} else {
    // Redirect back to employees.php if employee ID is not provided
    header("Location: employees.php?rs_id=$rs_id");
    exit();
}


?>
