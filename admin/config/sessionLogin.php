<?php
session_start();

if (!isset($_SESSION['loginAdmin']) || $_SESSION['loginAdmin'] !== true) {
    // Jika bukan admin, tolak
    header('Location: loginAdmin.php');
    exit;
}
?>