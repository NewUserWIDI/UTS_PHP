<?php
session_start();
require_once 'koneksi.php';


$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';


if ($username === '' || $password === '') {
    header('Location: login.php?error=' . urlencode('Username dan password harus diisi.'));
    exit;
}


try {
    $conn = get_pg_connection();
} catch (Throwable $e) {
    error_log('DB connection error in authenticate.php: ' . $e->getMessage());
    header('Location: login.php?error=' . urlencode('Gagal koneksi ke database.'));
    exit;
}


$sql = 'SELECT id, username, password_hash, full_name 
        FROM users 
        WHERE username = $1 
        LIMIT 1';

$result = pg_query_params($conn, $sql, [$username]);

if (!$result) {
    error_log('Query error in authenticate.php: ' . pg_last_error($conn));
    header('Location: login.php?error=' . urlencode('Terjadi kesalahan pada server.'));
    exit;
}

if (pg_num_rows($result) === 0) {
    header('Location: login.php?error=' . urlencode('Username atau password salah.'));
    exit;
}

$user = pg_fetch_assoc($result);


if (!password_verify($password, $user['password_hash'])) {
    header('Location: login.php?error=' . urlencode('Username atau password salah.'));
    exit;
}


session_regenerate_id(true);
$_SESSION['user_id'] = $user['id'];
$_SESSION['username'] = $user['username'];
$_SESSION['full_name'] = $user['full_name'];


header('Location: data.php');
exit;
