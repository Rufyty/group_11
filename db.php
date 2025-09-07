<?php
$host = "localhost";
$user = "phpuser";
$pass = "StrongPassword123!"; 
$dbname = "blog";


$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
