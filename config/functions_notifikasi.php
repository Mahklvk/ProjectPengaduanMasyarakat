<?php
// functions_notifikasi.php
require_once 'db.php';

function buatNotifikasi($id_pengaduan, $username, $tipe_notifikasi, $conn) {
    $pesan = '';
    
    switch($tipe_notifikasi) {
        case 'diproses':
            $pesan = "Laporan Anda sedang diproses oleh petugas dan admin";
            break;
        case 'selesai':
            $pesan = "Laporan Anda telah disetujui oleh admin";
            break;
        case 'ditolak':
            $pesan = "Laporan Anda telah ditolak oleh admin";
            break;
    }
    
    $query = "INSERT INTO notifikasi (id_pengaduan, username, pesan, tipe_notifikasi) 
              VALUES (?, ?, ?, ?)";
    
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "isss", $id_pengaduan, $username, $pesan, $tipe_notifikasi);
    
    return mysqli_stmt_execute($stmt);
}

function getNotifikasi($username, $conn) {
    $query = "SELECT * FROM notifikasi 
              WHERE username = ? 
              ORDER BY tanggal_dibuat DESC 
              LIMIT 10";
    
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function hitungNotifikasiBelumDibaca($username, $conn) {
    $query = "SELECT COUNT(*) as total FROM notifikasi 
              WHERE username = ? AND status = 'belum_dibaca'";
    
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    
    return $row['total'];
}

function tandaiSudahDibaca($id_notifikasi, $conn) {
    $query = "UPDATE notifikasi SET status = 'sudah_dibaca' WHERE id_notifikasi = ?";
    
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id_notifikasi);
    
    return mysqli_stmt_execute($stmt);
}

function tandaiSemuaSudahDibaca($username, $conn) {
    $query = "UPDATE notifikasi SET status = 'sudah_dibaca' WHERE username = ?";
    
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    
    return mysqli_stmt_execute($stmt);
}
?>