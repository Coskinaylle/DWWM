<?php
if(empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}


// Récup
function get_csrf_token(): string {
    return $_SESSION['csrf_token'] ??'';
}

// Put
function csrf_input(): string {
    $token = htmlspecialchars(get_csrf_token(), ENT_QUOTES, 'UTF-8');
    return '<input type="hidden" name="csrf_token" value="' . $token . '">';
}


// Check
function verify_csrf_token($token): bool {
    if (!isset($_SESSION['csrf_token']) || !$token) {
        return false;
    }
    return hash_equals($_SESSION['csrf_token'], $token);
}
?>