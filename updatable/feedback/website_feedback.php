    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Website Feedback Form</title>
        <style>
            #bd {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;            
                margin: 0;
                padding: 0;
                display: flex;
                justify-content: center;
                align-items: center;
                background-image:url('images/background_image.gif');
                
            }

            #feedbackForm{
                
                padding: 10px;
                border-radius: 10px;
                margin-top: 20px;
                width: 800px;;
                text-align: center;
            }

            #hea {
                padding-top: 50px;
                color: white;
                font-size: 30px;
            }

            .form-group {
                margin-bottom: 20px;
                text-align: left;
            }

            .form-label {
                display: inline-block;
                margin-bottom: 5px;
                font-weight: bold;
                color: white;
                font-size: 20px;
                width: 150px; /* Set a fixed width for labels */
            }

            .form-input,
            .form-input-number,
            .form-textarea {
                width: calc(100% - 12px);
                padding: 12px;
                box-sizing: border-box;
                border: 1px solid #ccc;
                border-radius: 6px;
                font-size: 18px;
                display: inline-block;
                margin-bottom: 10px;
            }

            .form-input-number {
                width: calc(50% - 12px); /* Set width for number inputs */
            }

            .form-textarea {
                height: 100px;
            }

            .form-button {
                background-color: #4caf50;
                color: #fff;
                padding: 15px;
                border: none;
                border-radius: 6px;
                cursor: pointer;
                font-size: 18px;
                transition: background-color 0.3s ease;
            }

            .form-button:hover {
                background-color: #45a049;
            }

            .error-message {
                color: #f00;
                font-size: 14px;
                margin-top: -15px;
                margin-bottom: 15px;
            }
            .rating-container {
            display: inline-block;
            font-size: 0; /* Remove any default font-size */
        }

        .rating-container {
            display: inline-block;
            font-size: 30px;
        }

        .rating-stars {
            color: #ddd;
            cursor: pointer;
        }

        .rating-stars.selected {
            color: #ffcc00;
        }
        </style>
    </head>

    <body id="bd" >
        <form id="feedbackForm" action="feedback_process.php" method="POST">
            <h2 id="hea">Website Feedback</h2>

            <div class="form-group">
                <label for="name" class="form-label">Your Name:</label>
                <input type="text" id="name" name="name" class="form-input" required>
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Your Email:</label>
                <input type="email" id="email" name="email" class="form-input" required>
            </div>
            <div class="form-group">
            <label for="rating" class="form-label">Rating:</label>
            <input type="hidden" id="rating" name="rating" class="form-input-number" value="5" required>
            <!-- Display stars for rating -->
            <div class="rating-container" onclick="setRating(event)">
                <span class="rating-stars" data-value="1">★</span>
                <span class="rating-stars" data-value="2">★</span>
                <span class="rating-stars" data-value="3">★</span>
                <span class="rating-stars" data-value="4">★</span>
                <span class="rating-stars" data-value="5" class="selected">★</span>
            </div>
        </div>

            <div class="form-group">
                <label for="easeOfUse" class="form-label">Ease of Use (1-10):</label>
                <select id="easeOfUse" name="easeOfUse" class="form-input-number" required>
                    <option value="" disabled selected>Select ease of use</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                </select>
            </div>

            <div class="form-group">
                <label for="design" class="form-label">Design Feedback:</label>
                <textarea id="design" name="design" rows="4" class="form-input form-textarea" required></textarea>
            </div>

            <div class="form-group">
                <label for="improvements" class="form-label">Suggestions for Improvement:</label>
                <textarea id="improvements" name="improvements" rows="4" class="form-input form-textarea" required></textarea>
            </div>

            <p class="error-message" id="error-message"></p>

            <button type="button" class="form-button" onclick="validateAndSubmit()">Submit Feedback</button>
        </form>

        <script>
        
        function setRating(event) {
            // Get the selected star value
            var ratingValue = parseInt(event.target.getAttribute('data-value'));
            
            // Update the hidden input field value
            document.getElementById('rating').value = ratingValue;

            // Remove selected class from all stars
            var stars = document.querySelectorAll('.rating-stars');
            stars.forEach(star => {
                star.classList.remove('selected');
            });

            // Add selected class to the clicked star and all stars before it
            event.target.classList.add('selected');
            var prevStars = event.target.previousElementSibling;
            while (prevStars) {
                prevStars.classList.add('selected');
                prevStars = prevStars.previousElementSibling;
            }
        }
    
            function validateAndSubmit() {
                var name = document.getElementById("name").value;
                var email = document.getElementById("email").value;
                var rating = document.getElementById("rating").value;
                var easeOfUse = document.getElementById("easeOfUse").value;
                var design = document.getElementById("design").value;
                var improvements = document.getElementById("improvements").value;
                var errorMessage = document.getElementById("error-message");

                // Simple client-side validations
                if (name.trim() === '' || email.trim() === '' || rating.trim() === '' || easeOfUse.trim() === '' ||
                    design.trim() === '' || improvements.trim() === '') {
                    errorMessage.innerText = "All fields are required.";
                    return;
                }

                if (isNaN(rating) || rating < 1 || rating > 5 || isNaN(easeOfUse) || easeOfUse < 1 || easeOfUse > 10) {
                    errorMessage.innerText = "Rating and Ease of Use must be numbers between specified ranges.";
                    return;
                }

                // If all validations pass, submit the form
                document.getElementById("feedbackForm").submit();
            }
        </script>
    </body>

    </html>
