<?php
// update_leave_status.php

// Include your database connection file
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the leave_id and new status from the AJAX request
    $leave_id = $conn->real_escape_string($_POST['leave_id']);
    $status = $conn->real_escape_string($_POST['status']);

    // Update the leave request status in the database
    $sql = "UPDATE leave_requests SET status = '$status' WHERE leave_id = $leave_id";

    if ($conn->query($sql) === TRUE) {
        echo 'Status updated successfully';
    } else {
        echo 'Error updating status: ' . $conn->error;
    }

    // Close the connection
    $conn->close();
}
?>
