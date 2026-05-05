<?php
include "../includes/init.php"; // Include Init File

include "../layout/header.php"; // Include Header
?>

<!-- Form -->
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col col-md-6">
            <div class="card p-4">
                <h1 class="text-center">Signup Form</h1>
                <form method="post" action="signup_process.php">
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control" name="username" placeholder="Enter your name" id="username">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" placeholder="Enter your email" id="staticEmail">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="pass" placeholder="Enter your password" id="pass">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirm Password</label><br>
                        <input type="password" class="form-control" name="cpass" placeholder="Confirm your password" id="cpass">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Signup</button>
                    <p class="text-center">Already have an account? <a href="login.php">Login now</a></p>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include "../layout/footer.php"; // Include Footer File ?>