<?php
// Including Init File
include "../includes/init.php";

// Remove login related data
unset($_SESSION['logged_in'], $_SESSION['id'], $_SESSION['username']);

setFlash("success", "Logout Successfully");

header("Location: ../auth/login.php");
exit;