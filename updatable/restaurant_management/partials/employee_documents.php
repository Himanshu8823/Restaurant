<?php
// Start session
session_start();

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
    // Example: Upload document functionality
    // (You can add more document-related operations similarly)

    // Get the restaurant ID from the session variable
    $rs_id = $_SESSION['rs_id'];

    // Handle file upload
    $targetDir = "../images/employees/documents/";
    $fileName = basename($_FILES["file"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    // Allow certain file formats
    $allowTypes = array('pdf', 'doc', 'docx', 'txt', 'jpg', 'jpeg', 'png', 'gif');
    if (in_array($fileType, $allowTypes)) {
        // Upload file to the server
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
            // Insert document details into the database
            $documentName = $_POST['document_name']; // Get document name from the form input
            $sql = "INSERT INTO employee_documents (rs_id, employee_id, document_name, file_path) VALUES (?, ?, ?, ?)";
            $stmt = mysqli_prepare($db, $sql);
            if ($stmt) {
                // Bind parameters
                mysqli_stmt_bind_param($stmt, "iiss", $rs_id, $_POST['employee_id'], $documentName, $targetFilePath);
                // Execute statement
                if (mysqli_stmt_execute($stmt)) {
                    $success = "Document uploaded successfully";
                    header("location:employee_documents.php?rs_id=$rs_id");
                } else {
                    $error = "Something went wrong. Please try again later.";
                }
            } else {
                $error = "Something went wrong. Please try again later.";
            }
            // Close statement
            mysqli_stmt_close($stmt);
        } else {
            $error = "Sorry, there was an error uploading your file.";
        }
    } else {
        $error = "Sorry, only PDF, DOC, DOCX, TXT, JPG, JPEG, PNG, GIF files are allowed to upload.";
    }
}

// Fetch employee documents belonging to the current restaurant from the database
// Get the restaurant ID from the session variable
$rs_id = $_SESSION['rs_id'];
$sql = "SELECT ed.*, e.name AS employee_name FROM employee_documents ed INNER JOIN employees e ON ed.employee_id = e.employee_id WHERE ed.rs_id = ?";
$stmt = mysqli_prepare($db, $sql);
mysqli_stmt_bind_param($stmt, "i", $rs_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Close the statement
mysqli_stmt_close($stmt);

// Include header and sidebar files
include("hel.php");
include('header_menu.php');
include('header.php');
include('sidebar.php');
?>
<head>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <!-- DataTables Buttons CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    <!-- Select2 CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
    <style>
        .buttons-copy, .buttons-csv, .buttons-pdf, .buttons-print {
            background-color: green !important; /* Background color */
            color: white !important; /* Text color */
            border: none; /* Remove border */
        }
        /* Hover effect */
        .buttons-copy:hover, .buttons-csv:hover, .buttons-pdf:hover, .buttons-print:hover {
            background-color: darkgreen; /* Darker background color on hover */
        }
        .select2-container {
    width: 100% !important;
}

/* Set the width of the Select2 dropdown to match its container */
.select2-dropdown {
    max-width: 100% !important;
}

    </style>
</head>
<body>
    <div class="wrapper">
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>Manage Employee Documents</h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Employee Documents</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="box container mt-5">
                    <h2 class="mb-4">Upload Document</h2>
                    <?php if (isset($error)) { ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php } ?>
                    <?php if (isset($success)) { ?>
                        <div class="alert alert-success"><?php echo $success; ?></div>
                    <?php } ?>
                    <!-- Upload Document Form -->
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                        <div class="mb-3 form-group">
                            <label for="employee_id" class="form-label">Select Employee:</label>
                            <select class="form-control select2" id="employee_id" name="employee_id" required>
                                <option value="">Select Employee</option>
                                <?php
                                // Fetch employees belonging to the current restaurant
                                $sql = "SELECT * FROM employees WHERE rs_id = ?";
                                $stmt = mysqli_prepare($db, $sql);
                                mysqli_stmt_bind_param($stmt, "i", $rs_id);
                                mysqli_stmt_execute($stmt);
                                $employees = mysqli_stmt_get_result($stmt);

                                // Display employees in dropdown
                                while ($row = mysqli_fetch_assoc($employees)) {
                                    echo "<option value='" . $row['employee_id'] . "'>" . $row['name'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3 form-group">
                            <label for="document_name" class="form-label">Document Name:</label>
                            <input type="text" class="form-control" id="document_name" name="document_name" required>
                        </div>
                        <div class="mb-3 form-group">
                            <label for="file" class="form-label">Choose File:</label>
                            <input type="file" class="form-control" id="file" name="file" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Upload Document</button>
                    </form>
                    <hr>
                    <!-- Display Employee Documents Table -->
                    <h3>Employee Documents</h3>
                    <div class="table-responsive">
                    <table id="documentTable" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Employee</th>
                                <th>Document Name</th>
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
                                    echo "<td>" . $row['employee_name'] . "</td>";
                                    echo "<td>" . $row['document_name'] . "</td>";
                                    echo "<td><a href='" . $row['file_path'] . "' download class='btn btn-success'>Download</a></td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='4'>No documents found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                    </div>
                </div>
            </section>
            <!-- /.content -->
            <?php include("footer.php"); ?>
        </div>
        <!-- /.content-wrapper -->
    </div>
    <!-- ./wrapper -->
            
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-GL8Ybzz4EMBQqRij+K2mF+6Ht6b5+6QaDLyop+wejysyQ6uW4t47DO6vuqMx2ibC" crossorigin="anonymous"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <!-- DataTables Buttons JS -->
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <!-- Select2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $('#documentTable').DataTable({
                dom: 'Bfrtip', // Add buttons to the table
                buttons: [
                    'copy', 'csv', 'pdf', 'print' // Define buttons for copy, CSV export, PDF export, and print
                ]
            });

            // Initialize Select2 for the employee dropdown
            $('.select2').select2();
        });
    </script>
</body>
</html>
