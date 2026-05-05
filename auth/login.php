<?php
// Including Init File
include "../includes/init.php"; // Include Init File

include "../layout/header.php"; // Include Header File
?>

<!-- Form -->
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col col-md-6">
            <div class="card p-4">
                <h1 class="text-center">Login Form</h1>
                <form method="post" action="login_process.php">
                    <div class="mb-3">
                        <label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
                        <input type="email" class="form-control" name="email" placeholder="Enter your email" id="staticEmail">
                    </div>
                    <div class="mb-3">
                        <label for="pass" class="col-sm-2 col-form-label">Password</label>
                        <input type="password" class="form-control" name="pass" placeholder="Enter your password" id="pass">
                    </div>
                    <!-- Remember me -->
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                    <p class="text-center">don't have an account? <a href="signup.php">Signup now</a></p>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include "../layout/footer.php"; // Include Footer ?>