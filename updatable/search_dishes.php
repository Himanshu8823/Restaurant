<?php
include("connection/connect.php");

if (isset($_POST['query'])) {
    $query = $_POST['query'];
    $res_id = $_GET['res_id'];

    // Perform live search with related terms
    $liveSearchQuery = "SELECT * FROM dishes WHERE rs_id = ? AND title LIKE ? 
                        OR title LIKE '%" . implode("%' OR title LIKE '%", explode(' ', $query)) . "%'";
    $stmtLive = $db->prepare($liveSearchQuery);
    $stmtLive->bind_param("is", $res_id, $query);
    $stmtLive->execute();
    $resultLive = $stmtLive->get_result();

    // Display live search results
    echo '<h4>Live Search Results:</h4>';
    echo '<ul>';
    while ($row = $resultLive->fetch_assoc()) {
        echo '<li>' . $row['title'] . '</li>';
    }
    echo '</ul>';

    // Perform nearby search (example: searching by description)
    $nearbySearchQuery = "SELECT * FROM dishes WHERE rs_id = ? AND description LIKE ?";
    $stmtNearby = $db->prepare($nearbySearchQuery);
    $stmtNearby->bind_param("is", $res_id, $query);
    $stmtNearby->execute();
    $resultNearby = $stmtNearby->get_result();

    // Display nearby search results
    echo '<h4>Nearby Search Results:</h4>';
    echo '<ul>';
    while ($row = $resultNearby->fetch_assoc()) {
        echo '<li>' . $row['title'] . '</li>';
    }
    echo '</ul>';

    $stmtLive->close();
    $stmtNearby->close();
}
?>
