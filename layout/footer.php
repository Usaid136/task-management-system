<!-- Footer -->
<footer class="bg-dark text-white mt-5">
    <div class="container py-4">
        <div class="row">

            <!-- About -->
            <div class="col-md-4 mb-3">
                <h5 class="fw-bold">To-Do List App</h5>
                <p class="small mb-0">
                    A simple and efficient task management system built with PHP & MySQL.
                </p>
            </div>

            <?php if (empty($_SESSION['logged_in'])): ?>
                <!-- Guest Links -->
                <div class="col-md-4 mb-3">
                    <h5 class="fw-bold">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="<?= BASE_URL ?>auth/login.php"
                                class="text-white d-block mb-1">
                                Login
                            </a></li>
                        <li><a href="<?= BASE_URL ?>auth/signup.php"
                                class="text-white d-block mb-1">Signup
                            </a></li>
                    </ul>
                </div>
            <?php else: ?>
                <!-- LoggedIn Links -->
                <div class="col-md-4 mb-3">
                    <h5 class="fw-bold">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="<?= BASE_URL ?>index.php"
                                class="text-white d-block mb-1">
                                Dashboard
                            </a></li>
                        <li><a href="<?= BASE_URL ?>pages/tasks.php"
                                class="text-white d-block mb-1">Tasks
                            </a></li>
                        <li><a href="<?= BASE_URL ?>pages/add_task.php"
                                class="text-white d-block mb-1">Add Task
                            </a></li>
                    </ul>
                </div>
            <?php endif; ?>

            <!-- Contact -->
            <div class="col-md-4 mb-3">
                <h5 class="fw-bold">Contact</h5>
                <p class="small mb-2">
                    <i class="fa fa-envelope me-2"></i>
                    <a href="mailto:muhammadusaid136@gmail.com?subject=Project%20Inquiry"
                        class="text-white">
                        muhammadusaid136@gmail.com
                    </a>
                </p>
                <p class="small mb-0">
                    <i class="fa-brands fa-square-linkedin me-2"></i>
                    <a href="https://www.linkedin.com/in/m-usaid-saddiq-110500320/"
                        target="_blank" class="text-white">
                        M. Usaid Saddiq
                    </a>
                </p>
            </div>

        </div>
    </div>

    <!-- Bottom Bar -->
    <div class="bg-secondary text-center py-2">
        <small>&copy; <?= date('Y'); ?> To-Do List App | All Rights Reserved</small>
    </div>
</footer>


<!-- Fontawesome JS CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/js/all.min.js" integrity="sha512-6BTOlkauINO65nLhXhthZMtepgJSghyimIalb+crKRPhvhmsCdnIuGcVbR5/aQY2A+260iC1OPy1oCdB6pSSwQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- bs5 js cdn -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>