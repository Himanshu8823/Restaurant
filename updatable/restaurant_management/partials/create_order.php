<?php
session_start();
include("../connection/connect.php");

if (!isset($_SESSION['manager'])&&!isset($_SESSION['username'])&&!isset($_SESSION['cashier'])) {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $rs_id = $_SESSION['rs_id'];
    $order_date = date('Y-m-d H:i:s');
    $gross_amount = $_POST['gross_amount_value'];
    $discount = $_POST['discount'];
    $net_amount = $_POST['net_amount_value'];
    $product_ids = $_POST['product'];
    $quantities = $_POST['qty'];
    $customername=$_POST['customername'];

    // Prepare and execute SQL statement to insert order data
    $sql = "INSERT INTO offline_orders (rs_id, order_date, gross_amount, discount, net_amount, d_id, quantity,name) VALUES (?, ?, ?, ?, ?, ?, ?,?)";
    $stmt = mysqli_prepare($db, $sql);

    if ($stmt) {
        // Bind parameters and execute the statement for each product
        for ($i = 0; $i < count($product_ids); $i++) {
            mysqli_stmt_bind_param($stmt, "isddiiis", $rs_id, $order_date, $gross_amount, $discount, $net_amount, $product_ids[$i], $quantities[$i],$customername);
            mysqli_stmt_execute($stmt);
        }

        // Close statement
        mysqli_stmt_close($stmt);

        // Redirect to a success page or perform any other necessary actions
        header("location:create_order.php?rs_id=$rs_id");
        exit();
    } else {
        // Log error message if the statement preparation fails
        error_log("Error: " . mysqli_error($db));
        // You can also echo the error message or display it in a user-friendly manner
    }
}

include("hel.php");
include('header_menu.php');
include('header.php');
include('sidebar.php');

