<?php
include("../connection/connect.php");

$error = $success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    // Check if file was uploaded without errors
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        $target_dir = "../images/business-banners/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Allow only certain file formats
        $allowed_extensions = array("jpg", "jpeg", "png", "gif");
        if (!in_array($imageFileType, $allowed_extensions)) {
            $error = "Sorry, only JPG, JPEG, PNG, and GIF files are allowed.";
        } else {
            // Check if file already exists
            if (file_exists($target_file)) {
                $error = "Sorry, the file already exists.";
            } else {
                // Check file size (max 5MB)
                if ($_FILES["image"]["size"] > 5000000) {
                    $error = "Sorry, your file is too large.";
                } else {
                    // Move the uploaded file to the target directory
                    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                        // File uploaded successfully, now insert image URL into database
                        $image_url = basename($_FILES["image"]["name"]);
                        $sql = "INSERT INTO slider_images (image_url) VALUES ('$image_url')";
                        if (mysqli_query($db, $sql)) {
                            $success = "The file ". htmlspecialchars(basename($_FILES["image"]["name"])). " has been uploaded and inserted into the database.";
                        } else {
                            $error = "Error: " . $sql . "<br>" . mysqli_error($db);
                        }
                    } else {
                        $error = "Sorry, there was an error uploading your file.";
                    }
                }
            }
        }
    } else {
        $error = "No file was uploaded.";
    }
}
?>

<?php include "header.php"; ?>

<head>
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <title>Ela - Bootstrap Admin Dashboard Template</title>
    <!-- Bootstrap Core CSS -->
    <link href="css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/helper.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <div class="page-wrapper">
        <div class="container">
            <div class="row justify-content-center mt-5">
                <div class="col-md-6">
                    <div class="card">
                        <h5 class="card-header text-center">Upload Slider Image</h5>
                        <div class="card-body">
                            <?php if(!empty($error)): ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <strong><?php echo $error; ?></strong>
                                </div>
                            <?php endif; ?>
                            <?php if(!empty($success)): ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <strong><?php echo $success; ?></strong>
                                </div>
                            <?php endif; ?>
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="image">Select Image:</label>
                                    <input type="file" class="form-control-file" id="image" name="image" accept="image/*" required>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block" name="submit">Upload Image</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="js/lib/jquery/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="js/lib/bootstrap/js/popper.min.js"></script>
    <script src="js/lib/bootstrap/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="js/jquery.slimscroll.js"></script>
    <!--Menu sidebar -->
    <script src="js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <!--Custom JavaScript -->
    <script src="js/custom.min.js"></script>
</body>

</html>
