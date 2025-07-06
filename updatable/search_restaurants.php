<?php
include("connection/connect.php");
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["query"])) {
	$searchQuery = mysqli_real_escape_string($db, $_POST["query"]);

	// Fetch restaurants based on the search query
	$sql = "SELECT * FROM restaurant WHERE title LIKE '%$searchQuery%'";
	$result = mysqli_query($db, $sql);

	// Perform nearby search (example: searching by address)
	$nearbySearchQuery = "SELECT * FROM restaurant WHERE address LIKE '%$searchQuery%'
     OR title LIKE '%" . implode("%' OR title LIKE '%", explode(' ', $searchQuery)) . "%'";
	;
	$nearbySearchResult = mysqli_query($db, $nearbySearchQuery);

	$restaurants = $_SESSION['distances'];
	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_array($result)) {
			// Display each restaurant as per your existing structure
			echo ' <div class="col-sm-12 col-md-12 col-lg-8 text-xs-center text-sm-left">
															<div class="entry-logo">
																<a class="img-fluid" href="dishes.php?res_id=' . $row['rs_id'] . '" > <img src="admin/Res_img/' . $row['image'] . '" alt="Food logo"></a>
															</div>
															<!-- end:Logo -->
															<div class="entry-dscr">
																<h5><a href="dishes.php?res_id=' . $row['rs_id'] . '" >' . $row['title'] . '</a></h5> <span>' . $row['address'] . ' <a href="#">...</a></span>
																<ul class="list-inline">
																	<li class="list-inline-item"><i class="fa fa-check"></i> Min $ 10,00</li>
																	<li class="list-inline-item"><i class="fa fa-motorcycle"></i> 30 min</li>';
			foreach ($restaurants as $res) {
				if ($res['rs_id'] == $row['rs_id']) {
					echo '<li class="list-inline-item"><i class="fa fa-road"></i> Distance ' . $res['distance'] . '</li>';
					break; // Break out of the loop once the distance is found
				}
			}
			echo '
																</ul>
															</div>
															<!-- end:Entry description -->
														</div>
														
														 <div class="col-sm-12 col-md-12 col-lg-4 text-xs-center">
																<div class="right-content bg-white">
																	<div class="right-review">
																		<div class="rating-block"> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star-o"></i> </div>';
																		if ($res["distance"] <= 10) {
																			echo "<span style='color:green;margin-right:10px'>Available</span>";
																		} else {
																			echo "<span style='color:Red;'>Currently Unavailable</span>";
																		}
																		echo '<a href="dishes.php?res_id=' . $row['rs_id'] . '" class="btn theme-btn-dash">View Menu</a> </div>
																</div>
																<!-- end:right info -->
															</div>';
		}
	} else if (mysqli_num_rows($nearbySearchResult) > 0) {
		echo '<h4>Nearby Search Results:</h4>';
		while ($row = mysqli_fetch_array($nearbySearchResult)) {
			// Display each restaurant as per your existing structure
			echo ' <div class="col-sm-12 col-md-12 col-lg-8 text-xs-center text-sm-left">
															<div class="entry-logo">
																<a class="img-fluid" href="dishes.php?res_id=' . $row['rs_id'] . '" > <img src="admin/Res_img/' . $row['image'] . '" alt="Food logo"></a>
															</div>
															<!-- end:Logo -->
															<div class="entry-dscr">
																<h5><a href="dishes.php?res_id=' . $row['rs_id'] . '" >' . $row['title'] . '</a></h5> <span>' . $row['address'] . ' <a href="#">...</a></span>
																<ul class="list-inline">
																	<li class="list-inline-item"><i class="fa fa-check"></i> Min $ 10,00</li>
																	<li class="list-inline-item"><i class="fa fa-motorcycle"></i> 30 min</li>';
			foreach ($restaurants as $res) {
				if ($res['rs_id'] == $row['rs_id']) {
					echo '<li class="list-inline-item"><i class="fa fa-road"></i> Distance ' . $res['distance'] . '</li>';
					break;
				}
			}
			echo '</ul>																
															</div>
															<!-- end:Entry description -->
														</div>
														
														 <div class="col-sm-12 col-md-12 col-lg-4 text-xs-center">
																<div class="right-content bg-white">
																	<div class="right-review">
																		<div class="rating-block"> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star-o"></i> </div>';
			if ($res["distance"] <= 10) {
				echo "<span style='color:green;margin-right:10px'>Available</span>";
			} else {
				echo "<span style='color:Red;'>Currently Unavailable</span>";
			}
			echo '<a href="dishes.php?res_id=' . $row['rs_id'] . '" class="btn theme-btn-dash">View Menu</a> </div>
																</div>
																<!-- end:right info -->
															</div>';
		}
	} else {
		echo '<p>No matching restaurants found.</p>';
	}
} else {
	echo 'Invalid request.';
}
?>