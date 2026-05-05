<?php
include "../includes/auth_init.php"; // Include Auth Init File


$user_id = $_SESSION['user_id'];

// Allowed Status
$allowed_status = ['pending', 'in_progress', 'completed', 'cancelled'];
// Allowed Priority
$allowed_priority = ['low', 'medium', 'high'];

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $title = c($_POST['title']);
    $desc = c($_POST['description']);
    $status = $_POST['status'] ?? 'pending';
    $priority = $_POST['priority'] ?? 'medium';
    $due_date = $_POST['due_date'];

    // Input validation
    if (is_empty($title)) {
        setFlash("error", "Title is required.");
        redirect('add_task.php');
    }
    if (!in_array($status, $allowed_status)) {
        setFlash("error", "Invalid Status.");
        redirect('add_task.php');
    }
    if (!in_array($priority, $allowed_priority)) {
        setFlash("error", "Invalid Priority");
        redirect('add_task.php');
    }

    // Insert task query
    $stmt = mysqli_prepare($conn, "INSERT INTO tasks (user_id, title, description, status, priority, due_date) VALUES (?,?,?,?,?,?)");
    mysqli_stmt_bind_param($stmt, "isssss", $user_id, $title, $desc, $status, $priority, $due_date);
    mysqli_stmt_execute($stmt);
    if (mysqli_stmt_affected_rows($stmt) == 1) {
        setFlash("success", "Task Added Successfully.");
        redirect('tasks.php');
    } else {
        setFlash("error", "Failed to add task.");
        redirect('add_task.php');
    }
    mysqli_stmt_close($stmt);
}
