<?php
include "../includes/auth_init.php"; // Include Auth Init File

// User Id
$user_id = $_SESSION['user_id'];

// Allowed Status
$allowed_status = ['pending', 'in_progress', 'completed', 'cancelled'];
// Allowed Priority
$allowed_priority = ['low', 'medium', 'high'];

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $id = $_POST['id'];
    $title = c($_POST['title']);
    $desc = c($_POST['description']);
    $status = $_POST['status'] ?? 'pending';
    $priority = $_POST['priority'] ?? 'medium';
    $due_date = $_POST['due_date'];


    // Input validation
    if (is_empty($title)) {
        setFlash("error", "Title is required.");
        redirect('update_task.php');
    }
    if (!in_array($status, $allowed_status)) {
        setFlash("error", "Invalid Status.");
        redirect('update_task.php');
    }
    if (!in_array($priority, $allowed_priority)) {
        setFlash("error", "Invalid Priority");
        redirect('update_task.php');
    }
    // Insert query
    $stmt = mysqli_prepare($conn, "UPDATE tasks SET title = ?, description = ? , status = ?, priority = ?, due_date = ? WHERE id = ? AND user_id = ?");
    mysqli_stmt_bind_param($stmt, "sssssii", $title, $desc, $status, $priority, $due_date, $id, $user_id);
    mysqli_stmt_execute($stmt);
    if (mysqli_stmt_affected_rows($stmt)) {
        setFlash("success", "Task Updated Successfully.");
        redirect('tasks.php');
    } else {
        setFlash("error", "Fail to update task.");
        redirect('update_task.php');
    }
    mysqli_stmt_close($stmt);
}

include "../layout/footer.php"; // Include Footer