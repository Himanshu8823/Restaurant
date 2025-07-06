<?php 
if (!isset($_SESSION['manager']) || !isset($_SESSION['username'])) {
  header("Location: ../login.php");
  exit();
}


include("hel.php");
include('header_menu.php');
include('header.php');
include('sidebar.php'); 
?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Manage
      <small>Category</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Category</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">
        <div id="messages"></div>
        <button class="btn btn-success" data-toggle="modal" data-target="#addModal">Add Category</button>
        <br /> <br />

        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Manage Category</h3>
          </div>
          <div class="box-body">
            <table id="manageTable" class="table table-bordered table-hover table-striped">
              <thead>
                <tr>
                  <th>Category name</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- Add Category Modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="addModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add Category</h4>
      </div>

      <form role="form" action="category/create" method="post" id="createForm">

        <div class="modal-body">

          <div class="form-group">
            <label for="brand_name">Category Name</label>
            <input type="text" class="form-control" id="category_name" name="category_name" placeholder="Enter category name" autocomplete="off">
          </div>

          <div class="form-group">
            <label for="active">Status</label>
            <select class="form-control" id="active" name="active">
              <option value="1">Active</option>
              <option value="2">Inactive</option>
            </select>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success">Save changes</button>
        </div>

      </form>

    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Edit Category Modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="editModal">
  <!-- Edit Modal content here -->
</div>

<!-- Remove Category Modal -->
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
