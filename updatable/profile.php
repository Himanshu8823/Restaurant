<?php
use Google\Service\MyBusinessVerifications\Verify;
session_start();

include("connection/connect.php");
$passwordSuccessMessage = '';
$errorMessage = '';
function getUser($db, $id)
{
    $query = "SELECT * FROM users WHERE u_id = $id";
    $result = mysqli_query($db, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result);
    } else {
        return null;
    }
}

function updateUser($db, $id, $formArray)
{
    $updateQuery = "UPDATE users SET ";
    foreach ($formArray as $key => $value) {
        $updateQuery .= "$key = '$value', ";
    }
    $updateQuery = rtrim($updateQuery, ", ") . " WHERE u_id = $id";

    return mysqli_query($db, $updateQuery);
}

if (empty($_SESSION["user_id"])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION["user_id"];
$user = getUser($db, $user_id);

if (!$user) {
    header("Location: profile.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["editProfile"]))
    {
        $formArray['username'] = $_POST['username'];
        $formArray['f_name'] = $_POST['firstname'];
        $formArray['l_name'] = $_POST['lastname'];
        $formArray['email'] = $_POST['email'];
        $formArray['phone'] = $_POST['phone'];
        $formArray['address'] = $_POST['address'];

        // Update user information in the database
        updateUser($db, $user_id, $formArray);

        // Update $user variable with the new information
        $user = getUser($db, $user_id);
    } elseif (isset($_POST["editPassword"])) 
    {
        $currentPassword = $_POST['cPassword'];
        $newPassword = $_POST['nPassword'];
        $confirmPassword = $_POST['nRPassword'];
        $query = "SELECT * FROM users WHERE u_id = $user_id";
        $result = mysqli_query($db, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);

            // Verify the current password
            if (password_verify($currentPassword, $user['password'])) {
                // Check if the new password and confirm password match
                if ($newPassword === $confirmPassword) {
                    // Hash the new password
                    $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

                    // Update user password in the database
                    $updateQuery = "UPDATE users SET password = '$hashedPassword' WHERE u_id = $user_id";
                    $updateResult = mysqli_query($db, $updateQuery);

                    if ($updateResult) {
                        $passwordSuccessMessage = "Password updated successfully!";
                    } else {
                        $errorMessage = "Error updating password.";
                    }
                } else {
                    $errorMessage = "New password and confirm password do not match.";
                }
            } else {
                $errorMessage = "Your old password is incorrect.";
            }
        } else {
            $errorMessage = "User not found.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/profile.css">
    <title>User Profile</title>
    <style>
            body{
                background-image: url('images/background_image.gif') !important;
            }            
    </style>
</head>

<body>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <div class="wrapper">
                    <form action="" method="POST">
                        <h4 class="pb-4 border-bottom">Account settings</h4>
                        <div class="py-2">
                            <div>
                                <label for="username">Username</label>
                                <input type="text" name="username" class="bg-light form-control"
                                    value="<?php echo htmlspecialchars($user['username']); ?>">
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="firstname">First Name</label>
                                    <input type="text" name="firstname" class="bg-light form-control"
                                        value="<?php echo htmlspecialchars($user['f_name']); ?>">
                                </div>
                                <div class="col-md-6">
                                    <label for="lastname">Last Name</label>
                                    <input type="text" name="lastname" class="bg-light form-control"
                                        value="<?php echo htmlspecialchars($user['l_name']); ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="email">Email Address</label>
                                    <input type="text" name="email" class="bg-light form-control"
                                        value="<?php echo htmlspecialchars($user['email']); ?>">
                                </div>
                                <div class="col-md-6">
                                    <label for="phone">Contact Number</label>
                                    <input type="tel" name="phone" class="bg-light form-control"
                                        value="<?php echo htmlspecialchars($user['phone']); ?>">
                                </div>
                            </div>
                            <div>
                                <label for="address">Address</label>
                                <textarea name="address" type="text" style="height:70px;"
                                    class="bg-light form-control"><?php echo htmlspecialchars($user['address']); ?></textarea>
                            </div>
                            <div class="py-3 pb-4 border-bottom">
                                <button type="submit" name="editProfile" class="btn btn-primary mr-3">Save
                                    Changes</button>
                                <a href="index.php" class="btn border button">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-md-6">
                <div class="wrapper">
                    <form action="" method="POST">
                        <h4 class="pb-4 border-bottom">Password</h4>
                        <?php if ($passwordSuccessMessage): ?>
                            <div class="alert alert-success">
                                <?php echo $passwordSuccessMessage; ?>
                            </div>
                        <?php endif; ?>
                        <?php if ($errorMessage): ?>
                            <div class="alert alert-danger">
                                <?php echo $errorMessage; ?>
                            </div>
                        <?php endif; ?>
                        <div class="py-2">
                            <div>
                                <input type="password" name="cPassword" class="bg-light form-control mb-2"
                                    placeholder="Current Password">
                            </div>
                            <div>
                                <input type="password" name="nPassword" class="bg-light form-control mb-2"
                                    placeholder="New Password">
                            </div>
                            <div>
                                <input type="password" name="nRPassword" class="bg-light form-control mb-2"
                                    placeholder="Confirm Password">
                            </div>
                            <div class="py-3 pb-4 border-bottom">
                                <button type="submit" name="editPassword" class="btn btn-primary mr-3 mb-2">Save
                                    Changes</button>
                                <a href="index.php" class="btn border button">Cancel</a>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>