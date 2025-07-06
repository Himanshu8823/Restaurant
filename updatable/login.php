<?php
  include('config.php');
  $login_button=true;
  include("connection/connect.php"); //INCLUDE CONNECTION
  error_reporting(0); // hide undefine index errors
  session_start(); // temp sessions
  if (isset($_GET['code'])) {
    // Handle Google OAuth2 response
    $token = $google_client->fetchAccessTokenWithAuthCode($_GET['code']);
    if (!isset($token['error'])) {
        $google_client->setAccessToken($token['access_token']);
        $_SESSION['access_token'] = $token['access_token'];
        $google_service = new Google_Service_Oauth2($google_client);
        $data = $google_service->userinfo->get();

        $email = $data['email'];
        $firstName = $data['givenName'];
        $lastName = $data['familyName'];
        $address = '';
        $phone = '';
        if (isset($data['address'])) {
            $address = $data['address'];
        }
        if (isset($data['phone'])) {
            $phone = $data['phone'];
        }
        $randomPassword = generateRandomPassword();

        // Check if the user already exists in the database
        $selectQuery = "SELECT * FROM users WHERE email='$email' AND username='$firstName'";
        $result = mysqli_query($db, $selectQuery);
        $row = mysqli_fetch_array($result);

        if (is_array($row)) {
            $_SESSION['user_id'] = $row['u_id'];
            // Redirect to index.php or any other desired page
            header("location:index.php");
            exit();
        } else {
            // If the user doesn't exist, insert them into the database
            $insertQuery = "INSERT INTO users(username, f_name, l_name, email, phone, password, address) 
                            VALUES('$firstName', '$firstName', '$lastName', '$email', '$phone',  '" . md5($randomPassword) . "','$address')";
            mysqli_query($db, $insertQuery);
            
            // Fetch the user ID after insertion
            $selectInsertedQuery = "SELECT u_id FROM users WHERE email='$email'";
            $resultInserted = mysqli_query($db, $selectInsertedQuery);
            $rowInserted = mysqli_fetch_array($resultInserted);

            if (is_array($rowInserted)) {
                $_SESSION['user_id'] = $rowInserted['u_id'];
                // Redirect to index.php or any other desired page
                header("location:index.php");
                exit();
            } else {
                // Handle the case where fetching the user ID after insertion fails
                echo "Error fetching user ID after insertion.";
                exit();
            }
        }
    } else {
        // Handle the case where fetching the access token results in an error
        echo "Error fetching access token: " . $token['error'];
        exit();
    }
}

  function generateRandomPassword($length = 8) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomPassword = '';
    for ($i = 0; $i < $length; $i++) {
        $randomPassword .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomPassword;
}
?>

<!DOCTYPE html>
<html lang="en" >

<head>
  <meta charset="UTF-8">
  <title>login</title>
  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">

  <link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900|RobotoDraft:400,100,300,500,700,900'>
<link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>

 <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animsition.min.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet"> </head>
      <link rel="stylesheet" href="css/login.css">

	  <style type="text/css">
	  #buttn{
		  color:#fff;
      font-size: 20px;
		  background-color: #ff3300;
	  }
	  </style>
  
</head>

<body>
<?php

if(isset($_POST['submit']))   // if button is submit
{
	$username = $_POST['username'];  //fetch records from login form
	$password = $_POST['password'];
	
	if(!empty($_POST["submit"]))   // if records were not empty
     {
	$loginquery ="SELECT * FROM users WHERE username='$username' && password='".md5($password)."'"; //selecting matching records
	$result=mysqli_query($db, $loginquery); //executing
	$row=mysqli_fetch_array($result);
	
	                        if(is_array($row))  // if matching records in the array & if everything is right
								{
                                    	$_SESSION["user_id"] = $row['u_id']; // put user id into temp session
										 header("refresh:1;url=index.php"); // redirect to index.php page
	                            } 
							else
							    {
                                      	$message = "Invalid Username or Password!"; // throw error
                                }
	 }
	
	
}

?>
  
  <?php include "header.php"; ?>
<!-- Form Mixin-->
<!-- Input Mixin-->
<!-- Button Mixin-->
<!-- Pen Title-->
<div class="pen-title" style="padding-bottom:5%">
  
