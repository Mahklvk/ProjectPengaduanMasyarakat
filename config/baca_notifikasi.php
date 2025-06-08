<?php
// config/baca_notifikasi.php
session_start();
require_once('db.php');
require_once('functions_notifikasi.php');

header('Content-Type: application/json');

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

// Ambil data JSON dari request
$input = json_decode(file_get_contents('php://input'), true);

if (!$input || !isset($input['id_notifikasi'])) {
    echo json_encode(['success' => false, 'message' => 'ID notifikasi tidak ditemukan']);
    exit;
}

$id_notifikasi = $input['id_notifikasi'];

// Tandai notifikasi sebagai sudah dibaca
if (tandaiSudahDibaca($id_notifikasi, $conn)) {
    echo json_encode(['success' => true, 'message' => 'Notifikasi ditandai sebagai sudah dibaca']);
} else {
    echo json_encode(['success' => false, 'message' => 'Gagal menandai notifikasi']);
}

mysqli_close($conn);
?>