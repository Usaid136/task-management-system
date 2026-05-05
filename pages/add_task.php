<?php
include "../includes/auth_init.php"; // Include Auth Init File

include "../layout/header.php"; // Include Header File

?>


<!-- Add Task Form -->
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col col-md-6">
            <div class="card p-4 mb-5">
                <h1 class="text-center">Add Task</h1>
                <form method="post" action="add_task_process.php">
                    <div class="mb-3">
                        <label for="title" class="col-sm-2 col-form-label">Task Title</label>
                        <input type="text" class="form-control" name="title" placeholder="Enter your task title" id="username">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Task Description</label>
                        <textarea class="form-control" name="description" id="exampleFormControlTextarea1" placeholder="Enter task description (optional)" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="col-sm-2 col-form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="pending">Pending</option>
                            <option value="in_progress">In Progress</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="priority" class="col-sm-2 col-form-label">Priority</label>
                        <select name="priority" class="form-select">
                            <option value="low">Low</option>
                            <option value="medium">Medium</option>
                            <option value="high">High</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="due_date" class="col-sm-2 col-form-label">Due Date</label>
                        <input type="date" class="form-control" name="due_date">

                    </div>
                    <button type="submit" class="btn btn-primary w-100"><i class="fa fa-plus"></i>Add Task</button>
                    <a href="tasks.php" class="btn btn-outline-primary w-100 mt-2">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include "../layout/footer.php"; // Include Footer File 
?>