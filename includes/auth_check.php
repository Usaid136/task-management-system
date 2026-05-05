<?php

// If not logged in redirect to login.php
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    setFlash("error", "Login to contiue.");
    header("Location:" . BASE_URL . "auth/login.php");
    exit;
}
