<?php
// Get Current File Name
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Task Management System</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <?php if (!isset($_SESSION['logged_in'])): ?>
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link <?= ($currentPage == "signup.php") ? 'active' : ''; ?>" aria-current="page" href="<?= BASE_URL . "auth/signup.php"; ?>">Signup</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($currentPage == "login.php") ? 'active' : ''; ?>" href="<?= BASE_URL . "auth/login.php" ?>">Login</a>
                    </li>
                </ul>
            <?php else: ?>
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link <?= ($currentPage == "index.php") ? 'active' : ''; ?>" aria-current="page" href="<?= BASE_URL . "index.php"; ?>">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($currentPage == "tasks.php") ? 'active' : ''; ?>" href="<?= BASE_URL . "pages/tasks.php"; ?>">Tasks</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($currentPage == "add_task.php") ? 'active' : ''; ?>" href="<?= BASE_URL . "pages/add_task.php"; ?>">Add Tasks</a>
                    </li>
                </ul>
                <form class="d-flex">
                    <a onclick="return confirm('Are you sure to logout?')" class="btn btn-outline-danger" href="<?= BASE_URL . "auth/logout.php"; ?>">Logout</a>
                </form>
            <?php endif; ?>
        </div>
    </div>
</nav>


<!-- Navbar -->
<!-- <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">To-Do List</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="add_task.php">Add Task</a>
                    </li>
                </ul>
                <form class="d-flex">
                    <a onclick="return confirm('Are you sure to logout?')" class="btn btn-outline-danger" href="auth/logout.php">Logout</a>
                </form>
            </div>
        </div>
    </nav> -->