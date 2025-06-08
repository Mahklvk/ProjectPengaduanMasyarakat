<?php
// processLaporan.php
session_start();
require_once('../config/db.php');
require_once('../config/functions_notifikasi.php');

// Set header untuk JSON response
header('Content-Type: application/json');

// Cek apakah user sudah login sebagai petugas
if (!isset($_SESSION['id_petugas'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

// Ambil data JSON dari request
$input = json_decode(file_get_contents('php://input'), true);

if (!$input || !isset($input['id_pengaduan']) || !isset($input['tanggapan']) || !isset($input['status'])) {
    echo json_encode(['success' => false, 'message' => 'Data tidak lengkap']);
    exit;
}

$id_pengaduan = $input['id_pengaduan'];
$tanggapan = $input['tanggapan'];
$status = $input['status']; // 'selesai' atau 'ditolak'
$id_petugas = $_SESSION['id_petugas'];
$tgl_tanggapan = date('Y-m-d');

// Ambil data pengaduan untuk mendapatkan username
$queryPengaduan = mysqli_query($conn, "SELECT username FROM pengaduan WHERE id_pengaduan = '$id_pengaduan'");
$dataPengaduan = mysqli_fetch_assoc($queryPengaduan);

if (!$dataPengaduan) {
    echo json_encode(['success' => false, 'message' => 'Pengaduan tidak ditemukan']);
    exit;
}

$username = $dataPengaduan['username'];

// Mulai transaksi
mysqli_begin_transaction($conn);

try {
    // Insert tanggapan
    $queryTanggapan = "INSERT INTO tanggapan (id_pengaduan, tgl_tanggapan, tanggapan, id_petugas) 
                       VALUES (?, ?, ?, ?)";
    $stmtTanggapan = mysqli_prepare($conn, $queryTanggapan);
    mysqli_stmt_bind_param($stmtTanggapan, "issi", $id_pengaduan, $tgl_tanggapan, $tanggapan, $id_petugas);
    
    if (!mysqli_stmt_execute($stmtTanggapan)) {
        throw new Exception('Gagal menyimpan tanggapan');
    }

    // Update status pengaduan
    $queryUpdateStatus = "UPDATE pengaduan SET status = ? WHERE id_pengaduan = ?";
    $stmtUpdateStatus = mysqli_prepare($conn, $queryUpdateStatus);
    mysqli_stmt_bind_param($stmtUpdateStatus, "si", $status, $id_pengaduan);
    
    if (!mysqli_stmt_execute($stmtUpdateStatus)) {
        throw new Exception('Gagal mengupdate status pengaduan');
    }

    // Buat notifikasi untuk user
    if (!buatNotifikasi($id_pengaduan, $username, $status, $conn)) {
        throw new Exception('Gagal membuat notifikasi');
    }

    // Commit transaksi
    mysqli_commit($conn);
    
    echo json_encode([
        'success' => true, 
        'message' => 'Laporan berhasil diproses dan notifikasi telah dikirim'
    ]);

} catch (Exception $e) {
    // Rollback transaksi jika ada error
    mysqli_rollback($conn);
    
    echo json_encode([
        'success' => false, 
        'message' => $e->getMessage()
    ]);
}

mysqli_close($conn);
?>