</div>
<!-- Form Module-->
<div class="module form-module">
  <div class="toggle">
   
  </div>
  <div class="form" >
    <h2 style="font-size: 25px;;">Login to your account</h2>
	  <span style="color:red;"><?php echo $message; ?></span> 
   <span style="color:green;"><?php echo $success; ?></span>
    <form action="" method="post">
      <input type="text" placeholder="Username"  name="username"/>
      <input type="password" placeholder="Password" name="password"/>
      <input type="submit" id="buttn" name="submit" value="login" />
      <center>or</center><br><br>
	    <a href="<?=$google_client->createAuthUrl()?>"  class="login-with-google-btn">
    Login with Google</a>
    </form>
  </div>
  
  <div class="cta">Not registered?<a href="registration.php" style="color:#f30;"> Create an account</a></div>
</div>
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

  
<style>
  /* Update the CSS for better styling and responsiveness */
  body{
    background-image: url("images/pattern.png");
  }
.form {
    font-size: 20px;
}

.login-with-google-btn {
    transition: background-color 0.3s, box-shadow 0.3s;
    text-decoration: none;
    padding: 12px 90px;
    border: none;
    border-radius: 5px;
    box-shadow: 0 -1px 0 rgba(0, 0, 0, 0.04), 0 1px 1px rgba(0, 0, 0, 0.25);
    color: white;
    font-size: 20px;
    font-weight: 500;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, "Fira Sans", "Droid Sans", "Helvetica Neue", sans-serif;
    background-image: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTgiIGhlaWdodD0iMTgiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGcgZmlsbD0ibm9uZSIgZmlsbC1ydWxlPSJldmVub2RkIj48cGF0aCBkPSJNMTcuNiA5LjJsLS4xLTEuOEg5djMuNGg0LjhDMTMuNiAxMiAxMyAxMyAxMiAxMy42djIuMmgzYTguOCA4LjggMCAwIDAgMi42LTYuNnoiIGZpbGw9IiM0Mjg1RjQiIGZpbGwtcnVsZT0ibm9uemVybyIvPjxwYXRoIGQ9Ik05IDE4YzIuNCAwIDQuNS0uOCA2LTIuMmwtMy0yLjJhNS40IDUuNCAwIDAgMS04LTIuOUgxVjEzYTkgOSAwIDAgMCA4IDV6IiBmaWxsPSIjMzRBODUzIiBmaWxsLXJ1bGU9Im5vbnplcm8iLz48cGF0aCBkPSJNNCAxMC43YTUuNCA1LjQgMCAwIDEgMC0zLjRWNUgxYTkgOSAwIDAgMCAwIDhsMy0yLjN6IiBmaWxsPSIjRkJCQzA1IiBmaWxsLXJ1bGU9Im5vbnplcm8iLz48cGF0aCBkPSJNOSAzLjZjMS4zIDAgMi41LjQgMy40IDEuM0wxNSAyLjNBOSA5IDAgMCAwIDEgNWwzIDIuNGE1LjQgNS40IDAgMCAxIDUtMy43eiIgZmlsbD0iI0VBNDMzNSIgZmlsbC1ydWxlPSJub256ZXJvIi8+PHBhdGggZD0iTTAgMGgxOHYxOEgweiIvPjwvZz48L3N2Zz4=);
    background-color: #005EB8;
    background-repeat: no-repeat;
    background-position: 12px 18px;
}

.login-with-google-btn:hover {
    box-shadow: 0 -1px 0 rgba(0, 0, 0, 0.04), 0 2px 4px rgba(0, 0, 0, 0.25);
}

.login-with-google-btn:active {
    background-color: #eeeeee;
}

.login-with-google-btn:focus {
    outline: none;
    box-shadow: 0 -1px 0 rgba(0, 0, 0, 0.04), 0 2px 4px rgba(0, 0, 0, 0.25), 0 0 0 3px #c8dafc;
}

.login-with-google-btn:disabled {
    filter: grayscale(100%);
    background-color: #ebebeb;
    box-shadow: 0 -1px 0 rgba(0, 0, 0, 0.04), 0 1px 1px rgba(0, 0, 0, 0.25);
    cursor: not-allowed;
}

/* Add some animation */
.module {
    transition: transform 0.3s ease-in-out;
}

.module:hover {
    transform: scale(1.05);
}

.cta a {
    color: #f30;
}

.cta a:hover {
    color: #f00;
}

</style>
   



</body>

</html>
