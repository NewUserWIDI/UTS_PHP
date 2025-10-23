<?php
$host = 'localhost';
$port = '5432';
$dbname = 'coffe-website'; 
$user = 'postgres';
$pass = '1';

$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$pass");
if (!$conn) {
    die("Koneksi gagal: " . pg_last_error());
}

$query = 'SELECT * FROM "TB_menu" ORDER BY id';
$result = pg_query($conn, $query);
if (!$result) {
    die("Query gagal: " . pg_last_error($conn));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Daftar Menu KopiKita</title>
<style>
body { font-family: Arial, sans-serif; background-color: #fff7ed; }
h2 { text-align:center; color:#5c3a21; margin-top:30px; }
table { border-collapse:collapse; width:80%; margin:20px auto; background:#fff8f0; border-radius:10px; box-shadow:0 4px 8px rgba(0,0,0,0.1); }
th, td { padding:12px; text-align:center; border-bottom:1px solid #e0c9a6; }
th { background:#8b5e3b; color:#fff; }
tr:nth-child(even){ background-color:#f9e6d0; }
tr:hover{ background-color:#f3d6b8; transition:0.3s; }
</style>
</head>
<body>

<h2>Daftar Menu Kopi dari Database</h2>
<table>
<tr><th>ID</th><th>Nama Menu</th><th>Harga</th><th>Stok</th><th>Kategori</th></tr>
<?php
while ($row = pg_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>".$row['id']."</td>";
    echo "<td>".$row['nama_menu']."</td>";
    echo "<td>Rp ".number_format($row['harga'], 0, ',', '.')."</td>";
    echo "<td>".$row['stok']."</td>";
    echo "<td>".$row['kategori']."</td>";
    echo "</tr>";
}
pg_close($conn);
?>
</table>
</body>
</html>
