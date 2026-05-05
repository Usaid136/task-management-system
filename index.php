<?php
include "includes/auth_init.php"; // Include Auth Init File

include "layout/header.php"; // Include Header File


$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];


// Count Tasks
$countStmt = mysqli_prepare($conn, "SELECT COUNT(*) AS total_tasks FROM tasks WHERE user_id = ?");
mysqli_stmt_bind_param($countStmt, "i", $user_id);
mysqli_stmt_execute($countStmt);
$countResult = mysqli_stmt_get_result($countStmt);
$totalTasks = mysqli_fetch_assoc($countResult)['total_tasks'];

// Count Completed Tasks
$completedTasks = tasksByStatus($conn, $user_id, 'completed');

// Count In Progress Tasks
$inProgressTasks = tasksByStatus($conn, $user_id, 'in_progress');

// Count Pending Tasks
$pendingTasks = tasksByStatus($conn, $user_id, 'pending');

// Completion Rate
if ($totalTasks > 0) {
    $completionRate = round(($completedTasks / $totalTasks) * 100);
} else {
    $completionRate = 0;
}

// Count Overdue
$countStmt2 = mysqli_prepare($conn, "SELECT COUNT(*) AS overdue_tasks 
    FROM tasks WHERE user_id = ?
    AND due_date < CURDATE()
    AND status != 'completed'");
mysqli_stmt_bind_param($countStmt2, "i", $user_id);
mysqli_stmt_execute($countStmt2);
$countResult2 = mysqli_stmt_get_result($countStmt2);
$overdueTasks = mysqli_fetch_assoc($countResult2)['overdue_tasks'];



// Task By Priority
$countStmt3 = mysqli_prepare($conn, "SELECT priority, COUNT(*) AS total 
FROM tasks 
WHERE user_id = ? 
GROUP BY priority");
mysqli_stmt_bind_param($countStmt3, "i", $user_id);
mysqli_stmt_execute($countStmt3);
$countResult3 = mysqli_stmt_get_result($countStmt3);

$priorityMap = [
    'high' => 0,
    'medium' => 0,
    'low' => 0
];

while ($row = mysqli_fetch_assoc($countResult3)) {
    $priorityMap[$row['priority']] = $row['total'];
}

$labels = ['High', 'Medium', 'Low'];
$data = array_values($priorityMap);

// Tasks By Status
$stmt4 = mysqli_prepare($conn, "SELECT status, COUNT(*) AS total
FROM tasks
GROUP BY status");
mysqli_stmt_execute($stmt4);
$result4 = mysqli_stmt_get_result($stmt4);

$statusMap = [
    'pending' => 0,
    'in_progress' => 0,
    'completed' => 0
];

while ($row = mysqli_fetch_assoc($result4)) {
    $statusMap[$row['status']] = $row['total'];
}

$labels2 = ['Pending', 'In Progress', 'Completed'];
$data2 = array_values($statusMap);

?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="fw-bold">Dashboard</h1>
        <span><i class="fa-solid fa-user"></i> <?= $username; ?></span>
    </div>

    <p class="text-muted">Welcome back, <?= $username; ?></p>
    <div class="row g-4">

        <!-- Total Tasks -->
        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm border-primary border-start border-3 border-end-0 border-top-0 border-bottom-0">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3">
                        <i class="fa-solid fa-list-check fa-2x text-primary"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Total Tasks</h6>
                        <h3 class="mb-0 fw-bold"><?= $totalTasks; ?></h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Completed -->
        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm border-success border-start border-3 border-end-0 border-top-0 border-bottom-0">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3">
                        <i class="fa-solid fa-circle-check fa-2x text-success"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Completed</h6>
                        <h3 class="mb-0 fw-bold"><?= $completedTasks; ?></h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- In Progress -->
        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm border-info border-start border-3 border-end-0 border-top-0 border-bottom-0">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3">
                        <i class="fa-solid fa-bars-progress fa-2x text-info"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">In Progress</h6>
                        <h3 class="mb-0 fw-bold"><?= $inProgressTasks; ?></h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending -->
        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm border-warning border-start border-3 border-end-0 border-top-0 border-bottom-0">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3">
                        <i class="fa-solid fa-clock fa-2x text-warning"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Pending</h6>
                        <h3 class="mb-0 fw-bold"><?= $pendingTasks; ?></h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Overdue -->
        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm border-danger border-start border-3 border-end-0 border-top-0 border-bottom-0">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3">
                        <i class="fa-solid fa-triangle-exclamation fa-2x text-danger"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Overdue</h6>
                        <h3 class="mb-0 fw-bold"><?= $overdueTasks; ?></h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Completion Rate -->
        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm border-primary border-start border-3 border-end-0 border-top-0 border-bottom-0">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3">
                        <i class="fa-solid fa-chart-line fa-2x text-primary"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Completion Rate</h6>
                        <h3 class="mb-0 fw-bold"><?= $completionRate; ?>%</h3>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row g-4">
        <div class="col-12 mb-3 col-md-6">
            <div class="card shadow-sm border-0 mt-4">
                <h3 class="mt-4 ms-2">Tasks By Priority</h3>
                <div class="card-body" style="height: 450px;">
                    <canvas id="priorityChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-12 mb-3 col-md-6">
            <div class="card shadow-sm border-0 mt-4">
                <h3 class="mt-4 ms-1">Tasks By Status</h3>
                <div class="card-body" style="height: 450px;">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let labels = <?= json_encode($labels); ?>;
    let data = <?= json_encode($data); ?>;

    let labels2 = <?= json_encode($labels2); ?>;
    let data2 = <?= json_encode($data2); ?>;


    // Tasks By Priority
        new Chart(document.getElementById('priorityChart'), {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Tasks by Priority',
                    data: data,
                    backgroundColor: ['red', 'orange', 'green']
                }]
            }
        });


        // Tasks By Status
        new Chart(document.getElementById('statusChart'), {
            type: 'bar',
            data: {
                labels: labels2,
                datasets: [{
                    label: 'Tasks By Status',
                    data: data2,
                    backgroundColor: 'lightgreen'
                }]
            }
        });

</script>

<?php include "layout/footer.php"; // Include Footer 
?>