<?php
// Including Init File
include "../includes/init.php";


if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = c($_POST['email']);
    $pass = c($_POST['pass']);

    // Input validation
    if (is_empty($email) || is_empty($pass)) {
        setFlash("error", "Email and password are required.");
        redirect('login.php');
    }
    // Check Email Format
    if (!validEmail($email)) {
        setFlash("error", "Invalid email format.");
        redirect('login.php');
    }

    // Check if user exists
    $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE email = ?");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($pass, $row['password'])) {
            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['name'];

            setFlash("success", "You have logged In");
            redirect('../index.php');
        } else {
            setFlash("error", "Password Incorrect");
            redirect('login.php');
        }
    } else {
        setFlash("error", "Invalid credential");
        redirect('login.php');
    }
}
