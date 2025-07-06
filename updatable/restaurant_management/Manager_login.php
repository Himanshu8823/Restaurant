<?php
include("connection/connect.php");

// Initialize session
session_start();
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = md5($_POST['password']); // Hash the password

    // Query to check user credentials
    $query = "SELECT * FROM employees WHERE username='$username' AND password='$password' AND role='Manager'";
    $result = mysqli_query($db, $query);

    if (mysqli_num_rows($result) == 1) {
        // User authenticated
        $row = mysqli_fetch_assoc($result);
        $_SESSION['manager'] = $username;
        $_SESSION['employee_id']=$row["employee_id"];
        $_SESSION['rs_id'] = $row['rs_id'];
        header("Location: partials/dashboard.php?rs_id=" . $_SESSION['rs_id']); // Redirect to dashboard with rs_id in URL
        exit();
    } else {
        // Authentication failed
        echo '<script>alert("Invalid username or password!");</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- Custom CSS -->
  <style>
    body {
      background-color: #f8f9fa;
      background-image:url('images/background-login-image.jpg');
      background-repeat: no-repeat;
      background-size: cover;
      background-position: center;
    }

    .card {
      border: none;
      border-radius: 20px;
      box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.1);
    }

    .card-header {
      border-bottom: none;
      border-top-left-radius: 20px;
      border-top-right-radius: 20px;
      background-color: #007bff;
      color: white;
      text-align: center;
    }

    .form-control {
      border-radius: 10px;
      border: 1px solid #ced4da;
    }

    .form-control:focus {
      border-color: #007bff;
      box-shadow: none;
    }

    .btn-primary {
      background-color: #007bff;
      border: none;
      border-radius: 10px;
      padding: 12px;
      width: 100%;
    }

    .btn-primary:hover {
      background-color: #0056b3;
    }

    .container {
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">
          <h3 class="mb-0">Manager Login</h3>
          <h4 class="justify-content-end" style="float:right"><a href="cashier_login.php" style="text-decoration:none;color:white">Cashier</a></h4>
          <h4 class="justify-content-end" style="float:right"><a href="login.php" style="text-decoration:none;color:white">Admin|</a></h4>
          
          
        </div>
        <div class="card-body">
          <form action="" method="post">
            <div class="form-group">
              <input type="text" class="form-control" id="username" name="username" placeholder="Username" autocomplete="off" required>
            </div>

            <div class="form-group">
              <input type="password" class="form-control" id="password" name="password" placeholder="Password" autocomplete="off" required>
            </div>

            <button type="submit" class="btn btn-primary">Login</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
