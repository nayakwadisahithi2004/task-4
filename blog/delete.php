<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    echo "Access denied.";
    exit;
}
include("config.php");

$id = $_GET['id'];
$stmt = $conn->prepare("DELETE FROM posts WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: index.php");
?>
