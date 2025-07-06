<?php 
 $rs_id=$_GET['rs_id'];
?>
<head>

</head>
<aside class="main-sidebar" >
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li id="dashboardMainMenu">
          <a href=<?php echo "dashboard.php?rs_id=".$rs_id ?> >
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
        <?php if(isset($_SESSION['username'])){ ?>  
        <li class="treeview" id="userMainNav">
          <a href="#">
            <i class="fa fa-users"></i>
            <span>Employees</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          
          <ul class="treeview-menu">
            <li id="createUserSubNav"><a href=<?php echo "employees.php?rs_id=".$rs_id;?>><i class="fa fa-circle-o"></i> Manage Employees</a></li>
            <li id="manageUserSubNav"><a href="<?php echo "employee_documents.php?rs_id=".$rs_id;?>"><i class="fa fa-circle-o"></i> Employee Documents</a></li>
            <li id="manageUserSubNav"><a href="<?php echo "employee_attendance.php?rs_id=".$rs_id;?>"><i class="fa fa-circle-o"></i> Employee Attendance</a></li>
            <li id="manageUserSubNav"><a href="<?php echo "employee_payroll.php?rs_id=".$rs_id;?>"><i class="fa fa-circle-o"></i> Employee payroll</a></li>
            <li id="manageUserSubNav"><a href="<?php echo "leave_allowance.php?rs_id=".$rs_id;?>"><i class="fa fa-circle-o"></i> Employee Leave Allowance</a></li>            
          </ul>
        </li>
        <?php } ?>

   
        <li class="treeview" id="groupMainNav">
          <a href="#">
            <i class="fa fa-table"></i>
            <span>Tables</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
        <ul class="treeview-menu">
              <li id="tablesMainNav"><a href="tables.php?rs_id=8"><i class="fa fa-table"></i> <span>Add Tables</span></a></li>
              <li id="tablesMainNav"><a href="book_table.php?rs_id=8"><i class="fa fa-table"></i> <span>Book Table</span></a></li>
        </ul>
        </li>
          
        <?php if(isset($_SESSION['manager'])||isset($_SESSION['username'])){ ?>
        <li class="treeview" id="productMainNav">
          <a href="#">
            <i class="fa fa-cutlery"></i>
            <span>Menu</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li id="createProductSubMenu"><a href=<?php echo "create_menu.php?rs_id=".$rs_id;?>><i class="fa fa-circle-o"></i> Add Menu</a></li>
            <li id="manageProductSubMenu"><a href=<?php echo "manage_menu.php?rs_id=".$rs_id;?>><i class="fa fa-circle-o"></i> Manage Menu</a></li>
          </ul>
        </li>
        <?php } ?>
        <li class="treeview" id="OrderMainNav">
          <a href="#">
            <i class="fa fa-clipboard"></i>
            <span>Orders</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li id="createOrderSubMenu"><a href=<?php echo "create_order.php?rs_id=".$rs_id ?> ><i class="fa fa-circle-o"></i> Add order</a></li>
            <li id="manageOrderSubMenu"><a href=<?php echo "orders_show.php?rs_id=".$rs_id;?>><i class="fa fa-circle-o"></i> Manage Orders</a></li>
            <li id="onlineOrderSubMenu"><a href=<?php echo "online_orders.php?rs_id=".$rs_id ?> ><i class="fa fa-circle-o"></i> Online Orders</a></li>
          </ul>
        </li>

        <li class="treeview" id="ReportMainNav">
          <a href="#">
            <i class="fa fa-file-pdf-o"></i>
            <span>Reports</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li id="productReportSubMenu"><a href=<?php echo "product_report.php?rs_id=".$rs_id;?>><i class="fa fa-circle-o"></i> Year Wise</a></li>
            <li id="productReportSubMenu"><a href=<?php echo "Monthly_product_report.php?rs_id=".$rs_id;?>><i class="fa fa-circle-o"></i> Month Wise</a></li>
          </ul>
        </li>
        <?php if(isset($_SESSION['cashier'])||isset($_SESSION['manager'])||isset($_SESSION['username'])){ ?>
        <li class="treeview" id="ReportMainNav">
          <a href="#">
            <i class="fa fa-cutlery"></i>
            <span>Mess Dashboard</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
          <li id="companyMainNav"><a href=<?php echo "mess_dashboard.php?rs_id=".$rs_id;?>><i class="fa fa-user"></i> <span>Mess Dashboard</span></a></li>
          <li id="companyMainNav"><a href=<?php echo "mess_attendance.php?rs_id=".$rs_id;?>><i class="fa fa-user"></i> <span>Mess Attendance</span></a></li>
          <li id="companyMainNav"><a href=<?php echo "mess_menu_management.php?rs_id=".$rs_id;?>><i class="fa fa-user"></i> <span>Mess Menu Management</span></a></li>
          <li id="companyMainNav"><a href=<?php echo "view_mess_menus.php?rs_id=".$rs_id;?>><i class="fa fa-user"></i> <span>View Mess Menu</span></a></li>
          <li id="companyMainNav"><a href=<?php echo "view_mess_orders.php?rs_id=".$rs_id;?>><i class="fa fa-user"></i> <span>View Mess Order</span></a></li>
          <li id="companyMainNav"><a href=<?php echo "mess_order.php?rs_id=".$rs_id;?>><i class="fa fa-user"></i> <span>Create Mess Order</span></a></li>
          <li id="companyMainNav"><a href=<?php echo "view_mess_customers.php?rs_id=".$rs_id;?>><i class="fa fa-user"></i> <span> View Mess Customer</span></a></li>
          <li id="companyMainNav"><a href=<?php echo "create_mess_customer.php?rs_id=".$rs_id;?>><i class="fa fa-user"></i> <span> Create Mess Customer</span></a></li>
          <li id="companyMainNav"><a href=<?php echo "view_payments.php?rs_id=".$rs_id;?>><i class="fa fa-user"></i> <span> View Mess Payments</span></a></li>
          <li id="companyMainNav"><a href=<?php echo "manage_payments.php?rs_id=".$rs_id;?>><i class="fa fa-user"></i> <span> Manage Mess Payments</span></a></li>
          <li id="companyMainNav"><a href=<?php echo "mess_reports_analysis.php?rs_id=".$rs_id;?>><i class="fa fa-user"></i> <span> Mess Report Analysis</span></a></li>
          </ul>
        </li>      
        <?php } ?>
        <?php if(isset($_SESSION['manager'])||isset($_SESSION['username'])){ ?>
        <li class="treeview" id="ReportMainNav">
          <a href="#">
            <i class="fa fa-industry"></i>
            <span>Supplier</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
          <li id="companyMainNav"><a href=<?php echo "add_supplier.php?rs_id=".$rs_id;?>><i class="fa fa-user"></i> <span>Add Supplier</span></a></li>
          <li id="companyMainNav"><a href=<?php echo "view_suppliers.php?rs_id=".$rs_id;?>><i class="fa fa-user"></i> <span>View Suppliers</span></a></li>
          <li id="companyMainNav"><a href=<?php echo "add_supplier_product.php?rs_id=".$rs_id;?>><i class="fa fa-user"></i> <span>Add Supplier Product</span></a></li>
          <li id="companyMainNav"><a href=<?php echo "view_supplier_product.php?rs_id=".$rs_id;?>><i class="fa fa-user"></i> <span>View Suppliers product</span></a></li>
          <li id="companyMainNav"><a href=<?php echo "create_purchase_order.php?rs_id=".$rs_id;?>><i class="fa fa-user"></i> <span>Create Purchase Order</span></a></li>
          <li id="companyMainNav"><a href=<?php echo "inventory_view_purchase_orders.php?rs_id=".$rs_id;?>><i class="fa fa-user"></i> <span>View Purchase Order</span></a></li>
          <li id="companyMainNav"><a href=<?php echo "record_transactions.php?rs_id=".$rs_id;?>><i class="fa fa-user"></i> <span>Record Transaction</span></a></li>
          </ul>
        </li>
        <?php } ?>
        <?php if(isset($_SESSION['manager'])||isset($_SESSION['username'])){ ?>
        <li id="companyMainNav"><a href=<?php echo "show_feedbacks.php?rs_id=".$rs_id;?>><i class="fa fa-comments"></i> <span>Restaurant Feedbacks</span></a></li>
        <?php } ?>
        <?php if(isset($_SESSION['username'])){ ?>
        <li id="companyMainNav"><a href=<?php echo "company.php?rs_id=".$rs_id;?>><i class="fa fa-info-circle"></i> <span>Restaurant Info</span></a></li>
        <?php }?>
        <li id="profileMainNav"><a href=<?php echo "profile.php?rs_id=".$rs_id;?>><i class="fa fa-user"></i> <span>Profile</span></a></li>
        <?php if(isset($_SESSION['username'])){ ?>
        <li id="settingMainNav"><a href=<?php echo "settings.php?rs_id=".$rs_id;?>><i class="fa fa-wrench"></i> <span>Setting</span></a></li>
         <?php } ?>
        <li><a href="logout.php"><i class="fa fa-power-off"></i> <span>Logout</span></a></li>

      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
