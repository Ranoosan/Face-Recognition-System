<?php 
include '../includes/dbcon.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="admin/img/logo/attnlg.png" rel="icon">
    <title>Login Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="css/style.css"> <!-- Link to your CSS file -->
</head>
<body>
    
    <div id="messageDiv" class="messageDiv" style="display:none;"></div>
    <div class="container">
        <div class="left-section">
            <div class="welcome-text">
                <h1>Welcome to <br><span>ICBT Campus</span></h1>
                <!-- <p>ICBT Lecturer  Attandance.</p> -->
            </div>
        </div>
        <div class="right-section">
            <div class="login-form">
                <h2>Login to Your Page</h2>
                <form id="loginForm" action="" method="POST">
                    <div class="input-field">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="input-field">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <div class="input-field">
                        <label for="UserType">User Type</label>
                        <select required name="userType">
                        <option value="">--Select User Roles--</option>
                        <option value="Administrator">Administrator</option>
                        <option value="Lecture">Staff</option>
                        </select>
                    </div>
                    <div class="actions">
                        <input type="submit" class="login-btn" value="Login" name="login" />
                        <a href="#" class="forgot-password">Forgot Password?</a>
                    </div>
                </form>
            </div>
        </div>
    

      <script>
          function showMessage(message) {
          var messageDiv = document.getElementById('messageDiv');
          messageDiv.style.display="block";
          messageDiv.innerHTML = message;
          messageDiv.style.opacity = 1;
          setTimeout(function() {
            messageDiv.style.opacity = 0;
          }, 5000);
        }
   </script> 
<?php
  if(isset($_POST['login'])){

    $userType = $_POST['userType'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password = md5($password);

if($userType == "Administrator"){
    
    
      $query = "SELECT * FROM tbladmin WHERE emailAddress = '$email' and password='$password'  ";
      $rs = $conn->query($query);
      $num = $rs->num_rows;
      $rows = $rs->fetch_assoc();

      if($num > 0){

        $_SESSION['userId'] = $rows['Id'];
        $_SESSION['firstName'] = $rows['firstName'];
        $_SESSION['emailAddress'] = $rows['emailAddress'];

        echo "<script type = \"text/javascript\">
        window.location = (\"Admin/admin_dashboard.php\")
        </script>";
      }
      else{
        $message = " Invalid Username/Password!";
        echo "<script>showMessage('" . $message . "');</script>";
      }
    }
    else if($userType == "Lecture"){
      $query = "SELECT * FROM tbllecture WHERE emailAddress = '$email' and password='$password'  ";      
      $rs = $conn->query($query);
      $num = $rs->num_rows;
      $rows = $rs->fetch_assoc();


        if($num > 0){

        $_SESSION['userId'] = $rows['Id'];
        $_SESSION['firstName'] = $rows['firstName'];
        $_SESSION['emailAddress'] = $rows['emailAddress'];

        echo "<script type = \"text/javascript\">
        window.location = (\"lecture/Lecture_Deshboard.php\")
        </script>"; 
      }
      else{
        $message = " Invalid Username/Password!";
        echo "<script>showMessage('" . $message . "');</script>";
      }




    }
    else{
    }
}
?>                                 
</body>
</html>
</body>
</html>
