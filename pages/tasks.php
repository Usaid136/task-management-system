<?php
include "../includes/auth_init.php";

include "../layout/header.php";

/** @var mysqli $conn */

$user_id = $_SESSION['user_id'];


// Pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 5;
$offset = ($page - 1) * $limit;

// Search
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Filter By Status
$filter_status = isset($_GET['filter_status']) ? $_GET['filter_status'] : '';

// Filter By Priority
$filter_priority = isset($_GET['filter_priority']) ? $_GET['filter_priority'] : '';

// Sorting
$sort = isset($_GET['sort']) ? $_GET['sort'] : '';


$params = [];
$types = "";

// Query
$query = "SELECT * FROM tasks WHERE user_id = ?";
$params[] = $user_id;
$types .= "i";

// Search Query
if (!empty($search)) {
    $query .= " AND (title LIKE ? OR description LIKE ?)";
    $searchParam = "%$search%";
    $params[] = $searchParam;
    $params[] = $searchParam;
    $types .= "ss";
}

// Filter Status Query
if (!empty($filter_status)) {
    $query .= " AND status = ?";
    $params[] = $filter_status;
    $types .= "s";
}

// Filter Priority Query
if (!empty($filter_priority)) {
    $query .= " AND priority = ?";
    $params[] = $filter_priority;
    $types .= "s";
}

// Sorting
if ($sort == "oldest") {
    $query .= " ORDER BY id ASC";
} elseif ($sort == "az") {
    $query .= " ORDER BY title ASC";
} elseif ($sort == "za") {
    $query .= " ORDER BY title DESC";
} else {
    $query .= " ORDER BY id DESC";
}

// Query
$query .= " LIMIT ? OFFSET ?";
$params[] = $limit;
$params[] = $offset;
$types .= "ii";


// Fetch Tasks
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, $types, ...$params);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);



// Count Tasks

$countParams = [];
$countTypes = "";

// Count Query
$countQuery = "SELECT COUNT(*) AS total_tasks FROM tasks WHERE user_id = ?";
$countParams[] = $user_id;
$countTypes .= "i";

// Search Count Query
if (!empty($search)) {
    $countQuery .= " AND (title LIKE ? OR description LIKE ?)";
    $searchParam = "%$search%";
    $countParams[] = $searchParam;
    $countParams[] = $searchParam;
    $countTypes .= "ss";
}

// Filter Status Count Query
if (!empty($filter_status)) {
    $countQuery .= " AND status = ?";
    $countParams[] = $filter_status;
    $countTypes .= "s";
}

// Filter Priority Count Query
if (!empty($filter_priority)) {
    $countQuery .= " AND priority = ?";
    $countParams[] = $filter_priority;
    $countTypes .= "s";
}


$countStmt = mysqli_prepare($conn, $countQuery);
mysqli_stmt_bind_param($countStmt, $countTypes, ...$countParams);
mysqli_stmt_execute($countStmt);
$countResult = mysqli_stmt_get_result($countStmt);

$totalTasks = mysqli_fetch_assoc($countResult)['total_tasks'];
$totalPages = ceil($totalTasks / $limit);

?>

