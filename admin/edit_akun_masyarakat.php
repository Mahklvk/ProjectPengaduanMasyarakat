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
    $nik = preg_replace('/\D/', '', $data['nik']);
    $email = $data['email'];
    $nama = $data['nama'];
    $username = $data['username'];
    $password = $data['password'];
    $telp = preg_replace('/\D/', '', $data['telp']);

    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $update_query = "UPDATE masyarakat SET nik='$nik',email='$email', nama='$nama',username='$username', password='$hashed_password', telp='$telp' WHERE id_masyarakat='$id'";
    } else {
        // Jika password tidak diubah
        $update_query = "UPDATE masyarakat SET nik='$nik',email='$email', nama='$nama',username='$username', telp='$telp' WHERE id_masyarakat='$id'";
    }

    if (mysqli_query($conn, $update_query )) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal update Database']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Data tidak lengkap']);
}