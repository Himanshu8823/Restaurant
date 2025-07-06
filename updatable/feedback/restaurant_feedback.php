<!DOCTYPE html>
<?php 
    include("../connection/connect.php");
    session_start();
?>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Restaurant Feedback Form</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <style>
    .container{
        width: 90%;
        position: relative;
        margin-left: auto;
        margin-right: auto;
        
    }
    h1#feedback-form-title {
      text-align: center;
      margin-bottom: 20px;
    }

    .form-group {
      margin-bottom: 15px;
    }

    label.feedback-label {
      display: block;
      margin-bottom: 5px;
      font-weight: bold;
    }

    input#feedback-name,
    input#feedback-email,
    select#feedback-rating,
    textarea#feedback-message {
      width: 100%;
      padding: 8px;
      border-radius: 5px;
      border: 1px solid green;
      font-size: 20px;
    }

    .star-rating-1 {
      font-size: 24px;
      color: #1d878b;
      cursor: pointer;
    }

    .star-rating-1 i:hover,
    .star-rating-1 i.active {
      color: #ffd700;
    }

    button#submit-feedback-btn {
      padding: 10px 20px;
      background-color: #4e1d1d;
      color: #fff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 20px;
    }

    button#submit-feedback-btn:hover {
      background-color: #c8521b;
    }
    .rest
    {
        text-align: right;
        font-size: 30px;
    }
    label{
        font-size: 25px;
        color:white
    }
    h1{
        font-size: 40px;
        color: blueviolet;
    }
    h3{
        font-size: 35px;
        color:brown;
    }
  </style>
</head>
<body>
<?php
        $rs_id = isset($_GET['rs_id']) ? $_GET['rs_id'] : null;
     
    ?>
  <div class="container">
    <h1 id="feedback-form-title">Restaurant Feedback Form  </h1>
    <div class="rest">
       <?php 
                    if (isset($_GET['rs_id'])) {
                        $rs_id = $_GET['rs_id'];
                                            
                        $stmt = $db->prepare("SELECT title, image FROM restaurant WHERE rs_id = ?");
                        $stmt->bind_param("i", $rs_id);
                        $stmt->execute();
                        $stmt->bind_result($restaurantName, $restaurantImage);                                
                        if ($stmt->fetch()) 
                        {
                            echo "<h3>Restaurant Name: " . $restaurantName."</h3>";
                            echo '<br><img src="../admin/Res_img/' . $restaurantImage . '" alt="Restaurant Logo" height=200px width=200px>';
                        }
                    
                        // Close the statement
                        $stmt->close();
                    }
                
        ?>
    </div>
    <form id="feedback-form" action="submit_feedback.php" method="POST" >
        <input type="hidden" name="rs_id" value="<?php echo $rs_id ?>">
      <div class="form-group">
        <label for="feedback-name" class="feedback-label">Name:</label>
        <input type="text" id="feedback-name" name="name" required>
      </div>
      <div class="form-group">
        <label for="feedback-email" class="feedback-label">Email:</label>
        <input type="email" id="feedback-email" name="feedback-email" required>
      </div>
      <div class="form-group">
        <label for="feedback-rating" class="feedback-label">Rating:</label>
        <div class="star-rating-1" id="feedback-rating">
          <i class="fas fa-star" data-rating="1"></i>
          <i class="fas fa-star" data-rating="2"></i>
          <i class="fas fa-star" data-rating="3"></i>
          <i class="fas fa-star" data-rating="4"></i>
          <i class="fas fa-star" data-rating="5"></i>
          <input type="hidden" name="rating" id="rating-value" required>
        </div>
      </div>
      <div class="form-group">
        <label for="feedback-message" class="feedback-label">Feedback:</label>
        <textarea id="feedback-message" name="message" rows="4" required></textarea>
      </div><br>
      <center><button type="submit" id="submit-feedback-btn">Submit</button></center>
    </form>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const stars = document.querySelectorAll(".star-rating-1 i");
      const ratingValue = document.getElementById("rating-value");

      stars.forEach((star, index) => {
        star.addEventListener("mouseover", function () {
          highlightStars(index + 1);
        });

        star.addEventListener("mouseout", function () {
          const rating = ratingValue.value || 0;
          highlightStars(rating);
        });

        star.addEventListener("click", function () {
          const rating = index + 1;
          ratingValue.value = rating;
          highlightStars(rating);
        });
      });

      function highlightStars(rating) {
        stars.forEach((star, index) => {
          star.classList.toggle("active", index < rating);
        });
      }
    });
  </script>
</body>
</html>