// Fetch dishes from the database
$rs_id = $_SESSION['rs_id'];
$sql = "SELECT d_id, title, price FROM dishes WHERE rs_id = ?";
$stmt = mysqli_prepare($db, $sql);
mysqli_stmt_bind_param($stmt, "i", $rs_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

?>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>

<!-- Content Wrapper. Contains page content -->
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
                        <h3 class="box-title">Add Order</h3>
                    </div>
                    <!-- /.box-header -->
                    <form role="form" method="post" class="form-horizontal">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="gross_amount" class="col-sm-12 control-label">Date:
                                    <?php echo date('Y-m-d') ?>
                                </label>
                            </div>
                            <div class="form-group">
                                <label for="gross_amount" class="col-sm-12 control-label">Time:
                                    <?php echo date('h:i a') ?>
                                </label>
                            </div>

                            <div class="col-md-4 col-xs-12 pull pull-left">
                                <!-- Remove the table selection -->
                            </div>

                            <br /> <br/>
                            <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="product_info_table">
                                <thead>
                                    <div class="form-group row">
                                        <label for="customername"
                                            class="col-sm-4 col-md-3 col-lg-2 col-form-label" style="font-size:16px">Customer Name:</label>
                                        <div class="col-sm-8 col-md-9 col-lg-10">
                                            <input type="text" class="form-control" id="customername"
                                                name="customername" placeholder="eg. Narendra Modi">
                                        </div>
                                    </div>


                        <tr>
                            <th style="width:50%">Product</th>
                            <th style="width:10%">Qty</th>
                            <th style="width:10%">Rate</th>
                            <th style="width:20%">Amount</th>
                            <th style="width:10%"><button type="button" id="add_row" class="btn btn-info"><i
                                        class="fa fa-plus"></i></button></th>
                        </tr>
                        </thead>

                        <tbody>
                            <tr id="row_1">
                                <td>
                                    <select class="form-control product" data-row-id="row_1" id="product_1"
                                        name="product[]" style="width:100%;" onchange="getProductData(1)" required>
                                        <option value=""></option>
                                        <?php
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo '<option value="' . $row['d_id'] . '">' . $row['title'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </td>
                                <td><input type="number" name="qty[]" id="qty_1" class="" required onkeyup="getTotal(1)" value="1" style="width: 100%; max-width:none;border:1px solid lightgray;font-size:18px"></td>
                                <td>
                                    <input type="text" name="rate[]" id="rate_1" class="form-control" disabled
                                        autocomplete="off">
                                    <input type="hidden" name="rate_value[]" id="rate_value_1" class="form-control"
                                        autocomplete="off">
                                </td>
                                <td>
                                    <input type="text" name="amount[]" id="amount_1" class="form-control" disabled
                                        autocomplete="off">
                                    <input type="hidden" name="amount_value[]" id="amount_value_1" class="form-control"
                                        autocomplete="off">
                                </td>
                                <td><button type="button" class="btn btn-danger" onclick="removeRow('1')"><i
                                            class="fa fa-close"></i></button></td>
                            </tr>
                        </tbody>
                        </table>
                        </div>

                        <br /> <br />

                        <div class="col-md-6 col-xs-12 pull pull-right">
                            <div class="form-group">
                                <label for="gross_amount" class="col-sm-5 control-label">Gross Amount</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" id="gross_amount" name="gross_amount"
                                        disabled autocomplete="off">
                                    <input type="hidden" class="form-control" id="gross_amount_value"
                                        name="gross_amount_value" autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="discount" class="col-sm-5 control-label">Discount</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" id="discount" name="discount"
                                        placeholder="Discount" onkeyup="subAmount()" autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="net_amount" class="col-sm-5 control-label">Net Amount</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" id="net_amount" name="net_amount" disabled
                                        autocomplete="off">
                                    <input type="hidden" class="form-control" id="net_amount_value"
                                        name="net_amount_value" autocomplete="off">
                                </div>
                            </div>
                        </div>
                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <!-- Include hidden fields for service and vat charges -->
                    <button type="submit" class="btn btn-success">Create Order</button>
                    <a href="orders/" class="btn btn-danger">Back</a>
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
    $(document).ready(function () {
        $(".product").select2();

        // Add new row in the table
        $("#add_row").unbind('click').bind('click', function () {
            var table = $("#product_info_table");
            var count_table_tbody_tr = $("#product_info_table tbody tr").length;
            var row_id = count_table_tbody_tr + 1;

            var html = '';
            html += '<tr id="row_' + row_id + '">';
            html += '<td>';
            html += '<select class="form-control product" data-row-id="row_' + row_id + '" id="product_' + row_id + '" name="product[]" style="width:100%;" onchange="getProductData(' + row_id + ')" required>';
            html += '<option value=""></option>';
            <?php
            // Reset the data seek pointer to the beginning
            mysqli_data_seek($result, 0);
            while ($row = mysqli_fetch_assoc($result)) {
                echo 'html += \'<option value="' . $row['d_id'] . '">' . $row['title'] . '</option>\';';
            }
            ?>
            html += '</select>';
            html += '</td>';
            html += '<td><input type="number" style="width: 100%; max-width:none;border:1px solid lightgray;font-size:18px" value=1 name="qty[]" id="qty_' + row_id + '" class="" required oninput="getTotal(' + row_id + ')"></td>';
            html += '<td>';
            html += '<input type="text" name="rate[]" id="rate_' + row_id + '" class="form-control" disabled autocomplete="off">';
            html += '<input type="hidden" name="rate_value[]" id="rate_value_' + row_id + '" class="form-control" autocomplete="off">';
            html += '</td>';
            html += '<td>';
            html += '<input type="text" name="amount[]" id="amount_' + row_id + '" class="form-control" disabled autocomplete="off">';
            html += '<input type="hidden" name="amount_value[]" id="amount_value_' + row_id + '" class="form-control" autocomplete="off">';
            html += '</td>';
            html += '<td><button type="button" class="btn btn-danger" onclick="removeRow(' + row_id + ')"><i class="fa fa-close"></i></button></td>';
            html += '</tr>';

            table.append(html);
            $(".product").select2();
            return false;
        });

    }); // /document

    function getTotal(row = null) {
        if (row) {
            var rate = parseFloat($("#rate_" + row).val());
            var qty = parseInt($("#qty_" + row).val());

            if (!isNaN(rate) && !isNaN(qty)) {
                var total = rate * qty;
                total = total.toFixed(2);
                $("#amount_" + row).val(total);
                $("#amount_value_" + row).val(total);

                subAmount();
            } else {
                alert('Invalid rate or quantity');
            }
        } else {
            alert('No row !! please refresh the page');
        }
    }

    // get the product information from the server
    function getProductData(row_id) {
        var product_id = $("#product_" + row_id).val();
        if (product_id == "") {
            $("#rate_" + row_id).val("");
            // ... Your existing code ...
        } else {
            $.ajax({
                url: 'getProductValueById.php',
                type: 'post',
                data: {
                    product_id: product_id
                },
                dataType: 'json',
                success: function (response) {
                    // Update rate and other fields based on AJAX response
                    $("#rate_" + row_id).val(response.price);
                    // ... Your existing code ...
                    getTotal(row_id);
                },
                error: function () {
                    alert('Error fetching product details');
                }
            });
        }
    }

    // calculate the total amount of the order
    function subAmount() {
        var service_charge = 0; // Set to the appropriate value
        var vat_charge = 0; // Set to the appropriate value

        var tableProductLength = $("#product_info_table tbody tr").length;
        var totalSubAmount = 0;
        for (x = 0; x < tableProductLength; x++) {
            var tr = $("#product_info_table tbody tr")[x];
            var count = $(tr).attr('id');
            count = count.substring(4);

            totalSubAmount = Number(totalSubAmount) + Number($("#amount_" + count).val());
        } // /for

        totalSubAmount = totalSubAmount.toFixed(2);

        // sub total
        $("#gross_amount").val(totalSubAmount);
        $("#gross_amount_value").val(totalSubAmount);

        // vat
        var vat = (Number($("#gross_amount").val()) / 100) * vat_charge;
        vat = vat.toFixed(2);
        $("#vat_charge").val(vat);
        $("#vat_charge_value").val(vat);

        // service
        var service = (Number($("#gross_amount").val()) / 100) * service_charge;
        service = service.toFixed(2);
        $("#service_charge").val(service);
        $("#service_charge_value").val(service);

        // total amount
        var totalAmount = (Number(totalSubAmount) + Number(vat) + Number(service));
        totalAmount = totalAmount.toFixed(2);

        var discount = $("#discount").val();
        if (discount) {
            var grandTotal = Number(totalAmount) - Number(discount);
            grandTotal = grandTotal.toFixed(2);
            $("#net_amount").val(grandTotal);
            $("#net_amount_value").val(grandTotal);
        } else {
            $("#net_amount").val(totalAmount);
            $("#net_amount_value").val(totalAmount);
        } // /else discount
    }

    function removeRow(tr_id) {
        $("#product_info_table tbody tr#row_" + tr_id).remove();
        subAmount();
    }

</script>