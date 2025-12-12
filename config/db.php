<?php
$servername = "localhost";
$username = "root"; 
$password = "";     
$dbname = "coffeeshop_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối database thất bại: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");
?>