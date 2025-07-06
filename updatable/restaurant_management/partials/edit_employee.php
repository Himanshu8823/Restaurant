<?php
// Include database configuration
include("../connection/connect.php");

// Check if the employee ID is provided via GET
if (isset($_GET["id"])) {
    $employeeId = $_GET["id"];

    // Fetch employee details from the database
    $sql = "SELECT * FROM employees WHERE employee_id = ?";
    if ($stmt = mysqli_prepare($db, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $employeeId);
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            if ($row = mysqli_fetch_assoc($result)) {
                $response["success"] = true;
                $response["data"] = $row;
            } else {
                $response["success"] = false;
                $response["message"] = "Employee not found";
            }
        } else {
            $response["success"] = false;
            $response["message"] = "Error executing SQL statement";
        }
    } else {
        $response["success"] = false;
        $response["message"] = "Error preparing statement: " . mysqli_error($db);
    }

    // Close statement and database connection
    mysqli_stmt_close($stmt);
    mysqli_close($db);

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // If employee ID is not provided, return error response
    $response["success"] = false;
    $response["message"] = "Employee ID not provided";
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
