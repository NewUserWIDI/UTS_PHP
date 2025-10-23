<?php
// --- KONFIGURASI KONEKSI POSTGRESQL ---
$host   = 'localhost';
$port   = '5432';
$dbname = 'website_coffee';   // ganti sesuai nama database kamu
$user   = 'postgres';         // ganti sesuai user PostgreSQL
$pass   = '1';            // ganti sesuai password PostgreSQL

// Membuat koneksi
$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$pass");
if (!$conn) {
    die('Koneksi gagal: ' . pg_last_error());
}

// Set encoding UTF8
pg_set_client_encoding($conn, 'UTF8');

// Jika form dikirim (tambah data nilai)
if (isset($_POST['submit'])) {
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $nilai = $_POST['nilai_uts'];

    $query = "INSERT INTO nilai_uts (nim, nama, nilai_uts) VALUES ('$nim', '$nama', '$nilai')";
    $result = pg_query($conn, $query);

    if ($result) {
        echo "<script>alert('Data berhasil ditambahkan!');</script>";
    } else {
        echo "<script>alert('Gagal menambahkan data!');</script>";
    }
}

// Ambil data dari tabel
$sql = 'SELECT * FROM nilai_uts ORDER BY nim';
$result = pg_query($conn, $sql);
if (!$result) {
    die('Query gagal: ' . pg_last_error($conn));
}
?>

<!-- HTML -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>KopiKita | Data Nilai UTS</title>
  <link rel="stylesheet" href="style.css">
  <style>
    .data-container {
        width: 90%;
        margin: 30px auto;
        padding: 20px;
    }

    .main-table-title {
        text-align: center;
        margin-bottom: 20px;
        font-size: 2em;
        font-weight: bold;
        color: #7b4f2f;
    }

    .styled-table {
        border-collapse: collapse;
        margin: 0 auto;
        font-size: 1em;
        min-width: 900px;
        background-color: #fff;
        box-shadow: 0 2px 12px rgba(0,0,0,0.07);
    }

    .styled-table thead tr {
        background-color: #7b4f2f;
        color: #ffffff;
        text-align: center;
    }

    .styled-table th, .styled-table td {
        padding: 12px 18px;
        border: 1px solid #d3d3d3;
        text-align: center;
    }

    form {
        text-align: center;
        margin-bottom: 30px;
    }

    input {
        padding: 8px;
        margin: 5px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    button {
        background-color: #7b4f2f;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
    }

    button:hover {
        background-color: #5a3922;
    }

    footer {
        text-align: center;
        padding: 20px;
        background-color: #f1e2d2;
        color: #5a3922;
        font-weight: bold;
    }

    .navbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #7b4f2f;
        padding: 10px 40px;
    }

    .navbar a {
        color: white;
        text-decoration: none;
        margin: 0 10px;
        font-weight: bold;
    }

    .logo {
        font-size: 1.5em;
        color: #fff;
    }
  </style>
</head>

<body>
  <nav class="navbar">
    <div class="logo">☕ KopiKita</div>
    <div class="nav-links">
      <a href="index.html">Home</a>
      <a href="index.php">Nilai UTS</a>
    </div>
  </nav>

  <div class="data-container">
    <div class="main-table-title">Daftar Nilai UTS Mahasiswa</div>

    <!-- Form tambah data -->
    <form method="POST" action="">
      <input type="text" name="nim" placeholder="NIM" required>
      <input type="text" name="nama" placeholder="Nama" required>
      <input type="number" step="0.01" name="nilai_uts" placeholder="Nilai UTS" required>
      <button type="submit" name="submit">Tambah</button>
    </form>

    <!-- Tabel data -->
    <table class="styled-table">
      <thead>
        <tr>
          <th>No</th>
          <th>NIM</th>
          <th>Nama</th>
          <th>Nilai UTS</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $no = 1;
        while ($row = pg_fetch_assoc($result)) : ?>
          <tr>
            <td><?= $no++; ?></td>
            <td><?= htmlspecialchars($row['nim'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?= htmlspecialchars($row['nama'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?= htmlspecialchars($row['nilai_uts'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td>
              <a href="#">Edit</a> |
              <a href="#">Hapus</a>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>

  <footer>
    © 2025 KopiKita Coffee Website — All Rights Reserved.
  </footer>
</body>
</html>

<?php
pg_free_result($result);
pg_close($conn);
?>
