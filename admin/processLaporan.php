<?php
require "config/sessionLogin.php";
require('../config/db.php');

// Set header untuk JSON response
header('Content-Type: application/json');

// Cek apakah request method adalah POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Method tidak diizinkan']);
    exit;
}

// Ambil data JSON dari request body
$input = json_decode(file_get_contents('php://input'), true);

// Validasi input
if (!isset($input['id_pengaduan']) || !isset($input['tanggapan']) || !isset($input['status'])) {
    echo json_encode(['success' => false, 'message' => 'Data tidak lengkap']);
    exit;
}

$id_pengaduan = intval($input['id_pengaduan']);
$tanggapan = htmlspecialchars(trim($input['tanggapan']));
$status = $input['status'];
$tgl_tanggapan = date('Y-m-d');
$id_petugas = $_SESSION['id_petugas'];

// Validasi status
if (!in_array($status, ['selesai', 'ditolak'])) {
    echo json_encode(['success' => false, 'message' => 'Status tidak valid']);
    exit;
}

// Validasi tanggapan tidak boleh kosong
if (empty($tanggapan)) {
    echo json_encode(['success' => false, 'message' => 'Tanggapan tidak boleh kosong']);
    exit;
}

// Cek apakah pengaduan exists
$checkPengaduan = mysqli_query($conn, "SELECT * FROM pengaduan WHERE id_pengaduan = '$id_pengaduan'");
if (mysqli_num_rows($checkPengaduan) == 0) {
    echo json_encode(['success' => false, 'message' => 'Pengaduan tidak ditemukan']);
    exit;
}

// Cek apakah sudah ada tanggapan
$checkTanggapan = mysqli_query($conn, "SELECT * FROM tanggapan WHERE id_pengaduan = '$id_pengaduan'");
if (mysqli_num_rows($checkTanggapan) > 0) {
    echo json_encode(['success' => false, 'message' => 'Tanggapan sudah pernah diberikan']);
    exit;
}


try {
    // Insert tanggapan
    $queryInsertTanggapan = "INSERT INTO tanggapan (id_pengaduan, tgl_tanggapan, tanggapan, id_petugas) 
                            VALUES ('$id_pengaduan', '$tgl_tanggapan', '$tanggapan', '$id_petugas')";
    
    $resultTanggapan = mysqli_query($conn, $queryInsertTanggapan);
    
    if (!$resultTanggapan) {
        throw new Exception('Gagal menyimpan tanggapan');
    }
    
    // Update status pengaduan
    $queryUpdateStatus = "UPDATE pengaduan SET status = '$status' WHERE id_pengaduan = '$id_pengaduan'";
    $resultStatus = mysqli_query($conn, $queryUpdateStatus);
    
    if (!$resultStatus) {
        throw new Exception('Gagal mengupdate status pengaduan');
    }
    
    // Commit transaction
    mysqli_commit($conn);
    
    echo json_encode([
        'success' => true, 
        'message' => 'Laporan berhasil diproses dan status telah diupdate'
    ]);
    
} catch (Exception $e) {
    // Rollback transaction jika ada error
    mysqli_rollback($conn);
    
    echo json_encode([
        'success' => false, 
        'message' => $e->getMessage()
    ]);
}

// Kembalikan autocommit
mysqli_autocommit($conn, true);
?>