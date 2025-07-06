<?php
// Include database connection file
include("../connection/connect.php");
session_start();
if (!isset($_SESSION['manager'])&&!isset($_SESSION['username'])&&!isset($_SESSION['cashier'])) {
    header("Location: ../login.php");
    exit(); 
}
// Include header files
include("hel.php");
include('header_menu.php');
include('header.php');
include('sidebar.php'); 
// Check if table_id is provided via GET request
if(isset($_GET['table_upd'])) {
    // Sanitize the input to prevent SQL injection
    $table_id = mysqli_real_escape_string($db, $_GET['table_upd']);
    
    // Fetch table data from the database
    $query = "SELECT * FROM tables WHERE table_id = '$table_id'";
    $result = mysqli_query($db, $query);

    if(mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);

        // Handle form submission for updating table information
        if(isset($_POST['submit'])) {
            // Sanitize and validate form input
            $capacity = mysqli_real_escape_string($db, $_POST['capacity']);
            $table_name = mysqli_real_escape_string($db, $_POST['table_name']);
            $description = mysqli_real_escape_string($db, $_POST['description']);
            
            // Update table information in the database
            $update_query = "UPDATE tables SET capacity = '$capacity', table_name = '$table_name', description = '$description' WHERE table_id = '$table_id'";
            $update_result = mysqli_query($db, $update_query);

            if($update_result) {
                // Redirect to tables.php with success message
                echo '<script>alert("Table information updated successfully!");</script>';
                echo '<script>window.location.href = "tables.php?rs_id=' . $_GET["rs_id"] . '";</script>';
                exit();
            } else {
                // Error updating table information
                echo '<script>alert("Error updating table information: ' . mysqli_error($db) . '");</script>';
            }
        }
?>
<style>
    input[type=text],label{
        font-size: 20px;
    }
    h3{
        font-size: 30px;
    }
    #description{
        font-size: 20px;
    }
</style>
<div class="content-wrapper">
    <div class="container mt-5 ">
        <div class="row justify-content-center" style="margin-left:20%">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h3 class="text-center mb-0">Edit Table</h3>
                    </div>
                    <div class="card-body">
                        <form method="post">
                            <div class="form-group">
                                <label for="table_name">Table Name:</label>
                                <input type="text" name="table_name" id="table_name" class="form-control" value="<?php echo $row['table_name']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="capacity">Capacity:</label>
                                <input type="text" name="capacity" id="capacity" class="form-control" value="<?php echo $row['capacity']; ?>">
                            </div>
                            
                            <div class="form-group">
                                <label for="description">Description:</label>
                                <textarea name="description" id="description" class="form-control"><?php echo $row['description']; ?></textarea>
                            </div>
                            <button type="submit" name="submit" class="btn btn-success btn-block">Save changes</button>
                            <br>
                            <a class="btn btn-danger btn-block" href="tables.php?rs_id=<?php echo $_GET['rs_id'];?>">Back</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    } else {
        // If no matching table found
        echo "Table not found";
    }
} else {
    // If table_id is not provided
    echo "Invalid request";
}
?>
