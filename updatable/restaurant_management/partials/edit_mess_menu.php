<?php
session_start();

// Redirect to login page if user is not logged in
if (!isset($_SESSION['manager'])&&!isset($_SESSION['username'])&&!isset($_SESSION['cashier'])) {
    header("Location: ../login.php");
    exit();
}

// Include database connection
include("../connection/connect.php");


// Fetch the menu item ID from the URL
$item_id = $_GET['id'];

// Fetch the menu item details from the database
$menu_item_query = "SELECT * FROM mess_menu_items WHERE item_id = $item_id";
$menu_item_result = mysqli_query($db, $menu_item_query);
$menu_item = mysqli_fetch_assoc($menu_item_result);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Retrieve data from the form
    $name = $_POST['name'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $availability = isset($_POST['availability']) ? 1 : 0; // Check if the item is available or not

    // Update the menu item in the database
    $update_query = "UPDATE mess_menu_items 
                     SET item_name = '$name', item_price = '$price', item_category = '$category', 
                         item_description = '$description', is_available = '$availability'
                     WHERE item_id = $item_id";

    if (mysqli_query($db, $update_query)) {
        // Redirect to the manage menu items page
        header("Location: manage_menu_items.php");
        exit();
    } else {
        // Error updating menu item
        $error_message = "Error updating menu item: " . mysqli_error($db);
    }
}

// Include header, menu, and sidebar files
include("hel.php");
include('header_menu.php');
include('header.php');
include('sidebar.php');
?>

<div class="wrapper">
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content-header">
            <h1>Edit Menu Item</h1>
        </section>
        <section class="content">
            <?php if (isset($error_message)) : ?>
                <div class="alert alert-danger"><?php echo $error_message; ?></div>
            <?php endif; ?>
            <form method="post" action="">
                <div class="form-group">
                    <label for="name">Item Name:</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $menu_item['item_name']; ?>">
                </div>
                <div class="form-group">
                    <label for="price">Price:</label>
                    <input type="number" class="form-control" id="price" name="price" value="<?php echo $menu_item['item_price']; ?>">
                </div>
                <div class="form-group">
                    <label for="category">Category:</label>
                    <input type="text" class="form-control" id="category" name="category" value="<?php echo $menu_item['item_category']; ?>">
                </div>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea class="form-control" id="description" name="description"><?php echo $menu_item['item_description']; ?></textarea>
                </div>
                <div class="form-group">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" id="availability" name="availability" <?php if ($menu_item['is_available']) echo "checked"; ?>>
                            Available
                        </label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary" name="submit">Update</button>
            </form>
        </section>
    </div>

    <!-- Include your footer -->
    <?php include("footer.php"); ?>
</div>
<!-- ./wrapper -->
