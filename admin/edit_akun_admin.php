<?php
require "config/sessionLogin.php";
require('../config/db.php');

$data = json_decode(file_get_contents("php://input"), true);

// Cek apakah semua data ada
if (
    isset($data['id_petugas']) &&
    isset($data['nik']) &&
    isset($data['nama']) &&
    isset($data['username']) &&
    isset($data['email']) &&
    isset($data['password']) &&
    isset($data['telp'])
) {
    $id = $data['id_petugas'];
    $nik = preg_replace('/\D/', '', $data['nik']);
    $nama = $data['nama'];
    $username = $data['username'];
    $email = $data['email'];
    $password = $data['password'];
    $telp = preg_replace('/\D/', '', $data['telp']);

    $query = "UPDATE petugas SET nik='$nik', nama_petugas='$nama', username='$username', email='$email', password='$password', telp='$telp' WHERE id_petugas='$id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal update DB']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Data tidak lengkap']);
}