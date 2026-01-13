<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function isAdmin() {
    return $_SESSION['user']['role'] == 1;
}

function isMJ() {
    return $_SESSION['user']['role'] == 2;
}

function isChief() {
    return $_SESSION['user']['role'] == 3;
}

function isPlayer() {
    return $_SESSION['user']['role'] == 4;
}
