<?php
include("connection/connect.php");

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = md5($_POST['password']); // Hash the password
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $firstname = mysqli_real_escape_string($db, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($db, $_POST['lastname']);
    $phone = mysqli_real_escape_string($db, $_POST['phone']);
    $gender = mysqli_real_escape_string($db, $_POST['gender']);
    $rs_id = mysqli_real_escape_string($db, $_POST['rs_id']);

    // Insert data into database
    $insert_query = "INSERT INTO restaurant_admins (username, password, email, firstname, lastname, phone, gender, rs_id) 
                     VALUES ('$username', '$password', '$email', '$firstname', '$lastname', '$phone', '$gender', '$rs_id')";

    if (mysqli_query($db, $insert_query)) {
        // Registration successful
        echo '<script>alert("Registration successful!");</script>';
        echo '<script>window.location.href = "login.php";</script>';
        exit();
    } else {
        // Registration failed
        echo '<script>alert("Error: ' . mysqli_error($db) . '");</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Admin</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Include Bootstrap JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h3 class="text-center mb-0">Sign Up</h3>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" name="username" id="username" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="firstname">First Name</label>
                                <input type="text" name="firstname" id="firstname" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="lastname">Last Name</label>
                                <input type="text" name="lastname" id="lastname" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="text" name="phone" id="phone" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="gender">Gender</label>
                                <select name="gender" id="gender" class="form-control" required>
                                    <option value="">Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="rs_id">Restaurant ID</label>
                                <input type="text" name="rs_id" id="rs_id" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Sign Up</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
