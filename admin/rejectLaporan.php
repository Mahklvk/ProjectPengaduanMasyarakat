<?php
require('../config/db.php');
header('Content-Type: application/json');

try {
    $input = json_decode(file_get_contents('php://input'), true);

    if (
        empty($input['id_pengaduan']) ||
        empty($input['tanggapan']) ||
        empty($input['id_petugas'])
    ) {
        echo json_encode([
            'success' => false,
            'message' => 'Data tidak lengkap.',
        ]);
        exit;
    }

    $id_pengaduan = intval($input['id_pengaduan']);
    $tanggapan = mysqli_real_escape_string($conn, $input['tanggapan']);
    $id_petugas = intval($input['id_petugas']);

    $query = "INSERT INTO tanggapan (id_pengaduan, tgl_tanggapan, tanggapan, id_petugas)
              VALUES ($id_pengaduan, NOW(), '$tanggapan', $id_petugas) 
              AND UPDATE pengaduan SET status = 'proses' WHERE id_pengaduan = $id_pengaduan";
    
    if (!mysqli_query($conn, $query)) {
        throw new Exception("Gagal menambahkan tanggapan.");
    }

    echo json_encode([
        'success' => true,
        'message' => 'Tanggapan berhasil ditambahkan.',
    ]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage(),
    ]);
}
