<?php

declare(strict_types=1);

// --------------------
// Redirect Helper
// --------------------
function redirect(string $url): never
{
    header("Location: $url");
    exit;
}


// --------------------
// Set Flash Message
// --------------------
function setFlash(string $type, string $message): void
{
    $_SESSION['flash'][$type] = $message;
}


// --------------------
// Get Flash Message
// --------------------
function getFlash(string $type): ?string
{
    if (isset($_SESSION['flash'][$type])) {
        $msg = $_SESSION['flash'][$type];
        unset($_SESSION['flash']);
        return $msg;
    }
    return null;
}


// --------------
// Escape Output
// --------------
function e(string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

// --------------
// Clean Input
// --------------
function c(string $value): string
{
    return trim($value);
}


// -----------------
// Input Validation
// -----------------
function is_empty(string $value): bool
{
    return trim($value) === '';
}

// Email Format 
function validEmail(string $email): string
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}



function tasksByStatus(mysqli $conn, int $user_id, string $status): int
{
    $stmt = mysqli_prepare($conn, "SELECT COUNT(*) AS total FROM tasks WHERE user_id = ? AND status = ?");
    mysqli_stmt_bind_param($stmt, "is", $user_id, $status);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    return mysqli_fetch_assoc($result)['total'];
}
