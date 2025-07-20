<?php
session_start();
include 'config.php';

// Search functionality
$search = $_GET['search'] ?? '';
$sql = "SELECT * FROM posts";
if (!empty($search)) {
    $sql .= " WHERE title LIKE ?";
    $stmt = $conn->prepare($sql);
    $likeSearch = "%$search%";
    $stmt->bind_param("s", $likeSearch);
} else {
    $stmt = $conn->prepare($sql);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Blog - Task 3</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h2>
        Welcome, 
        <?= isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Guest'; ?>
        (
        <?= isset($_SESSION['role']) ? htmlspecialchars($_SESSION['role']) : 'none'; ?>
        )
    </h2>

    <!-- Add Post button for admins -->
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
        <a href="create.php" class="btn btn-success mb-3">+ Add New Post</a>
    <?php endif; ?>

    <!-- Search Form -->
    <form method="get" class="input-group mb-3" style="max-width: 400px;">
        <input type="text" name="search" class="form-control" placeholder="Search..." value="<?= htmlspecialchars($search); ?>">
        <button class="btn btn-primary" type="submit">Search</button>
    </form>

    <!-- Posts List -->
    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($row['title']); ?></h5>
                <p class="card-text"><?= nl2br(htmlspecialchars($row['content'])); ?></p>
                <small class="text-muted"><?= $row['created_at']; ?></small>

                <!-- Edit/Delete buttons for admins -->
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <div class="mt-2">
                        <a href="edit.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="delete.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this post?')">Delete</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endwhile; ?>
</div>
</body>
</html>
