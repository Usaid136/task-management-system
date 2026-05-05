<?php
// Including Init File
include "../includes/init.php";


if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = c($_POST['username']);
    $email = c($_POST['email']);
    $pass = c($_POST['pass']);
    $cpass = c($_POST['cpass']);

    // Input validation
    if (is_empty($username) || is_empty($email) || is_empty($pass) || is_empty($cpass)) {
        setFlash("error", "All fields are required");
        redirect('signup.php');
    } else {
        // Check email exist or not
        $stmt = mysqli_prepare($conn, "SELECT * FROM `users` WHERE email = ?");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($result) > 0) {
            setFlash("error", "Email already exist");
            redirect('signup.php');
        } else {
            // Match passwords
            if ($pass == $cpass) {
                $hashPass = password_hash($cpass, PASSWORD_DEFAULT);
                $stmt = mysqli_prepare($conn, "INSERT INTO `users` (name,email,password) VALUES (?,?,?)");
                mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashPass);
                $result = mysqli_stmt_execute($stmt);
                if ($result) {
                    setFlash("success", "Registration Successful!");
                    redirect('login.php');
                } else {
                    setFlash("error", "Registration Failed!");
                    redirect('signup.php');
                }
            } else {
                setFlash("error", "Passwords not match");
                redirect('signup.php');
            }
        }
    }
}
