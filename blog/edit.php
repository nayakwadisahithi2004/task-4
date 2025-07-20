<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    echo "Access denied.";
    exit;
}
include("config.php");

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM posts WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    if (empty($title) || empty($content)) {
        echo "Title and content are required.";
        exit;
    }

    $update = $conn->prepare("UPDATE posts SET title=?, content=? WHERE id=?");
    $update->bind_param("ssi", $title, $content, $id);
    $update->execute();

    header("Location: index.php");
}
?>

<form method="POST">
    <input type="text" name="title" value="<?= htmlspecialchars($row['title']) ?>" required class="form-control mb-2">
    <textarea name="content" required class="form-control mb-2"><?= htmlspecialchars($row['content']) ?></textarea>
    <button class="btn btn-warning">Update</button>
</form>
