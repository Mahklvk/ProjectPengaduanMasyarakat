<?php
require "config/sessionLogin.php";
require('../config/db.php');

$data = json_decode(file_get_contents("php://input"), true);

// Cek apakah semua data ada
if (
    isset($data['id_petugas']) &&
    isset($data['nik']) &&
    isset($data['email']) &&
    isset($data['username']) &&
    isset($data['password']) &&
    isset($data['telp'])
) {
    $id = $data['id_petugas'];
    $nik = preg_replace('/\D/', '', $data['nik']);
    $email = $data['email'];
    $username = $data['username'];
    $password = $data['password'];
    $telp = preg_replace('/\D/', '', $data['telp']);

    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $update_query = "UPDATE petugas SET nik='$nik',email='$email',username='$username', password='$hashed_password', telp='$telp' WHERE id_petugas='$id'";
    } else {
        // Jika password tidak diubah
        $update_query = "UPDATE petugas SET nik='$nik',email='$email',username='$username', telp='$telp' WHERE id_petugas='$id'";
    }

    if (mysqli_query($conn, $update_query )) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal update Database']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Data tidak lengkap']);
}