<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// PDO
// Docker
$host = "db";
$dbname = 'jdr_db';
$dbUser = "user";
$dbPass = "password";

// Herbergeur
// $host = "sql112.infinityfree.com"; 
// $dbname = "if0_39082042_jdr_db";   
// $dbUser = "if0_39082042";         
// $dbPass = "x93mK954LZY";      


// Script PDO
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    file_put_contents('error_log.txt', date('[Y-m-d H:i:s] ') . $e->getMessage() . "\n", FILE_APPEND);
    die("Une erreur est survenue.");
}

// CSP
header(
  "Content-Security-Policy: "
  ."default-src 'self'; "
  ."script-src 'self' 'unsafe-inline'; "
  ."img-src 'self' data:; "
  ."base-uri 'none'; "
  ."frame-ancestors 'none'"
);
header("X-Content-Type-Options: nosniff");
header("Referrer-Policy: strict-origin-when-cross-origin");