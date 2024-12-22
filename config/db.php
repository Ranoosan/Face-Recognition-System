

<?php
$servername = "localhost";
$username = "root";
$password = ""; // Default XAMPP MySQL password is empty
$dbname = "gallery_cafe";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>