<div class="container mt-5">
    <div class="card">
        <div class="card-body">
            <!-- Header -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2 mb-3">
                <h1 class="mt-3 mb-0">Tasks List</h1>

                <a class="btn btn-outline-primary align-self-start align-item-md-auto"
                    href="add_task.php">
                    <i class="fa fa-plus"></i> Add Task
                </a>
            </div>
            <!-- Search & Filter -->
            <div class="container mb-3">
                <form class="row g-2 align-items-center justify-content-end" method="get">

                    <!-- Status -->
                    <div class="col-md-2">
                        <select name="filter_status" class="form-select">
                            <option value="">All Status</option>
                            <option value="pending" <?= $filter_status == "pending" ? 'selected' : ''; ?>>Pending</option>
                            <option value="in_progress" <?= $filter_status == "in_progress" ? 'selected' : ''; ?>>In Progress</option>
                            <option value="completed" <?= $filter_status == "completed" ? 'selected' : ''; ?>>Completed</option>
                        </select>
                    </div>

                    <!-- Priority -->
                    <div class="col-md-2">
                        <select name="filter_priority" class="form-select">
                            <option value="">All Priority</option>
                            <option value="low" <?= $filter_priority == "low" ? 'selected' : ''; ?>>Low</option>
                            <option value="medium" <?= $filter_priority == "medium" ? 'selected' : ''; ?>>Medium</option>
                            <option value="high" <?= $filter_priority == "high" ? 'selected' : ''; ?>>High</option>
                        </select>
                    </div>

                    <!-- Sorting -->
                    <div class="col-md-2">
                        <select name="sort" class="form-select">
                            <option value="">Sort By</option>
                            <option value="latest" <?= $sort == "latest" ? 'selected' : ''; ?>>Latest</option>
                            <option value="oldest" <?= $sort == "oldest" ? 'selected' : ''; ?>>Oldest</option>
                            <option value="az" <?= $sort == "az" ? 'selected' : ''; ?>>A to Z</option>
                            <option value="za" <?= $sort == "za" ? 'selected' : ''; ?>>Z to A</option>
                        </select>
                    </div>

                    <!-- Search -->
                    <div class="col-md-3">
                        <input class="form-control" name="search" type="search" value="<?= htmlspecialchars($search); ?>" placeholder="Search...">
                    </div>

                    <!-- Buttons -->
                    <div class="col-md-3 d-flex">
                        <button class="btn btn-primary me-2 w-50" type="submit">Apply</button>
                        <a href="?" class="btn btn-secondary w-50">Reset</a>
                    </div>

                </form>
            </div>
            <!-- Tasks List Table -->
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Task</th>
                            <th scope="col">Description</th>
                            <th scope="col">Status</th>
                            <th scope="col">Priority</th>
                            <th scope="col">Due Date</th>
                            <th scope="col">Created At</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Fetch data query -->
                        <?php
                        $serial = 1 + $offset;
                        while ($row = mysqli_fetch_assoc($result)) {
                            $status = $row['status'];
                            $priority = $row['priority'];
                        ?>
                            <th scope="row"><?= $serial++; ?></th>
                            <th><?= $row['title']; ?></th>
                            <td><?= !empty($row['description']) ? $row['description'] : 'No description'; ?></td>
                            <td><?php
                                if ($status == "pending") {
                                    echo '<span class="badge bg-warning"><i class="fa-solid fa-clock"></i> Pending</span>';
                                } elseif ($status == "in_progress") {
                                    echo '<span class="badge bg-primary"><i class="fa-solid fa-spinner"></i> In Progress</span>';
                                } else {
                                    echo '<span class="badge bg-success"><i class="fa-solid fa-circle-check"></i> Completed</span>';
                                }
                                ?></td>
                            <td><?php
                                if ($priority == "low") {
                                    echo '<span class="badge bg-success"><i class="fa-solid fa-leaf"></i> Low</span>';
                                } elseif ($priority == "medium") {
                                    echo '<span class="badge bg-warning"><i class="fa-solid fa-clock"></i> Medium</span>';
                                } else {
                                    echo '<span class="badge bg-danger"><i class="fa-solid fa-fire"></i> High</span>';
                                }
                                ?></td>
                            <td>
                                <?= (!empty($row['due_date']) && $row['due_date'] != '0000-00-00') ?
                                    date("d M Y", strtotime($row['due_date']))
                                    : 'No due date'; ?>
                            </td>
                            <td><?= date("d M Y, h:i A", strtotime($row['created_at'])); ?></td>
                            <td>
                                <a class="btn btn-warning btn-sm" href="update_task.php?id=<?= $row['id'] ?>">
                                    <i class="fa fa-pencil"></i></a>
                                <form action="delete_task.php" method="post">
                                    <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                    <button type="submit"
                                        onclick="return confirm('Are you sure to delete this task?');" class="btn mt-1 btn-sm btn-danger">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                            </tr>
                        <?php } ?>
                        <?php if (mysqli_num_rows($result) == 0): ?>
                            <tr>
                                <td colspan="9" class="text-center">No task found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-end">
                    <li class="page-item <?php if ($page <= 1) echo 'disabled'; ?>">
                        <a class="page-link" href="?page=<?= ($page - 1); ?>">Previous</a>
                    </li>
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?php if ($page == $i) echo 'active'; ?>"><a class="page-link" href="?page=<?= $i; ?>"><?= $i; ?></a></li>
                    <?php endfor; ?>
                    <li class="page-item <?php if ($page >= $totalPages) echo 'disabled'; ?>">
                        <a class="page-link" href="?page=<?= ($page + 1); ?>">Next</a>
                    </li>
                </ul>
            </nav>

        </div>
    </div>
</div>

<?php include "../layout/footer.php"; // Include Footer 
?>