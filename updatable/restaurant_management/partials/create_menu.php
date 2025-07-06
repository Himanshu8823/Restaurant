<?php
session_start();
include("../connection/connect.php");
if (!isset($_SESSION['manager']) && !isset($_SESSION['username'])) {
  header("Location: ../login.php");
  exit(); 
}

if(isset($_POST['submit']))           //if upload btn is pressed
{       
          echo " Button is pressed so please be carefull because i am very dangerous person";
                $fname = $_FILES['product_image']['name'];
                $temp = $_FILES['product_image']['tmp_name'];
                $fsize = $_FILES['product_image']['size'];
                $extension = explode('.',$fname);
                $extension = strtolower(end($extension));  
                $fnew = uniqid().'.'.$extension;
   
                $store = "../../admin/Res_img/dishes/".basename($fnew);                      // the path to store the upload image
    
                if($extension == 'jpg' || $extension == 'png' || $extension == 'gif' )
                {        
                    if($fsize >= 1000000)
                    {
                        $error = '<div class="alert alert-danger alert-dismissible fade show">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <strong>Max Image Size is 1024kb!</strong> Try different Image.
                                    </div>';
                    }
                    else
                    {   
                      $sql = "INSERT INTO dishes(rs_id, title, slogan, price, img) VALUES ('".$_SESSION['rs_id']."','".$_POST['product_name']."','".strip_tags($_POST['description'])."','".$_POST['price']."','".$fnew."')";
                        mysqli_query($db, $sql); 
                        move_uploaded_file($temp, $store);
  
                        $success = '<div class="alert alert-success alert-dismissible fade show">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <strong>Congratulations!</strong> New Dish Added Successfully.
                                    </div>';
                    }
                }
                elseif($extension == '')
                {
                    $error = '<div class="alert alert-danger alert-dismissible fade show">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <strong>Select image</strong>
                                    </div>';
                }
                else
                {
                    $error = '<div class="alert alert-danger alert-dismissible fade show">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <strong>Invalid extension!</strong> Only PNG, JPG, GIF are accepted.
                                    </div>';                        
                }                      
}
include("hel.php");
include('header_menu.php');
include('header.php');
include('sidebar.php');
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Manage
            <small>Products</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Products</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-12 col-xs-12">

                <div id="messages"></div>

                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Add Product</h3>
                    </div>
                    <!-- /.box-header -->
                    <form role="form" action="" method="post"  enctype="multipart/form-data">
                        <div class="box-body">

                            <div class="form-group">
                                <label for="product_image">Image</label>
                                <div class="kv-avatar">
                                    <div class="file-loading">
                                        <input id="product_image" name="product_image" type="file">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="product_name">Product name</label>
                                <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Enter product name" autocomplete="off" required value="" />
                            </div>

                            <div class="form-group">
                                <label for="price">Price</label>
                                <input type="text" class="form-control" id="price" name="price" placeholder="Enter price" autocomplete="off" value="" required/>
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea type="text" class="form-control" id="description" name="description" placeholder="Enter description" autocomplete="off" required></textarea>
                            </div>

                           
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" name="submit" class="btn btn-success">Save Changes</button>
                            <a href="#" class="btn btn-danger">Back</a>
                        </div>
                    </form>
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

<script type="text/javascript">
  $(document).ready(function() {
    $(".select_group").select2();
    $("#description").wysihtml5();

    $("#productMainNav").addClass('active');
    $("#createProductSubMenu").addClass('active');
    
    var btnCust = '<button type="button" class="btn btn-secondary" title="Add picture tags" ' + 
        'onclick="alert(\'Call your custom code here.\')">' +
        '<i class="glyphicon glyphicon-tag"></i>' +
        '</button>'; 
    $("#product_image").fileinput({
        overwriteInitial: true,
        maxFileSize: 1500,
        showClose: false,
        showCaption: false,
        browseLabel: '',
        removeLabel: '',
        browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
        removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
        removeTitle: 'Cancel or reset changes',
        elErrorContainer: '#kv-avatar-errors-1',
        msgErrorClass: 'alert alert-block alert-danger',
        layoutTemplates: {main2: '{preview} ' +  btnCust + ' {remove} {browse}'},
        allowedFileExtensions: ["jpg", "png", "gif"]
    });

  });
</script>
