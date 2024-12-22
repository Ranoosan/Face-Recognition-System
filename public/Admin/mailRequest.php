<?php 
// Start the session and include necessary files
include 'includes/dbcon.php';
include 'includes/session.php';

// Enable error reporting for development
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Handle form submission to approve or reject leave requests
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['approve']) || isset($_POST['reject'])) {
        // Get the leave ID from the form
        $leaveId = $_POST['leaveId'];
        // Determine the status based on which button was clicked
        $status = isset($_POST['approve']) ? 'approved' : 'rejected';
        // Prepare the SQL statement to update the leave request status
        $sqlUpdate = "UPDATE leave_requests SET status=? WHERE id=?";
        
        if ($stmt = $conn->prepare($sqlUpdate)) {
            $stmt->bind_param("si", $status, $leaveId);
            if ($stmt->execute()) {
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            } else {
                echo "<script>alert('Error updating request: " . $stmt->error . "');</script>";
            }
            $stmt->close();
        } else {
            echo "<script>alert('Error preparing statement: " . $conn->error . "');</script>";
        }
    }
}

// Fetching data and displaying it in a table
$sql = "SELECT lr.id AS LeaveID, 
               l.id AS LectureID, 
               CONCAT(l.firstName, ' ', l.lastName) AS FullName, 
               l.emailAddress AS Email, 
               lr.purpose AS Purpose, 
               lr.status AS Status, 
               lr.request_date AS RequestDate
        FROM leave_requests lr 
        JOIN tbllecture l ON lr.lecture_id = l.id";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="img/logo/attnlg.png" rel="icon">
    <title>AMS - Dashboard</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.css" rel="stylesheet">
    <style>
        .add_Approved {
            background-color: green;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            margin-right: 10px;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }
        .add_Approved:hover {
            background-color: darkgreen;
        }
        .rejected {
            background-color: red;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }
        .rejected:hover {
            background-color: darkred;
        }
    </style>
</head>
<body>
<?php include "Includes/topbar.php";?>
<section class="main">
    <?php include "Includes/sidebar.php";?>
    <div class="main--content"> 
        <div id="overlay"></div>
        <div id="messageDiv" class="messageDiv" style="display:none;"></div>
        <div class="table-containerx">
            <a href="#add-form" style="text-decoration:none;"> 
                <div class="title" id="addLecture">
                    <h2 class="section--title">Leave Mails</h2>
                </div>
            </a>
            <div class="table">
                <table>
                    <thead>
                        <tr>
                            <th>Email Address</th>
                            <th>Lecture ID</th>
                            <th>Full Name</th>
                            <th>Reason</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row["Email"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["LectureID"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["FullName"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["Purpose"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["RequestDate"]) . "</td>";
                            echo "<td id='status_" . $row["LeaveID"] . "'>" . htmlspecialchars($row["Status"]) . "</td>";
                            echo "<td>
                                    <form method='POST' action=''>
                                        <input type='hidden' name='leaveId' value='" . htmlspecialchars($row["LeaveID"]) . "'>
                                        <button type='submit' name='approve' class='add_Approved'>Approve</button>
                                        <button type='submit' name='reject' class='rejected'>Reject</button>
                                    </form>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No records found</td></tr>";
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
</body>
</html>
