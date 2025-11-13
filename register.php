<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header('Location: data.php');
    exit;
}


if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$error = $_GET['error'] ?? '';
$success = $_GET['success'] ?? '';
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Register - KopiKita</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center vh-100">

  <div class="card shadow p-4" style="max-width: 420px; width: 100%;">
    <h3 class="text-center mb-4 text-brown">Daftar Akun KopiKita</h3>

    <?php if ($error): ?>
      <div class="alert alert-danger py-2"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
      <div class="alert alert-success py-2"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <form action="register_process.php" method="post" autocomplete="off">
      <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

      <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input id="username" name="username" type="text" class="form-control" required minlength="3" maxlength="100">
      </div>

      <div class="mb-3">
        <label for="full_name" class="form-label">Nama Lengkap</label>
        <input id="full_name" name="full_name" type="text" class="form-control" maxlength="200">
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input id="password" name="password" type="password" class="form-control" required minlength="6">
      </div>

      <div class="mb-3">
        <label for="password_confirm" class="form-label">Konfirmasi Password</label>
        <input id="password_confirm" name="password_confirm" type="password" class="form-control" required minlength="6">
      </div>

      <div class="mb-3 text-muted small">Password minimal 6 karakter.</div>

      <button type="submit" class="btn btn-primary w-100 mb-2">Daftar</button>
      <a href="login.php" class="btn btn-outline-secondary w-100">Sudah punya akun? Login</a>
    </form>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
