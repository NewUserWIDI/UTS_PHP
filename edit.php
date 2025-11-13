<?php
require __DIR__ . '/koneksi.php';

$err = '';
$id = (int)($_GET['id'] ?? 0);


if ($id <= 0) {
    http_response_code(400);
    exit('ID tidak valid.');
}


try {
    $res = qparams('SELECT id, nama_menu, harga, kategori FROM public.menu WHERE id=$1', [$id]);
    $row = pg_fetch_assoc($res);
    if (!$row) {
        http_response_code(404);
        exit('Data tidak ditemukan.');
    }
} catch (Throwable $e) {
    exit('Error: ' . htmlspecialchars($e->getMessage()));
}


$nama_menu = $row['nama_menu'];
$harga     = $row['harga'];
$kategori  = $row['kategori'];

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
                'UPDATE public.menu
                 SET nama_menu=$1, harga=$2, kategori=NULLIF($3, \'\')
                 WHERE id=$4',
                [$nama_menu, $harga, $kategori, $id]
            );
            header('Location: data.php');
            exit;
        } catch (Throwable $e) {
            $err = 'Gagal memperbarui data: ' . $e->getMessage();
        }
    }
}
?>

<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Edit Menu Kopi</title>

  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-5">
        <div class="card shadow-lg border-0">
          <div class="card-body p-4">
            <h3 class="text-center text-primary mb-4">Edit Menu Kopi</h3>

            <?php if ($err): ?>
              <div class="alert alert-danger" role="alert">
                <?= htmlspecialchars($err) ?>
              </div>
            <?php endif; ?>

            <form method="post">
              <div class="mb-3">
                <label for="nama_menu" class="form-label">Nama Menu</label>
                <input type="text" name="nama_menu" id="nama_menu"
                       class="form-control" required
                       value="<?= htmlspecialchars($nama_menu) ?>">
              </div>

              <div class="mb-3">
                <label for="harga" class="form-label">Harga (Rp)</label>
                <input type="number" name="harga" id="harga"
                       class="form-control" required
                       value="<?= htmlspecialchars($harga) ?>">
              </div>

              <div class="mb-3">
                <label for="kategori" class="form-label">Kategori (opsional)</label>
                <input type="text" name="kategori" id="kategori"
                       class="form-control"
                       value="<?= htmlspecialchars($kategori) ?>">
              </div>

              <div class="d-grid gap-2">
                <button type="submit" class="btn btn-success"> Simpan Perubahan</button>
                <a href="data.php" class="btn btn-outline-secondary">Batal</a>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>