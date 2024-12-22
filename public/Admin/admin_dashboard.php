
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
                    
                    <div class="card card-1">
                        <?php 
                        $query1=mysqli_query($conn,"SELECT * from tblcourse");                       
                        $ttl = mysqli_num_rows($query1);
                        ?>
                        <div class="card--data">
                            <div class="card--content">
                                <h5 class="card--title">Units</h5>
                                <h1><?php echo $ttl;?></h1>
                            </div>
                            <i class="ri-file-text-line card--icon--lg"></i>
                        </div>
                        
                    </div>

                    <div class="card card-1">
                        <?php 
                        $query1=mysqli_query($conn,"SELECT * from tbllecture");                       
                        $ttl = mysqli_num_rows($query1);
                        ?>
                        <div class="card--data">
                            <div class="card--content">
                                <h5 class="card--title">Lecture</h5>
                                <h1><?php echo $ttl;?></h1>
                            </div>
                            <i class="ri-user-line card--icon--lg"></i>
                        </div>
                        
                    </div>
                    <div class="card card-1">
                        <?php 
                        $query1=mysqli_query($conn,"SELECT * from tblfaculty");                       
                        $ttl = mysqli_num_rows($query1);
                        ?>
                        <div class="card--data">
                            <div class="card--content">
                                <h5 class="card--title">Faculty</h5>
                                <h1><?php echo $ttl;?></h1>
                            </div>
                            <i class="ri-file-text-line card--icon--lg"></i>
                        </div>
                        
                    </div>
                   
                   
                    
                </div>
            </div>
           

            <div class="table-container">
            <a href="createCourse.php" style="text-decoration:none;"><div class="title">
                    <h2 class="section--title">Courses</h2>
                    <button class="add"><i class="ri-add-line"></i>Add Course</button>
                </div>
            </a>
                <div class="table">
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                
                                <th>Total Units</th>
                                
                                <th>Date Created</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $sql = "SELECT 
                        c.name AS course_name,
                        c.facultyID AS faculty,
                        f.facultyName AS faculty_name,
                        COUNT(u.ID) AS total_units,
                        
                        c.dateCreated AS date_created
                        FROM tblcourse c
                        LEFT JOIN tblunit u ON c.ID = u.courseID
                        
                        LEFT JOIN tblfaculty f on c.facultyID=f.Id
                        GROUP BY c.ID";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["course_name"] . "</td>";
                            echo "<td>" . $row["total_units"] . "</td>";
                            echo "<td>" . $row["date_created"] . "</td>";
                            echo "<td><span>
            <button class='add edit'><i class='ri-edit-line'></i> Edit</button>
            <button class='add delete'><i class='ri-delete-bin-line'></i> Delete</button>
        </span></td>";
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




            <div class="table-container">
            <a href="createLecture.php" style="text-decoration:none;"> <div class="title">
                    <h2 class="section--title">Lectures</h2>
                    <button class="add"><i class="ri-add-line"></i>Add lecture</button>
                </div>
            </a>
                <div class="table">
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email Address</th>
                                <th>Phone No</th>
                                <th>Faculty</th>
                                <th>Date Registered</th>
                                <th>Settings</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                        <?php
                         $sql = "SELECT l.*, f.facultyName
                         FROM tbllecture l
                         LEFT JOIN tblfaculty f ON l.facultyCode = f.facultyCode";
                          $result = $conn->query($sql);
                          if ($result->num_rows > 0) {
                         while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["firstName"] . "</td>";
                            echo "<td>" . $row["emailAddress"] . "</td>";
                            echo "<td>" . $row["phoneNo"] . "</td>";
                            echo "<td>" . $row["facultyName"] . "</td>";
                            echo "<td>" . $row["dateCreated"] . "</td>";
                            echo "<td><span>
            <button class='add edit'><i class='ri-edit-line'></i> Edit</button>
            <button class='add delete'><i class='ri-delete-bin-line'></i> Delete</button>
        </span></td>";
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
            
            <div class="table-container">
            <a href="createVenue.php" style="text-decoration:none;"><div class="title">
                    <h2 class="section--title">Lecture Rooms</h2>
                    <button class="add"><i class="ri-add-line"></i>Add room</button>
                </div>
            </a>
                <div class="table">
                    <table>
                        <thead>
                            <tr>
                                <th>Class Name</th>
                                <th>Faculty</th>
                                <th>Current Status</th>
                                <th>Capacity</th>
                                <th>Classification</th>
                                <th>Settings</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $sql = "SELECT * FROM tblvenue";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["className"] . "</td>";
                            echo "<td>" . $row["facultyCode"] . "</td>";
                            echo "<td>" . $row["currentStatus"] . "</td>";
                            echo "<td>" . $row["capacity"] . "</td>";
                            echo "<td>" . $row["classification"] . "</td>";
                            echo "<td><span>
            <button class='add edit'><i class='ri-edit-line'></i> Edit</button>
            <button class='add delete'><i class='ri-delete-bin-line'></i> Delete</button>
        </span></td>";
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
    
     
 

</body>

</html>