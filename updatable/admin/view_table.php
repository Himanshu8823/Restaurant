<!DOCTYPE html>
<html lang="en">

<?php
include("../connection/connect.php");
error_reporting(0);
session_start();

if (isset($_GET['table_upd'])) {
    $table_id = $_GET['table_upd'];

    $table_query = "SELECT * FROM tables
                    INNER JOIN restaurant ON tables.rs_id = restaurant.rs_id
                    WHERE table_id='$table_id'";
    $table_result = mysqli_query($db, $table_query);

    if ($table_result) {
        $table_data = mysqli_fetch_assoc($table_result);
    } else {
        echo "Error fetching table details: " . mysqli_error($db);
        exit;
    }
} else {
    echo "No table ID specified for viewing.";
    exit;
}

if (isset($_POST['submit'])) {
    $table_id = $_POST['table_id'];
    $table_name = $_POST['table_name'];
    $description = $_POST['description'];
    $status = $_POST['status'];
    $capacity = $_POST['capacity']; // Add this line

    $update_query = "UPDATE tables SET table_name='$table_name', description='$description', is_booked='$status', capacity='$capacity' WHERE table_id='$table_id'";
    $update_result = mysqli_query($db, $update_query);

    if ($update_result) {
        $success = "Table details updated successfully.";
    } else {
        $error = "Unable to update table details: " . mysqli_error($db);
    }
}

?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <title>Ela - Bootstrap Admin Dashboard Template</title>
    <link href="css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="css/helper.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body class="fix-header fix-sidebar">

    <div id="main-wrapper">
        <?php include("header.php"); ?>
        <div class="page-wrapper" style="height:1200px;">
            <div class="container-fluid" style="background: #87CEFA">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Table Details</h4>
                                <?php
                                if (isset($error)) {
                                    echo "<div class='alert alert-danger'>$error</div>";
                                }
                                if (isset($success)) {
                                    echo "<div class='alert' style='background-color:#4BB543;font-size:18px;color:white '>$success</div>";
                                }
                                ?>
                                <form action='view_table.php?table_upd=<?php echo $table_data['table_id']; ?>'
                                    method='post'>
                                    <input type='hidden' name='table_id' value='<?php echo $table_data['table_id']; ?>'>
                                    <table class='table'>
                                        <tr>
                                            <td><b>Table ID:</b></td>
                                            <td>
                                                <?php echo $table_data['table_id']; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Restaurant Name:</b></td>
                                            <td><b>
                                                    <?php echo $table_data['title']; ?>
                                                </b></td>
                                        </tr>
                                        <tr>
                                            <td><b>Capacity:</b></td>
                                            <td><input class="f-s-20" type='number' name='capacity'
                                                    value='<?php echo $table_data['capacity']; ?>'></td>
                                        </tr>
                                        <tr>
                                            <td><b>Table Name:</b></td>
                                            <td><input class="f-s-20" type='text' name='table_name'
                                                    value='<?php echo $table_data['table_name']; ?>'></td>
                                        </tr>
                                        <tr>
                                            <td><b>Description:</b></td>
                                            <td><textarea class="f-s-20" rows="3" cols="50"
                                                    name='description'><?php echo $table_data['description']; ?></textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Status: </b></td>
                                            <td>
                                                <select name='status'>
                                                    <option value='1' <?php echo $table_data['is_booked'] == 1 ? 'selected' : ''; ?>> Booked </option>
                                                    <option value='0' <?php echo $table_data['is_booked'] == 0 ? 'selected' : ''; ?>> Available</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </table>
                                    <center class="p-t-10"><button class="btn-primary f-s-30" type='submit'
                                            name='submit'>Update</button><a class="btn-danger f-s-30 m-l-50" href="all_tables.php">Close</a></center>
                                            
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include("footer.php"); ?>
</body>
<style>
    b,
    select {
        font-size: 20px;
        color: magenta
    }
</style>

<script src="js/lib/jquery/jquery.min.js"></script>
<script src="js/lib/bootstrap/js/popper.min.js"></script>
<script src="js/lib/bootstrap/js/bootstrap.min.js"></script>
<script src="js/jquery.slimscroll.js"></script>
<script src="js/sidebarmenu.js"></script>
<script src="js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
<script src="js/custom.min.js"></script>
<script src="js/lib/datatables/datatables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
<script src="js/lib/datatables/datatables-init.js"></script>

</html>