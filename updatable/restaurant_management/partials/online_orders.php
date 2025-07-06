<?php 
        session_start();
        include("../connection/connect.php");
        if (!isset($_SESSION['manager'])&&!isset($_SESSION['username'])&&!isset($_SESSION['cashier'])) {
            header("Location: ../login.php");
            exit(); 
        }
        include("hel.php");
        include('header_menu.php');
        include('header.php');
        include('sidebar.php');
        $rs_id=$_GET['rs_id'];
    ?>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
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
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Manage
                <small>Online Orders</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Online Orders</li>
            </ol>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">All User Orders</h3>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table id="example"
                                    class="display nowrap table table-hover table-striped table-bordered"
                                    cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Username</th>
                                            <th>Title</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Description</th>
                                            <th>Address</th>
                                            <th>Status</th>                                            
                                            <th>Action</th>
                                            <th>Reg-Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $sql = "SELECT users.*, users_orders.* 
                                                FROM users 
                                                INNER JOIN users_orders ON users.u_id = users_orders.u_id                                                  
                                                ORDER BY users_orders.date DESC";
                                            
                                            $query = mysqli_query($db, $sql);

                                            if (!mysqli_num_rows($query) > 0) {
                                                echo '<tr><td colspan="8"><center>No Orders-Data!</center></td></tr>';
                                            } else {
                                                while ($rows = mysqli_fetch_array($query)) {
                                                    ?>
                                                    <tr data-order-id="<?php echo $rows['o_id']; ?>">
                                                        <td><?php echo $rows['username']; ?></td>
                                                        <td><?php echo $rows['title']; ?></td>
                                                        <td><?php echo $rows['quantity']; ?></td>
                                                        <td>Rs <?php echo $rows['price']; ?></td>
                                                        <?php if($rows['order_description']!=""){
                                                            ?>
                                                        <td><?php echo $rows['order_description']; ?></td>
                                                        <?php 
                                                        }else
                                                        { ?>
                                                            <td><?php echo "No description" ?></td>
                                                        <?php } ?>    
                                                        <td><?php echo $rows['address']; ?></td>
                                                        <td class="status-cell">
                                                            <?php if($rows['status']==null){                                                                 
                                                                 echo  '<button type="button" class="btn btn-info" style="font-weight:bold;">
                                                                        <span class="fa fa-bars" aria-hidden="true">Dispatch
                                                                    </button>';
                                                                }
                                                                    else if($rows['status']=="in process")
                                                                    {
                                                                        echo  '<button type="button" class="btn btn-warning" style="font-weight:bold;">
                                                                                    <span class="fa fa-bars" aria-hidden="true">On the way
                                                                                </button>';
                                                                    }                                                                    
                                                                    else if($rows['status']=="closed")
                                                                    {
                                                                        echo  '<button type="button" class="btn btn-success" style="font-weight:bold;">
                                                                                    <span class="fa fa-check" aria-hidden="true">Completed
                                                                                </button>';
                                                                    }
                                                                    else if($rows['status']=="rejected")
                                                                    {
                                                                        echo  '<button type="button" class="btn btn-danger" style="font-weight:bold;">
                                                                                    <span class="fa fa-bars" aria-hidden="true">Rejected
                                                                                </button>';
                                                                    }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <a href="delete_orders.php?order_del=<?php echo $rows['o_id']; ?>"
                                                                onclick="return confirm('Are you sure?');" class="btn btn-danger btn-flat btn-addon btn-xs m-b-10">
                                                                <i class="fa fa-trash-o" style="font-size:16px"></i>
                                                            </a>
                                                            <a href="view_order.php?rs_id=<?php echo $_SESSION['rs_id']; ?>&&order_id=<?php echo $rows['o_id']; ?>"
                                                                class="btn btn-info btn-flat btn-addon btn-sm m-b-10 m-l-5">
                                                                <i class="fa fa-cog"></i>
                                                            </a>
                                                        </td>
                                                        <td><?php echo $rows['date']; ?></td>
                                                        
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Necessary Libraries -->
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
            $('#example').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'pdf','print' 
                ],
                order: [[6, 'desc']] // Sort by the 6th column (date) in descending order by default
            });
        });
    </script>
</body>
</html>