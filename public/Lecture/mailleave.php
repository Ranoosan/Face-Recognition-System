<?php 
include 'Includes/dbcon.php';
include 'Includes/session.php';


if (isset($_POST["addVenue"])) {
    $Reason = $_POST["Reason"];
    $lecture_id = $_SESSION['userId'];
    $dateRegistered = date("Y-m-d");

    $query=mysqli_query($conn,"SELECT * FROM leave_requests WHERE lecture_id='$lecture_id' AND DATE(request_date) = CURDATE()");
    $ret=mysqli_fetch_array($query);
        if($ret > 0){ 
            $message = " You have already applied for leave today...";
    }
    else{
            $query=mysqli_query($conn,"insert into leave_requests(lecture_id, purpose) 
        value('$lecture_id','$Reason')");
        $message = " Your leave Inserted Successfully";

    }
   
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="img/logo/attnlg.png" rel="icon">
  <title>Dashboard</title>
  <link rel="stylesheet" href="css/styles.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.css" rel="stylesheet">
</head>
<body>
<?php include 'includes/topbar.php'?>
<section class="main">
<?php include 'includes/sidebar.php';?>
 <div class="main--content">

 <div id="overlay"></div>

 <div class="rooms">
                <br>
                
            </div>
            <div id="messageDiv" class="messageDiv" style="display:none;"></div>

            <div class="table-container">
            <div class="title" id="addClass2">
                    <h2 class="section--title">Leave Mail</h2>
                    <button class="add"><i class="ri-add-line"></i>Ask Leave</button>
                </div>
        
                <div class="table">
                    <table>
                         <thead>
                    <tr>
                        <th>Leave ID</th>
                        <th>Lecture ID</th>
                        <th>Leave Date</th>
                        <th>Reason</th>
                        <th>Status</th>
                    </tr>
                </thead>
                        <tbody>
                        <?php
                    // SQL query to fetch leave requests for the current lecturer
                    $userId = $conn->real_escape_string($_SESSION['userId']);

                    $sql = "SELECT lr.id AS LeaveID, lr.lecture_id AS LectureID, lr.request_date AS LeaveDate, lr.purpose AS Reason, lr.status AS Status 
                            FROM leave_requests lr 
                            JOIN tbllecture l ON lr.lecture_id = l.id 
                            WHERE l.id = '$userId'"; // Added quotes around $userId

                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // Output data for each row
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row["LeaveID"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["LectureID"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["LeaveDate"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["Reason"]) . "</td>";
                            echo "<td>" . ucfirst(htmlspecialchars($row["Status"])) . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No leave requests found</td></tr>";
                    }
                    ?>
                        </tbody>
                    </table>
                </div>
                
            </div>
                
<div class="formDiv-venue" id="addClassForm" style="display:none;">
        <form method="POST" action="" name="addVenue" enctype="multipart/form-data">
            <div style="display:flex; justify-content:space-around;">
                <div class="form-title">
                    <p>Asking Leave</p>
                </div>
                <div>
                    <span class="close">&times;</span>
                </div>
            </div>
            <input name="Reason" placeholder="Reason..." required></input>
            <input type="submit" class="submit" value="Save Venue" name="addVenue">
        </form>       
    </div>


</section>
<script src="javascript/main.js"></script>
<script src="./javascript/confirmation.js"></script>
<?php if(isset($message)){
    echo "<script>showMessage('" . $message . "');</script>";
} 
?>
<script>
   
const addClass2 = document.getElementById('addClass2');
const addClassForm = document.getElementById('addClassForm');
const overlay = document.getElementById('overlay'); // Add this line to select the overlay element



addClass2.addEventListener('click', function () {
    addClassForm.style.display = 'block';
    overlay.style.display = 'block';
    document.body.style.overflow = 'hidden'; 

});

var closeButtons = document.querySelectorAll('#addClassForm .close');

closeButtons.forEach(function (closeButton) {
    closeButton.addEventListener('click', function () {
        addClassForm.style.display = 'none';
        overlay.style.display = 'none';
        document.body.style.overflow = 'auto'; 

    });
});

</script>
</body>
</html>