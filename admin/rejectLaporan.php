<?php
require "config/sessionLogin.php";
require('../config/db.php');
header('Content-Type: application/json');

try {
    $input = json_decode(file_get_contents('php://input'), true);

    if (!isset($input['id_pengaduan']) || empty($input['id_pengaduan'])) {
        echo json_encode([
            'success' => false,
            'message' => 'ID pengaduan tidak ada atau salah.',
        ]);
        exit;
    }

    $id_pengaduan = intval($input['id_pengaduan']);

    // Cek apakah laporan ada
    $queryGetPengaduan = mysqli_query($conn, "SELECT foto FROM pengaduan WHERE id_pengaduan = $id_pengaduan");
    if (mysqli_num_rows($queryGetPengaduan) === 0) {
        echo json_encode([
            'success' => false,
            'message' => 'Laporan tidak ditemukan.',
        ]);
        exit;
    }

    // Update status laporan
    $queryUpdate = mysqli_query($conn, "UPDATE pengaduan SET status = 'ditolak' WHERE id_pengaduan = $id_pengaduan");

    if (!$queryUpdate) {
        throw new Exception("Gagal mengubah status laporan");
    }

    echo json_encode([
        'success' => true,
        'message' => 'Laporan berhasil ditolak.',
    ]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage(),
    ]);
}