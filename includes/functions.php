<?php
function get_menu_items($conn) {
    $sql = "SELECT * FROM menu_items";
    $result = $conn->query($sql);
    return $result;
}


function get_reservations($conn, $user_id) {
    $sql = "SELECT * FROM reservations WHERE user_id = $user_id";
    $result = $conn->query($sql);
    return $result;
}
?>