<?php
require ('config/db.php');

// Set header agar menerima JSON
header('Content-Type: application/json');

try {
    // Membaca input dari permintaan POST
    $input = json_decode(file_get_contents('php://input'), true);

    if (!isset($input['id_pengaduan']) || empty($input['id_pengaduan'])) {
        echo json_encode([
            'success' => false,
            'message' => 'ID pengaduan tidak ada atau salah.',
        ]);
        exit;
    }

    $id_pengaduan = intval($input['id_pengaduan']);

    // Query untuk mendapatkan informasi file gambar
    $queryGetPengaduan = mysqli_query($conn, "SELECT foto FROM pengaduan WHERE id_pengaduan = $id_pengaduan");
    if (mysqli_num_rows($queryGetPengaduan) === 0) {
        echo json_encode([
            'success' => false,
            'message' => 'Laporan tidak ditemukan.',
        ]);
        exit;
    }

    $dataFetch = mysqli_fetch_assoc($queryGetPengaduan);
    $imagePath = "storages/foto_laporan/" . $dataFetch['foto'];

    // Hapus data dari database
    $queryDelete = mysqli_query($conn, "DELETE FROM pengaduan WHERE id_pengaduan = $id_pengaduan");

    if (!$queryDelete) {
        throw new Exception("Gagal menghapus laporan");
    }

    // Hapus file gambar jika ada
    if (file_exists($imagePath)) {
        unlink($imagePath);
    }

    // Berikan respons sukses
    echo json_encode([
        'success' => true,
        'message' => 'Laporan berhasil terhapus.',
    ]);
} catch (Exception $e) {
    // Tangani error
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage(),
    ]);
}
