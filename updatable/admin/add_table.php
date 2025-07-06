    <!DOCTYPE html>
    <html lang="en">
    <?php
    session_start();
    error_reporting(0);
    include("../connection/connect.php");

    // Fetch the list of restaurants for dropdown
    $restaurant_query = "SELECT title FROM restaurant";
    $restaurant_result = mysqli_query($db, $restaurant_query);
    $restaurant_names = [];
    while ($row = mysqli_fetch_assoc($restaurant_result)) {
        $restaurant_names[] = $row['title'];
    }

    if (isset($_POST['submit'])) {
        // Your existing code for form submission
        if (
            empty($_POST['restaurant_name']) ||
            empty($_POST['capacity']) ||
            empty($_POST['table_name']) ||
            empty($_POST['description'])
        ) {
            $error = '<div class="alert alert-danger alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>All fields are required!</strong>
            </div>';
        } else {
            // Get restaurant ID based on the selected name
            $selected_restaurant_name = $_POST['restaurant_name'];
            $restaurant_id_query = "SELECT rs_id FROM restaurant WHERE title = '$selected_restaurant_name'";
            $restaurant_id_result = mysqli_query($db, $restaurant_id_query);

            if ($restaurant_id_result && mysqli_num_rows($restaurant_id_result) > 0) {
                $row = mysqli_fetch_assoc($restaurant_id_result);
                $rs_id = $row['rs_id'];

                // Assuming is_booked will be initialized to 0 for a new table
                $capacity = $_POST['capacity'];
                $table_name = $_POST['table_name'];
                $description = $_POST['description'];
                $is_booked = 0;

                $insert_query = "INSERT INTO tables (rs_id, capacity, is_booked, table_name, description)
                                VALUES ('$rs_id', '$capacity', '$is_booked', '$table_name', '$description')";

                $insert_result = mysqli_query($db, $insert_query);

                if ($insert_result) {
                    $success = '<div class="alert alert-success alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>Table added successfully!</strong>
                    </div>';
                } else {
                    $error = '<div class="alert alert-danger alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>Error adding table: ' . mysqli_error($db) . '</strong>
                    </div>';
                }
            } else {
                $error = '<div class="alert alert-danger alert-dismissible fade show">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>Invalid restaurant name!</strong>
                </div>';
            }
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
        <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    </head>
    <?php include("header.php"); ?>
    <body class="fix-header fix-sidebar">
        <div class="page-wrapper" style="background: #87CEFA">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-outline-primary">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white">Add Table</h4>
                            </div>
                            <div class="card-body">
                                <?php echo $error; ?>
                                <?php echo $success; ?>
                                <form action='' method='post' enctype="multipart/form-data">
                                    <div class="form-body">
                                        <hr>
                                        <div class="row p-t-20">
                                            <div class="col-md-6">
                                                <div class="form-group f-s-18">
                                                    <label class="control-label">Restaurant Name</label>
                                                    <select name="restaurant_name" id="restaurant_name" class="form-control select2">
                                                        <?php foreach ($restaurant_names as $restaurant_name) : ?>
                                                            <option value="<?php echo $restaurant_name; ?>"><?php echo $restaurant_name; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Capacity</label>
                                                    <input type="text" name="capacity" class="form-control" placeholder="Capacity">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row p-t-20">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Table Name</label>
                                                    <input type="text" name="table_name" class="form-control" placeholder="Table Name">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Description</label>
                                                    <textarea name="description" class="form-control" placeholder="Description"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-actions">
                                        <input type="submit" name="submit" class="btn btn-success" value="Save">
                                        <a href="dashboard.php" class="btn btn-inverse">Cancel</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php include("footer.php"); ?>
        <script>
            // Initialize Select2 for the restaurant dropdown
            $(document).ready(function() {
                $('.select2').select2();
            });
        </script>

        <!-- All Jquery -->
        <script src="js/lib/bootstrap/js/popper.min.js"></script>
        <script src="js/lib/bootstrap/js/bootstrap.min.js"></script>
        <script src="js/jquery.slimscroll.js"></script>
        <script src="js/sidebarmenu.js"></script>
        <script src="js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
        <script src="js/custom.min.js"></script>
    </body>

    </html>
