<?php
// Start session
session_start();
$rs_id = $_SESSION['rs_id'];
// Check if username is not set in session, redirect to login page
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}

// Include database configuration
include("../connection/connect.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process form data
    // Example: Add employee functionality
    // (You can add/edit/delete employees similarly)

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
        // Insert employee into database
        $sql = "INSERT INTO employees (rs_id, name, role, email, phone,password) VALUES (?, ?, ?, ?, ?,$encrypted_password)";
        if ($stmt = mysqli_prepare($db, $sql)) {
            // Bind parameters
            mysqli_stmt_bind_param($stmt, "issss", $rs_id, $name, $role, $email, $phone);
            // Set restaurant ID from session variable
            $rs_id = $_SESSION['rs_id'];
            // Execute statement
            if (mysqli_stmt_execute($stmt)) {
                $success = "Employee added successfully";
                header("Location: employees.php?rs_id=$rs_id&success=1");
            } else {
                $error = "Something went wrong. Please try again later.";
            }
        }
        // Close statement
        mysqli_stmt_close($stmt);
    }
}

// Fetch employees belonging to the current restaurant from database
 // Get restaurant ID from session variable
$sql = "SELECT * FROM employees WHERE rs_id = ?";
$stmt = mysqli_prepare($db, $sql);
mysqli_stmt_bind_param($stmt, "i", $rs_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Close statement
mysqli_stmt_close($stmt);

// Close connection
mysqli_close($db);

// Include header and sidebar files
include("hel.php");
include('header_menu.php');
include('header.php');
include('sidebar.php');

?>
<head>
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
</head>
    <div class="wrapper">
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>Manage Employees</h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Employees</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container box mt-5">
                    <h2 class="mb-4">Add Employee</h2>
                    <?php if (isset($error)) { ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php } ?>
                    <?php if (isset($success)) { ?>
                        <div class="alert alert-success"><?php echo $success; ?></div>
                    <?php } ?>
                    <!-- Add Employee Form -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">
                        Add Employee
                    </button>
                    <hr>
                    <!-- Display Employees Table -->
                    <h3>Employee List</h3>
                    <div class="table-responsive">
                    <table id="employeeTable" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Role</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Action</th> 
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (mysqli_num_rows($result) > 0) {
                                $count = 1;
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>" . $count++ . "</td>";
                                    echo "<td>" . $row['name'] . "</td>";
                                    echo "<td>" . $row['role'] . "</td>";
                                    echo "<td>" . $row['email'] . "</td>";
                                    echo "<td>" . $row['phone'] . "</td>";
                                    echo "<td>";
                                    echo "<button class='btn btn-primary editEmployee' data-id='" . $row['employee_id'] . "' data-toggle='modal' data-target='#editModal'><i class='fa fa-pencil'></i></button> ";
                                    echo "<button class='btn btn-danger deleteEmployee' data-id='" . $row['employee_id'] . "' onclick='confirmDelete(" . $row['employee_id'] . ")'><i class='fa fa-trash'></i></button>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5'>No employees found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                    </div>
                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <?php include("footer.php");?>
    </div>
    <!-- ./wrapper -->

    <!-- Add Employee Modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="addModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Add Employee</h4>
                </div>
                <form role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="role">Role:</label>
                            <input type="text" class="form-control" id="role" name="role" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone:</label>
                            <input type="text" class="form-control" id="phone" name="phone" required>
                        </div>
                        <div class="form-group">
                            <label for="Password">Password:</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                    </div>
                    <div class="modal-footer">                    
                        <button type="submit" class="btn btn-success">Save Employee</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Edit Employee Modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="editModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edit Employee</h4>
                </div>
                <form role="form" id="editEmployeeForm" action="update_employee.php" method="POST">
                    <div class="modal-body" id="editModalBody">
                        <div class="form-group">
                            <label for="editName">Name:</label>
                            <input type="text" class="form-control" id="editName" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="editRole">Role:</label>
                            <input type="text" class="form-control" id="editRole" name="role" required>
                        </div>
                        <div class="form-group">
                            <label for="editEmail">Email:</label>
                            <input type="email" class="form-control" id="editEmail" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="editPhone">Phone:</label>
                            <input type="text" class="form-control" id="editPhone" name="phone" required>
                        </div>
                        <div class="form-group">
                            <label for="editPhone">Password:</label>
                            <input type="text" class="form-control" id="password" name="password" required>
                        </div>
                        <!-- Hidden input field to store employee ID -->
                        <input type="hidden" id="editEmployeeId" name="employee_id">
                    </div>
                    <div class="modal-footer">                    
                        <button type="submit" class="btn btn-success">Save Changes</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<!-- Include the necessary JavaScript files -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
<script>
    
$(document).ready(function() {
    // Initialize DataTable
    $('#employeeTable').DataTable({
        dom: 'Bfrtip', // Add buttons to the table
        buttons: [
            'copy', 'csv', 'pdf', 'print' // Define buttons for copy, CSV export, PDF export, and print
        ]
    });

    // Handle click event of edit button
    $('#employeeTable').on('click', '.editEmployee', function() {
        var employeeId = $(this).data('id');

        // Fetch employee details using AJAX
        $.get('edit_employee.php', { id: employeeId }, function(response) {
            if (response.success) {
                // Populate edit modal with employee details
                $('#editName').val(response.data.name);
                $('#editRole').val(response.data.role);
                $('#editEmail').val(response.data.email);
                $('#editPhone').val(response.data.phone);
                $('#editEmployeeId').val(employeeId);

                // Open edit modal
                $('#editModal').modal('show');
            } else {
                alert('Failed to fetch employee details');
            }
        }, 'json');
    });
});
function confirmDelete(employeeId) {
    if (confirm("Are you sure you want to delete this employee?")) {
        window.location.href = "delete_employee.php?id=" + employeeId;
    }
}
</script>
<!-- Backend PHP code for managing tables goes here... -->

</body>
</html>
