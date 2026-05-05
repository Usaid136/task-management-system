<?php

include "../includes/auth_init.php"; // Include Auth Init File

// Get User ID
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    redirect('tasks.php');
}

// Validate ID
if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
    setFlash("error", "Invalid task ID.");
    redirect('tasks.php');
}

$id = (int) $_POST['id'];

// Delete task query
$stmt = mysqli_prepare($conn, "DELETE FROM tasks WHERE id = ? AND user_id = ?");
mysqli_stmt_bind_param($stmt, "ii", $id, $user_id);
mysqli_stmt_execute($stmt);

if (mysqli_stmt_affected_rows($stmt) > 0) {
    setFlash("success", "Task deleted successfully.");
} else {
    setFlash("error", "Task not found or already deleted.");
}
redirect("tasks.php");
