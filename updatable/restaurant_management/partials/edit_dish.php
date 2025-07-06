<?php
session_start();
if (!isset($_SESSION['manager']) && !isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}

// Include database connection
include("../connection/connect.php");
$rs_id=$_SESSION['rs_id'];
// Check if dish ID is set and valid
if(isset($_GET['d_id']) && is_numeric($_GET['d_id'])) {
    $d_id = $_GET['d_id'];
    
    // Fetch dish data from the database
    $sql = "SELECT * FROM dishes WHERE d_id = $d_id";
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_assoc($result);
    
    // Check if dish exists
    if(!$row) {
        echo "Dish not found.";
        exit();
    }
} else {
    echo "Invalid dish ID.";
    exit();
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $title = $_POST['title'];
    $slogan = $_POST['slogan'];
    $price = $_POST['price'];
    $img = $_FILES['img']['name'];
    
    // Update dish data in the database
    $update_sql = "UPDATE dishes SET title = '$title', slogan = '$slogan', price = '$price', img = '$img' WHERE d_id = $d_id";
    if(mysqli_query($db, $update_sql)) {
        // Upload image file
        $target_dir = "../../admin/Res_img/dishes/";
        $target_file = $target_dir . basename($_FILES["img"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        if(isset($_POST["submit"])) {
            $check = getimagesize($_FILES["img"]["tmp_name"]);
            if($check !== false) {
                $uploadOk = 1;
            } else {
                echo "File is not an image.";
                $uploadOk = 0;
            }
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["img"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["img"]["tmp_name"], $target_file)) {
                echo "The file ". htmlspecialchars( basename( $_FILES["img"]["name"])). " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
        
        // Redirect to menu list page after update
        header("Location: manage_menu.php?rs_id=$rs_id");
        exit();
    } else {
        echo "Error updating dish: " . mysqli_error($db);
    }
}
include("hel.php");
include('header_menu.php');
include('header.php');
include('sidebar.php');

?>

<div class="wrapper">
    <!-- Add your header and sidebar here -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <!-- Add your content header here -->
            <h1>
                Manage
                <small>Orders</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Orders</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Add your main content here -->
            <div class="row" >
                
                    <div class="box box-primary" style="padding-left:10px;margin-left:10px">
                        <div class="box-header with-border" >
                            <h3 class="box-title">Edit Dish</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form role="form" method="post" enctype="multipart/form-data">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" class="form-control" id="title" name="title" value="<?php echo $row['title']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="slogan">Slogan</label>
                                    <input type="text" class="form-control" id="slogan" name="slogan" value="<?php echo $row['slogan']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="price">Price</label>
                                    <input type="number" class="form-control" id="price" name="price" value="<?php echo $row['price']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="img">Image</label>
                                    <input type="file" class="form-control" id="img" name="img">
                                </div>
                            </div>
                            <!-- /.box-body -->

                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Add your footer here -->
</div>
<!-- ./wrapper -->

<!-- Add your scripts here -->
<script type="text/javascript">
    var base_url = "";  // You need to set the correct base URL here

    $(document).ready(function() {
        // JavaScript code for dynamic functionality will be here
    });
</script>
