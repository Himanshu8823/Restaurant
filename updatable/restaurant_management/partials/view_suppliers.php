<?php
session_start();
if (!isset($_SESSION['manager'])&&!isset($_SESSION['username'])) {
  header("Location: ../login.php");
  exit(); 
}

// Include database connection
include("../connection/connect.php");

// Fetch supplier data from the database
$sql = "SELECT * FROM inventory_suppliers";
$result = mysqli_query($db, $sql);

// Prepare data array
$rows = array();
while($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
}
include("hel.php");
include('header_menu.php');
include('header.php');
include('sidebar.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Supplier List</title>
  <!-- Add DataTables CSS -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
  <!-- Add DataTables Buttons CSS -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
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
</head>

<body>

<div class="wrapper">
    <!-- Add your header and sidebar here -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Manage <small>Suppliers</small></h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Suppliers</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-12 col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Supplier List</h3>
                        </div>
                        <div class="box-body table-responsive">
                            <table id="SupplierTable" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Contact Person</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                        <th>Action</th> <!-- New column for action buttons -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($rows as $row): ?>
                                    <tr>
                                        <td><?php echo $row['supplier_id']; ?></td>
                                        <td><?php echo $row['name']; ?></td>
                                        <td><?php echo $row['contact_person']; ?></td>
                                        <td><?php echo $row['email']; ?></td>
                                        <td><?php echo $row['phone']; ?></td>
                                        <td><?php echo $row['address']; ?></td>
                                        <td>                          
                                            <a href="delete/delete_supplier.php?id=<?php echo $row['supplier_id']; ?> & rs_id=<?php echo $row['rs_id']; ?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                            <a href="edit_supplier.php?supplier_id=<?php echo $row['supplier_id']; ?> & rs_id=<?php echo $row['rs_id']; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- col-md-12 -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Add your footer here -->
</div>
<!-- ./wrapper -->

<!-- Add jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Add DataTables JS -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<!-- Add DataTables Buttons JS -->
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<!-- Add DataTables JSZip JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.7.1/jszip.min.js"></script>
<!-- Add DataTables pdfmake JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/pdfmake.min.js"></script>
<!-- Add DataTables pdfmake vfs_fonts JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/vfs_fonts.js"></script>
<!-- Add DataTables Buttons JS -->
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>


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
        $('#SupplierTable').DataTable({
            dom: 'Bfrtip', // Add buttons to the table
            buttons: [
                'copy', 'csv', 'pdf', 'print' // Define buttons for copy, CSV export, PDF export, and print
            ]
        });
    });
</script>
</body>
</html>
