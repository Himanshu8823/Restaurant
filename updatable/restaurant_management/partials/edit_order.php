<?php
if (!isset($_SESSION['manager'])&&!isset($_SESSION['username'])&&!isset($_SESSION['cashier'])) {
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
      <small>Orders</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Orders</li>
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
            <h3 class="box-title">Edit Order</h3>
          </div>
          <!-- /.box-header -->
          <form role="form" action="" method="post" class="form-horizontal">
              <div class="box-body">

                <!-- Validation Errors Display -->
                <div class="alert alert-error alert-dismissible" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <!-- Validation errors will be displayed here -->
                </div>

                <div class="form-group">
                  <label for="date" class="col-sm-12 control-label">Date: </label>
                </div>
                <div class="form-group">
                  <label for="time" class="col-sm-12 control-label">Time: </label>
                </div>

                <div class="col-md-4 col-xs-12 pull pull-left">

                  <div class="form-group">
                    <label for="table_name" class="col-sm-5 control-label" style="text-align:left;">Table</label>
                    <div class="col-sm-7">
                      <select class="form-control" id="table_name" name="table_name">
                        <!-- Options for table names will be dynamically generated here -->
                      </select>
                    </div>
                  </div>

                </div>

                <br /> <br/>
                <table class="table table-bordered table-hover" id="product_info_table">
                  <thead>
                    <tr>
                      <th style="width:50%">Product</th>
                      <th style="width:10%">Qty</th>
                      <th style="width:10%">Rate</th>
                      <th style="width:20%">Amount</th>
                      <th style="width:10%"><button type="button" id="add_row" class="btn btn-info"><i class="fa fa-plus"></i></button></th>
                    </tr>
                  </thead>

                   <tbody>
                    <!-- Table rows for product information will be dynamically generated here -->
                   </tbody>
                </table>

                <br /> <br/>

                <div class="col-md-6 col-xs-12 pull pull-right">

                  <div class="form-group">
                    <label for="gross_amount" class="col-sm-5 control-label">Gross Amount</label>
                    <div class="col-sm-7">
                      <input type="text" class="form-control" id="gross_amount" name="gross_amount" disabled>
                      <input type="hidden" class="form-control" id="gross_amount_value" name="gross_amount_value">
                    </div>
                  </div>

                  <!-- Other form fields for service charge, VAT, discount, net amount, paid status, etc. will be placed here -->

                </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">

                <!-- Hidden input fields for service charge rate and VAT charge rate will be here -->

                <a target="__blank" href="#" class="btn btn-default">Print</a>
                <button type="submit" class="btn btn-success">Save Changes</button>
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
  var base_url = "";  // You need to set the correct base URL here

  $(document).ready(function() {
    // JavaScript code for dynamic functionality will be here
  });
</script>
