<?php
session_start();

if (!isset($_SESSION['level']) || $_SESSION['level'] !== 'masyarakat') {
    // Hanya user biasa yang boleh
    header('Location: login.php');
    exit;
}
