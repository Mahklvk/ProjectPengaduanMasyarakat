<?php
// config/tandai_semua_dibaca.php
session_start();
require_once('db.php');
require_once('functions_notifikasi.php');

header('Content-Type: application/json');

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$username = $_SESSION['username'];

// Tandai semua notifikasi sebagai sudah dibaca
if (tandaiSemuaSudahDibaca($username, $conn)) {
    echo json_encode(['success' => true, 'message' => 'Semua notifikasi ditandai sebagai sudah dibaca']);
} else {
    echo json_encode(['success' => false, 'message' => 'Gagal menandai semua notifikasi']);
}

mysqli_close($conn);
?>