<?php
include "../includes/auth_init.php"; // Include Auth Init File

$user_id = $_SESSION['user_id']; // User ID

/** @var mysqli $conn */

if (!isset($_GET['id'])) {
    redirect('../index.php');
}
$id = $_GET['id'];

// Fetching Old data
$stmt = mysqli_prepare($conn, "SELECT * FROM tasks WHERE id = ? AND user_id = ?");
mysqli_stmt_bind_param($stmt, "ii", $id, $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$task = mysqli_fetch_assoc($result);

include "../layout/header.php"; // Include Header File
?>
<!-- Edit Task Form -->
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col col-md-6">
            <div class="card p-4 mb-5">
                <h1 class="text-center">Edit Task</h1>
                <form method="post" action="update_task_process.php">
                    <input type="hidden" class="form-control" value="<?= $task['id']; ?>" name="id" value="<?= $id; ?>">
                    <div class="mb-3">
                        <label for="title" class="col-sm-2 col-form-label">Task Title</label>
                        <input type="text" class="form-control" value="<?= $task['title']; ?>" name="title" placeholder="Enter your task title" id="username">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Task Description</label>
                        <textarea class="form-control" name="description" id="exampleFormControlTextarea1" placeholder="Enter task description (optional)" rows="3"><?= $task['description']; ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="col-sm-2 col-form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="pending" <?= $task['status'] == "pending" ? 'selected' : ''; ?>>Pending</option>
                            <option value="in_progress" <?= $task['status'] == "in_progress" ? 'selected' : ''; ?>>In Progress</option>
                            <option value="completed" <?= $task['status'] == 'completed' ? 'selected' : ''; ?>>Completed</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="priority" class="col-sm-2 col-form-label">Priority</label>
                        <select name="priority" class="form-select">
                            <option value="low" <?= $task['priority'] == "low" ? 'selected' : ''; ?>>Low</option>
                            <option value="medium" <?= $task['priority'] == "medium" ? 'selected' : ''; ?>>Medium</option>
                            <option value="high" <?= $task['priority'] == "high" ? 'selected' : ''; ?>>High</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="due_date" class="col-sm-2 col-form-label">Due Date</label>
                        <input type="date" value="<?= $task['due_date']; ?>" class="form-control" name="due_date">

                    </div>
                    <button type="submit" class="btn btn-primary w-100"><i class="fa fa-save"></i> Update Task</button>
                    <a href="tasks.php" class="btn btn-outline-primary w-100 mt-2">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include "../layout/footer.php"; // Include Footer File 
?>