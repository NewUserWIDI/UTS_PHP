<?php
require __DIR__ . '/koneksi.php';

$err = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_menu = trim($_POST['nama_menu'] ?? '');
    $harga     = trim($_POST['harga'] ?? '');
    $kategori  = trim($_POST['kategori'] ?? '');

    if ($nama_menu === '' || $harga === '') {
        $err = 'Nama menu dan harga wajib diisi.';
    } elseif (!is_numeric($harga)) {
        $err = 'Harga harus berupa angka.';
    } else {
        try {
            qparams(
                'INSERT INTO public.menu (nama_menu, harga, kategori)
                 VALUES ($1, $2, NULLIF($3, \'\'))',
                [$nama_menu, $harga, $kategori]
            );
            header('Location: data.php');
            exit;
        } catch (Throwable $e) {
            $err = 'Gagal menyimpan data: ' . $e->getMessage();
        }
    }
}
?>

<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tambah Menu Kopi</title>
  <!-- Bootstrap CSS (ditempatkan di atas agar styling aktif lebih awal) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-5">
        <div class="card shadow-lg border-0">
          <div class="card-body p-4">
            <h3 class="text-center text-primary mb-4">Tambah Menu Kopi</h3>

            <?php if ($err): ?>
              <div class="alert alert-danger" role="alert">
                <?= htmlspecialchars($err) ?>
              </div>
            <?php endif; ?>

            <form method="post">
              <div class="mb-3">
                <label for="nama_menu" class="form-label">Nama Menu</label>
                <input type="text" name="nama_menu" id="nama_menu" class="form-control" required>
              </div>

              <div class="mb-3">
                <label for="harga" class="form-label">Harga (Rp)</label>
                <input type="number" name="harga" id="harga" class="form-control" required>
              </div>

              <div class="mb-3">
                <label for="kategori" class="form-label">Kategori (opsional)</label>
                <input type="text" name="kategori" id="kategori" class="form-control">
              </div>

              <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="data.php" class="btn btn-outline-secondary">Kembali</a>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS (diletakkan di bawah agar halaman lebih cepat dimuat) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
