<?php
include("../connection/connect.php");

$sql = "SELECT users.*, users_orders.* FROM users INNER JOIN users_orders ON users.u_id=users_orders.u_id WHERE users_orders.status = '' or users_orders.status is null";
$query = mysqli_query($db, $sql);

if (mysqli_num_rows($query) > 0) {
    while ($rows = mysqli_fetch_array($query)) {
        echo '<tr data-order-id="' . $rows['o_id'] . '">';
        echo '<td>' . $rows['username'] . '</td>';
        echo '<td>' . $rows['title'] . '</td>';
        echo '<td>' . $rows['quantity'] . '</td>';
        echo '<td>Rs ' . $rows['price'] . '</td>';
        echo '<td>' . $rows['address'] . '</td>';
        echo '<td class="status-cell">';
        echo '<button type="button" class="btn btn-info" style="font-weight:bold;">';
        echo '<span class="fa fa-bars" aria-hidden="true">Dispatch</button>';
        echo '</td>';
        echo '<td>' . $rows['date'] . '</td>';
        echo '<td>';
        echo '<a href="delete_orders.php?order_del=' . $rows['o_id'] . '" onclick="return confirm(\'Are you sure?\');" class="btn btn-danger btn-flat btn-addon btn-xs m-b-10">';
        echo '<i class="fa fa-trash-o" style="font-size:16px"></i></a>';
        echo '<a href="view_order.php?user_upd=' . $rows['o_id'] . '" class="btn btn-info btn-flat btn-addon btn-sm m-b-10 m-l-5">';
        echo '<i class="ti-settings"></i></a>';
        echo '</td>';
        echo '</tr>';
    }
} else {
    echo '<td colspan="8"><center>No Orders-Data!</center></td>';
}
?>
