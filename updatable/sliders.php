<?php
    include "connection/connect.php";
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="author" content="CodePel">
      <!-- Style CSS -->
      <link rel="stylesheet" href="css/feedback_slider.css">
      <link href="css/font-awesome.min.css" rel="stylesheet">   
      <!-- Demo CSS (No need to include it into your project) -->
      <link rel="stylesheet" href="css/demo.css">
      <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css'>
        <title>Starter Template for Bootstrap</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        
   </head>
   <body style="background-image:url('images/background_image.gif')">
   <?php
        $query = "SELECT * FROM website_feedbacks ORDER BY created_at DESC LIMIT 6";
        $result = mysqli_query($db, $query);

        $reviews = array();

        while ($row = mysqli_fetch_assoc($result)) {
            $reviews[] = $row;
        }

        mysqli_close($db);
        ?>
<main class="cd__main" style="box-shadow:none">
    <!-- Start DEMO HTML (Use the following code into your project)-->
    <div class="container" style="background-image:url('images/background_image.gif')">
        <div class="swiper swiperCarousel">
            <div class="swiper-wrapper">
                <?php foreach ($reviews as $review): ?>
                    <div class="swiper-slide">
                        <div class="card">
                            <img class="avatar" src="https://t4.ftcdn.net/jpg/05/89/93/27/360_F_589932782_vQAEAZhHnq1QCGu5ikwrYaQD0Mmurm0N.jpg" alt="User Image">                            
                            <div class="header">
                                <h1 class="name"><?php echo $review['name']; ?></h1>                                

                            </div>
                            <div class="star-rating" data-rating="<?php echo $review['rating']; ?>">
                                <?php
                                    $filledStars = intval($review['rating']);
                                    $emptyStars = 5 - $filledStars;
                                    
                                    for ($i = 0; $i < $filledStars; $i++) {
                                        echo '<span class="fa fa-star filled" style="color:gold"></span>';
                                    }
                                    
                                    for ($i = 0; $i < $emptyStars; $i++) {
                                        echo '<span class="fa fa-star" style="color:lightgray"></span>';
                                    }
                                ?>
                            </div>
                            <div class="quote-container" style="padding-top:20px;">
                            <p class="quote" style="font-size:20px"><?php echo $review['design_feedback']; ?></p>                                
                                
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="swiper-button-next" style="color:white"></div>
            <div class="swiper-button-prev" style="color:white"></div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
    <!-- END DEMO HTML (Happy Coding!)-->
</main>


      <script src='https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/textfit/2.4.0/textFit.min.js'></script>
      <!-- Script JS -->
      <script src="js/js/script.js"></script>
      <!--$%analytics%$-->
   </body>
</html>
