
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: rgba(0, 0, 0, 0.5); /* Transparent background */
            padding: 10px 20px;
            color: white;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            transition: background-color 0.3s ease;
        }
        .navbar a:hover {
            background-color: #575757;
        }
        .navbar .logo {
            display: flex;
            align-items: center;
            font-size: 24px;
            font-weight: bold;
        }
        .navbar .logo img {
            height: 50px;
            margin-right: 10px;
        }
        .navbar .nav-links {
            display: flex;
        }
        .navbar .nav-links a {
            margin-left: 10px;
        }
        .navbar .nav-links .logout-btn {
            background-color: #f44336;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
            text-transform: uppercase;
            font-size: 14px;
            font-weight: bold;
            text-decoration: none;
            display: inline-block;
            padding: 10px 15px;
        }
        .navbar .nav-links .logout-btn:hover {
            background-color: #e53935;
            transform: scale(1.05);
        }
        header {
            ackground: url('images/giphy.gif') no-repeat center center/cover;
            height: 200px; /* Adjust the height as needed */
            color: white;
        }
    </style>
    <title>The Gallery Café</title>
</head>
<body>
    <header>
        <div class="navbar">
        <div class="logo">
              <?php if (isset($_SESSION['user_id'])): ?>
                     <a href="home.php">
                <img src="images/logo.png" alt="Gallery Café Logo">
                Gallery Café
            </a>   
                <?php else: ?>
                     <a href="index.php">
                <img src="images/logo.png" alt="Gallery Café Logo">
                Gallery Café
            </a>   
                <?php endif; ?>


           
        </div>
        
        <nav>
            <ul>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="home.php">Home</a></li>
                <?php else: ?>
                    <li><a href="index.php">Home</a></li>
                    
                <?php endif; ?>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="menu.php">Menu</a></li>
                <?php else: ?>
                    <li><a href="menu1.php">Menu</a></li>
                <?php endif; ?>
                
                <li><a href="reservation.php">Reservations</a></li>
                <li><a href="preorder.php">Pre-order</a></li>
                <li><a href="account.php">Account</a></li>
                <!-- <li><a href="contact.php">Contact</a></li> -->
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="register.php">Register</a></li>
                <?php endif; ?>
            </ul>
        </nav>
        <div class="user-info">
        <?php if (isset($_SESSION['username'])) {
            $username = $_SESSION['username'];
            echo "<p>User, <br>"; 
            echo htmlspecialchars($username); 
            echo "</p>";
            }?>
        
        
            
        </div>
    </div>
    </header>
    <main>