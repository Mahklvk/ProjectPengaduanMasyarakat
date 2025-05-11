<?php
require('../config/db.php');

$data = json_decode(file_get_contents("php://input"), true);

if (!$data || !isset($data['id_petugas'])) {
    echo json_encode(['success' => false, 'message' => 'Data tidak lengkap.']);
    exit;
}

$id = $data['id_petugas'];
$nik = $data['nik'];
$nama = $data['nama'];
$email = $data['email'];
$password = $data['password'];
$telp = $data['telp'];

$query = "UPDATE petugas SET 
    nik='$nik',
    nama_petugas='$nama',
    email='$email',
    password='$password',
    telp='$telp'
    WHERE id_petugas='$id'";

if (mysqli_query($conn, $query)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Gagal mengupdate akun.']);
}
?>
