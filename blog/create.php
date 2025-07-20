<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    echo "Access denied.";
    exit;
}
include("config.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    if (empty($title) || empty($content)) {
        echo "Title and content are required.";
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO posts (title, content) VALUES (?, ?)");
    $stmt->bind_param("ss", $title, $content);
    $stmt->execute();

    header("Location: index.php");
}
?>

<form method="POST">
    <input type="text" name="title" required minlength="3" maxlength="255" class="form-control mb-2" placeholder="Title">
    <textarea name="content" required class="form-control mb-2" placeholder="Content"></textarea>
    <button class="btn btn-primary">Create</button>
</form>
