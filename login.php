<?php
session_start();
if (isset($_SESSION['user_id'])) {
  header('Location: data.php');
  exit;
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login - KopiKita</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light d-flex align-items-center justify-content-center vh-100">

  <div class="card shadow-lg border-0" style="max-width: 380px; width: 100%;">
    <div class="card-body p-4">
     <h3 class="text-center mb-4" style="color: #4b2e05;">
          Login ke <strong style="color: #4b2e05;">KopiKita</strong>
      </h3>


      <?php if (!empty($_GET['error'])): ?>
        <div class="alert alert-danger text-center" role="alert">
          <?= htmlspecialchars($_GET['error']) ?>
        </div>
      <?php endif; ?>

      <form action="authenticate.php" method="post" autocomplete="off">
        <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <input type="text" name="username" id="username" class="form-control" placeholder="Masukkan username" required>
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password" required>
        </div>

        <div class="d-grid gap-2 mt-4">
          <button type="submit" class="btn btn-success">Masuk</button>
          <a href="register.php" class="btn btn-outline-secondary">Register</a>
          <a href="index.html" class="btn btn-outline-secondary">← Kembali ke Home</a>
        </div>
      </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
