<?php 
include 'includes/dbcon.php';
include 'includes/session.php';
?>
<?php 

error_reporting(0);
include '../includes/dbcon.php';
include '../includes/session.php';
function getFacultyNames($conn) {
    $sql = "SELECT facultyCode, facultyName FROM tblfaculty";
    $result = $conn->query($sql);

    $facultyNames = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $facultyNames[] = $row;
        }
    }

    return $facultyNames;
}


if (isset($_POST["addLecture"])) {
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $email = $_POST["email"];
    $phoneNumber= $_POST["phoneNumber"];
    $faculty = $_POST["faculty"];
    $dateRegistered = date("Y-m-d");
    $password="password";
    $password = md5($password);

    $photo = $_FILES['photo']['name'];
    $target_dir = "../Lecture/updates/";
    $target_file = $target_dir . basename($photo);

    $query=mysqli_query($conn,"select * from tbllecture where emailAddress='$email'");
    $ret=mysqli_fetch_array($query);
        if($ret > 0){ 
            $message = " Lecture Already Exists";
        }
    else{

             if (move_uploaded_file($_FILES['photo']['tmp_name'], $target_file))
             {

                $query=mysqli_query($conn,"insert into tbllecture(firstName,lastName,emailAddress,password,phoneNo,facultyCode,dateCreated,photo) 
                        value('$firstName','$lastName','$email','$password','$phoneNumber','$faculty','$dateRegistered', '$target_file')");
                        $message = " Lecture Added Successfully";
             }
             else {
                    echo "Error uploading photo.";
                }

        } 

            

    }
   

?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="img/logo/attnlg.png" rel="icon">

   <title>AdminDashboard</title>
   <link rel="stylesheet" href="css/styles.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.css" rel="stylesheet">
  <script src="./javascript/addStudent.js"></script>   
 <script src="./javascript/addStudent.js"></script>
 <script src="https://unpkg.com/face-api.js"></script>
</head>
<body>
<?php include "Includes/topbar.php";?>

  <section class=main>
      
      <?php include "Includes/sidebar.php";?>
       
   <div class="main--content"> 
   <div id="overlay"></div>
   <div id="messageDiv" class="messageDiv" style="display:none;"></div>

   <div class="table-containerx">
            <a href="#add-form" style="text-decoration:none;"> <div class="title" id="addLecture">
                    <h2 class="section--title">View Attendance today</h2>
                </div>
            </a>
                <div class="table">
                    <table>
                        <thead>
                            <tr>
                                <th>Full Name</th>
                                <th>Last Name</th>
                                <th>Entry_Time</th>
                                 
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                        <?php
                        $sql = "SELECT 
    tbllecture.firstName,
    tbllecture.lastName,
    attendance.entry_time
FROM 
    tbllecture
JOIN 
    face_data ON face_data.name = tbllecture.Id
JOIN 
    attendance ON tbllecture.Id = attendance.LID";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["firstName"] . "</td>";
                            echo "<td>" . $row["lastName"] . "</td>";
                            echo "<td>" . $row["entry_time"] . "</td>";       
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
<div id="addLectureForm"  style="display:none; ">
    <form method="POST" action="" name="addLecture" enctype="multipart/form-data">
        <div style="display:flex; justify-content:space-around;">
            <div class="form-title">
            <p>Add Lecture</p>
            </div>
        <div>
            <span class="close">&times;</span>
        </div>
        </div>
        <input type="text" name="firstName" placeholder="First Name" required>
        <input type="text" name="lastName" placeholder="Last Name" required>
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="text" name="phoneNumber" placeholder="Phone Number" required>
        <input type="password" name="password" placeholder="**********" required>
        <input type="file" name="photo" required>



        <select required name="faculty">
        <option value="" selected>Select Faculty</option>
        <?php
        $facultyNames = getFacultyNames($conn);
        foreach ($facultyNames as $faculty) {
            echo '<option value="' . $faculty["facultyCode"] . '">' . $faculty["facultyName"] . '</option>';
        }
        ?>
    </select>
        <input type="submit" class="submit" value="Save Lecture" name="addLecture">
    </form>       
</div>
      
                   
                  
 </section>

 <script src="javascript/main.js"></script>
<script src="javascript/addLecture.js"></script>
<script src="./javascript/confirmation.js"></script>

<script>
    
</script>
<?php if(isset($message)){
    echo "<script>showMessage('" . $message . "');</script>";
} 
?>
</body>

</html>