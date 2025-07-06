<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<script src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
<style>
  @import url("https://fonts.googleapis.com/css?family=Poppins:400,500,700");

  .navbar {
    padding: 0.8rem;
    position: sticky;
    background-image: none;
  }

  .navbar-brand {
    font-family: Verdana, Geneva, Tahoma, sans-serif;
    font-weight: bold;
    font-size: 1.5rem;
    color:black !important;
  }

  .navbar li {
    padding-right: 10px;
    color:black !important;;
  }

  .nav-link {
    font-size: 22px;
    color:black !important;;
  }
  .dropdown:hover .dropdown-menu {
    display: block;
    color:black !important;;
  }

  .dropdown-menu {
    margin-top: 0;
  }
</style>
<?php
include("connection/connect.php");
error_reporting(0);  // using to hide undefine undex errors
session_start();

if (!empty($_SESSION["user_id"])) {
  // Retrieve user information from the database
  $user_id = $_SESSION["user_id"];
  $query = "SELECT username FROM users WHERE u_id = '$user_id'";
  $result = mysqli_query($db, $query);

  if ($result) {
    $row = mysqli_fetch_assoc($result);
    $user_name = $row['username'];
  } else {
    // Handle database query error
    $user_name = "Error";
  }
}
?>
<header id="header" class="header-scroll top-header headrom" style="background-color:white;padding-right:10px">
  <!-- .navbar -->
  <img src="data:image/jpeg;base64,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" alt="homepage" class="dark-logo" width="60px" height="60px" style="border-radius:100%;margin-top:2px;margin-left:5px;" align="left" />
  <nav class="navbar navbar-dark">
    <button class="navbar-toggler hidden-lg-up" type="button" data-toggle="collapse"
      data-target="#mainNavbarCollapse">&#9776;</button>
    <a class="navbar-brand" href="index.php"> </a>
    <div class="collapse navbar-toggleable-md  float-lg-right" id="mainNavbarCollapse">
  
      <ul class="nav navbar-nav">        
        <li class="nav-item"> <a class="nav-link active" href="index.php">Home <span
              class="sr-only">(current)</span></a> </li>

        <li class="nav-item"> <a class="nav-link active" href="restaurants.php">Restaurants <span
              class="sr-only"></span></a> </li>
        <li class="nav-item"> <a class="nav-link active" href="bookings/table_booking.php">Table Booking <span
              class="sr-only"></span></a> </li>

        <li class="active nav-item">
          <a class="nav-link " href="restaurant_management/login.php"> restaurant management</a>
        </li>

        <?php
        if (empty($_SESSION["user_id"])) // if user is not login
        {
          echo '<li class="nav-item"><a href="login.php" class="nav-link active">login</a> </li>
							  <li class="nav-item"><a href="registration.php" class="nav-link active">signup</a> </li>';
        } else { ?>
          <li class="nav-item dropdown active"  style='color:black'>
            <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button"
              data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color:black">
              <?php
              echo "<span style='color:black'> $user_name</span>";
              ?>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown"  style='color:black'>
              <a class="dropdown-item"  style='color:black' href="profile.php"><i class="fas fa-user-circle" ></i> My Profile</a>
              <hr>
              <a class="dropdown-item" href="your_orders.php"><i class="fas fa-shopping-bag"></i> Orders</a>
              <hr>
              <a class="dropdown-item" href="logout.php"><i class="fas fa-power-off"></i> Logout</a>
            </div>
          </li>
          <li class="nav-item active">
            <a class="nav-link text-white" href="checkout.php"><i  style='color:black' class="fas fa-cart-arrow-down"></i><span  style='color:black'> My Cart</span></a>
          </li>
          <?php
        }

        ?>
        <li class="nav-item"> <a class="nav-link active" href="location_search.php"><i class="fa fa-search"></i>
          </a> </li>
      </ul>
        
    </div>
  </nav>
  <!-- /.navbar -->
</header>