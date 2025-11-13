<?php
require __DIR__ . '/koneksi.php';

$id = (int)($_POST['id'] ?? 0);

if ($id <= 0) {
    http_response_code(400);
    exit('ID tidak valid.');
}

try {
    qparams('DELETE FROM public.menu WHERE id = $1', [$id]);
    header('Location: data.php?msg=hapus_sukses');
    exit;
} catch (Throwable $e) {
    exit('Gagal menghapus data: ' . $e->getMessage());
}
?>
