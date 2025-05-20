<?php
session_start();

if (!isset($_SESSION['loginAdmin']) || $_SESSION['loginAdmin'] !== true || $_SESSION['level'] !== 'admin') {
    // Jika bukan admin, tolak
    header('Location: loginAdmin.php');
    exit;
}
?>