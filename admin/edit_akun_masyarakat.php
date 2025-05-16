<?php
require "config/sessionLogin.php";
require('../config/db.php');

$data = json_decode(file_get_contents("php://input"), true);

// Cek apakah semua data ada
if (
    isset($data['id_masyarakat']) &&
    isset($data['nik']) &&
    isset($data['email']) &&
    isset($data['nama']) &&
    isset($data['username']) &&
    isset($data['password']) &&
    isset($data['telp'])
) {
    $id = $data['id_masyarakat'];
    $nik = $data['nik'];
    $email = $data['email'];
    $nama = $data['nama'];
    $username = $data['username'];
    $password = $data['password'];
    $telp = $data['telp'];

    $query = "UPDATE masyarakat SET nik='$nik',email='$email', nama='$nama',username='$username', password='$password', telp='$telp' WHERE id_masyarakat='$id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal update DB']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Data tidak lengkap']);
}