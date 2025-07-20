<?php
// MySQL database connection settings
$host = "localhost";       // Hostname (usually localhost)
$user = "root";            // MySQL username (default is 'root' for XAMPP/WAMP)
$password = "";            // Password (keep empty if using XAMPP/WAMP default)
$dbname = "blog";          // Your database name

// Create connection
$conn = mysqli_connect($host, $user, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
