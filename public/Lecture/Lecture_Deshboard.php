
<?php 
include 'includes/dbcon.php';
include 'includes/session.php';
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
<?php include 'includes/topbar.php';?>
    <section class="main">
        <?php include 'includes/sidebar.php';?>
    <div class="main--content">
        <div class="overview">
                <br><div class="cards">
                    
                    
                   
                   
                    
                </div>
            </div>
           

            <div class="table-container">
            <a href="createCourse.php" style="text-decoration:none;"><div class="title">
                    <h2 class="section--title">Attendence</h2>
                    >
                </div>
            </a>
                <div class="table">
                    <table>
                        <thead>
                            <tr>
                                                            
                                <th>Lecture Id</th>
                                
                                <th>Email Address</th>
                                <th>Attendance</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $userId = $conn->real_escape_string($_SESSION['userId']);

                        $sql = "SELECT t.`id` AS `Lecture Id`, t.`emailAddress` AS `Email`, a.`entry_time` AS `Attendance` FROM `attendance` a JOIN `tbllecture` t ON a.`LID` = t.`id` WHERE t.`id` = $userId AND DATE(a.`entry_time`) = CURDATE();";
                        
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["Lecture Id"] . "</td>";
                            echo "<td>" . $row["Email"] . "</td>";
                            echo "<td>" . $row["Attendance"] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No records found</td></tr>";
                    }

                    ?>  
                        </tbody>
                    </table>
                </div>
                
            </div> 











        </div>
    </section>
    <script src="javascript/main.js"></script>
      <?php include 'includes/footer.php';?>
     
 

</body>

</html>`