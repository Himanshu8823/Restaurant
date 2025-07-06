<?php
include("../connection/connect.php");

$error = $success = '';

// Check if ID is provided
if (!isset($_GET['id'])) {
    echo "No banner ID provided.";
    exit;
}

// Fetch banner details based on the provided ID
$id = $_GET['id'];
$query = "SELECT * FROM slider_images WHERE id = $id";
$result = mysqli_query($db, $query);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $image_url = $row['image_url'];
} else {
    echo "No banner found with the provided ID.";
    exit;
}

// Handle form submission for updating banner image
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    // Validate file upload
    if ($_FILES["banner_image"]["error"] == UPLOAD_ERR_OK) {
        // Move uploaded image to the desired directory
        $target_dir = "../images/business-banners/";
        $target_file = $target_dir . basename($_FILES["banner_image"]["name"]);

        // Check if the file already exists
        if (file_exists($target_file)) {
            $error = "Sorry, the file already exists.";
        } else {
            // Move the uploaded file to the target directory
            if (move_uploaded_file($_FILES["banner_image"]["tmp_name"], $target_file)) {
                // Update the image URL in the database
                $image_url = basename($_FILES["banner_image"]["name"]);
                $update_query = "UPDATE slider_images SET image_url='$image_url' WHERE id='$id'";
                if (mysqli_query($db, $update_query)) {
                    $success = "Banner image updated successfully.";
                } else {
                    $error = "Error updating banner image: " . mysqli_error($db);
                }
            } else {
                $error = "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        $error = "Error uploading file: " . $_FILES["banner_image"]["error"];
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Edit Banner</title>
    <link href="css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="css/helper.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body class="fix-header fix-sidebar">
    <div id="main-wrapper">
        <?php include("header.php"); ?>
        <div class="page-wrapper" style="height:1200px;">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Edit Banner</h4>
                                <?php if (!empty($error)) : ?>
                                    <div class="alert alert-danger"><?php echo $error; ?></div>
                                <?php endif; ?>
                                <?php if (!empty($success)) : ?>
                                    <div class="alert alert-success"><?php echo $success; ?></div>
                                <?php endif; ?>
                                <img src="../images/business-banners/<?php echo $image_url; ?>" alt="Banner Image" class="img-fluid mb-3">
                                <form action="" method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="banner_image">Upload New Image:</label>
                                        <input type="file" class="form-control-file" id="banner_image" name="banner_image">
                                    </div>
                                    <button type="submit" class="btn btn-primary" name="submit">Upload Image</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include("footer.php"); ?>
    <script src="js/lib/jquery/jquery.min.js"></script>
    <script src="js/lib/bootstrap/js/popper.min.js"></script>
    <script src="js/lib/bootstrap/js/bootstrap.min.js"></script>
    <script src="js/jquery.slimscroll.js"></script>
    <script src="js/sidebarmenu.js"></script>
    <script src="js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <script src="js/custom.min.js"></script>
</body>

</html>
                                    