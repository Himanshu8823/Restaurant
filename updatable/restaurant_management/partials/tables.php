<?php 
include("../connection/connect.php");
error_reporting(0);
session_start();
if (!isset($_SESSION['manager'])&&!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit(); 
}
// Include header files
// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Get form data
    $capacity = $_POST['capacity'];
    $table_name = $_POST['table_name'];
    $description = $_POST['description'];
    // Get rs_id from URL
    $res_id = $_GET['rs_id'];
    // Prevent SQL injection
    $capacity = mysqli_real_escape_string($db, $capacity);
    $table_name = mysqli_real_escape_string($db, $table_name);
    $description = mysqli_real_escape_string($db, $description);
    $res_id = mysqli_real_escape_string($db, $res_id);
    // Insert new table into database
    $insert_query = "INSERT INTO tables (rs_id, capacity, is_booked, table_name, description)
                    VALUES ('$res_id', '$capacity', '0', '$table_name', '$description')";
    $insert_result = mysqli_query($db, $insert_query);   
    if ($insert_result) {
        // Table added successfully
        echo '<script>alert("Table added successfully!");</script>';
    } else {
        // Error adding table
        echo '<script>alert("Error adding table: ' . mysqli_error($db) . '");</script>';
    }
}
include("hel.php");
include('header_menu.php');
include('header.php');
include('sidebar.php');

?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
<style>
  .buttons-copy, .buttons-csv, .buttons-pdf, .buttons-print {
    background-color: green !important;/* Background color */
    color: white !important; /* Text color */
    border: none; /* Remove border */
}
/* Hover effect */
.buttons-copy:hover, .buttons-csv:hover, .buttons-pdf:hover, .buttons-print:hover {
    background-color: darkgreen; /* Darker background color on hover */
}
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Manage
            <small>Tables</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Tables</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <div id="messages"></div>
                <button class="btn btn-success" data-toggle="modal" data-target="#addModal">Add Table</button>
                <br /> <br />
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Manage Tables</h3>
                    </div>
                    <div class="box-body table-responsive">
                        <table id="manageTable" class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>Store</th>
                                    <th>Table name</th>
                                    <th>Capacity</th>
                                    <th>Available</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                $res_id = $_GET['rs_id'];

                // Prevent SQL injection
                $res_id = mysqli_real_escape_string($db, $res_id);
                
                // SQL query to retrieve tables for the specific restaurant
                $sql = "SELECT tables.*, restaurant.title
                        FROM tables 
                        INNER JOIN restaurant ON tables.rs_id = restaurant.rs_id
                        WHERE restaurant.rs_id = '$res_id'";
                
                                $query = mysqli_query($db, $sql);

                                if (!mysqli_num_rows($query) > 0) {
                                    echo '<td colspan="8"><center>No Tables Data!</center></td>';
                                } else {
                                    while ($rows = mysqli_fetch_array($query)) {
                                        ?>
                                        <tr>
                                            <td>
                                                <?php echo $rows['title']; ?>
                                            </td>
                                            <td>
                                                <?php echo $rows['table_name']; ?>
                                            </td>
                                            <td>
                                                <?php echo $rows['capacity']; ?>
                                            </td>
                                            <td>
                                                <?php echo $rows['is_booked'] == 1 ? 'Booked' : 'Available'; ?>
                                            </td>
                                            <td>
                                                <?php echo $rows['description']; ?>
                                            </td>
                                            <td>
                                                <?php
                                                if ($rows['is_booked'] == 1) {
                                                    echo '<button type="button" class="btn btn-success"><span
                                                            class="fa fa-check-circle"
                                                            aria-hidden="true">Booked</button>';
                                                } else {
                                                    echo '<button type="button" class="btn btn-warning"><span
                                                            class="ti-settings"
                                                            aria-hidden="true">Available</button>';
                                                }
                                                ?>
                                            </td>

                                            <td>
                                                <a href="delete/delete_table.php?table_del=<?php echo $rows['table_id']; ?>"
                                                    onclick="return confirm('Are you sure?');"
                                                    class="btn btn-danger btn-flat btn-addon btn-xs m-b-10"><i
                                                        class="fa fa-trash-o" style="font-size:16px"></i></a>
                                                <a href="edit_table.php?rs_id=<?php echo $res_id; ?>&&table_upd=<?php echo $rows['table_id']; ?>"
                                                    class="btn btn-info btn-flat btn-addon btn-sm m-b-10 m-l-5">
                                                    <i class="ti-settings"></i> Edit
                                                </a>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>


<!-- Add Table Modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="addModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Add Table</h4>
            </div>
            <form role="form" action="" method="post" id="addTableForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="capacity">Capacity:</label>
                        <input type="text" name="capacity" class="form-control" placeholder="Capacity">
                    </div>
                    <div class="form-group">
                        <label for="table_name">Table Name:</label>
                        <input type="text" name="table_name" class="form-control" placeholder="Table Name">
                    </div>
                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea name="description" class="form-control" placeholder="Description"></textarea>
                    </div>
                </div>
                <div class="modal-footer">                    
                    <button type="submit" name="submit" class="btn btn-success">Save changes</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Remove Table Modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeModal">
    <!-- Remove Modal content here -->
</div>

<script type="text/javascript">
    var manageTable;
    var base_url = "";

    $(document).ready(function() {
        // Initialization code here
    });

    function editFunc(id) {
        // Edit function code here
    }

    function removeFunc(id) {
        // Remove function code here
    }
</script>
<!-- Include the necessary JavaScript files -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        // Initialize DataTable
        $('#manageTable').DataTable({
            dom: 'Bfrtip', // Add buttons to the table
            buttons: [
                'copy', 'csv', 'pdf', 'print' // Define buttons for copy, CSV export, PDF export, and print
            ]
        });
    });
</script>
<!-- Backend PHP code for managing tables goes here... -->
