<?php
require "config/sessionLogin.php";
require('../config/db.php');

$data = json_decode(file_get_contents("php://input"), true);

// Validasi input
if (!$data || !isset($data['id_petugas'])) {
    echo json_encode(['success' => false, 'message' => 'ID tidak ditemukan.']);
    exit;
}

$idToDelete = $data['id_petugas'];
$currentUserId = $_SESSION['id_petugas']; // pastikan ini di-set saat login

// Eksekusi query hapus
$query = "DELETE FROM petugas WHERE id_petugas = '$idToDelete'";
if (mysqli_query($conn, $query)) {
    // Cek apakah yang dihapus adalah akun milik sendiri
    if ($idToDelete == $currentUserId) {
        session_destroy();
    }
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Gagal menghapus akun.']);
}
?>