<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "koperasiuas";

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Mengecek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Mendapatkan total simpanan awal (sebelum filter)
$sql_total_simpanan = "SELECT SUM(jml_simpanan) AS total_simpanan FROM simpanan";
$result_total_simpanan = mysqli_query($conn, $sql_total_simpanan);

if ($result_total_simpanan) {
    $row_total_simpanan = mysqli_fetch_assoc($result_total_simpanan);
    $total_simpanan = $row_total_simpanan['total_simpanan'];
} else {
    $total_simpanan = 0;
}

// Mendapatkan total pinjaman awal (sebelum filter)
$sql_total_pinjaman = "SELECT SUM(jml_pinjaman) AS total_pinjaman FROM pinjaman";
$result_total_pinjaman = mysqli_query($conn, $sql_total_pinjaman);

if ($result_total_pinjaman) {
    $row_total_pinjaman = mysqli_fetch_assoc($result_total_pinjaman);
    $total_pinjaman = $row_total_pinjaman['total_pinjaman'];
} else {
    $total_pinjaman = 0;
}

// ...

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="laporan.css">
    <title>Form Laporan</title>
</head>
<body>
    <h2>Form Laporan</h2>
    <form method="POST" action="admin.php">
        <div class="form-group">
            <label for="total-simpanan">Total Simpanan:</label>
            <input type="text" id="total-simpanan" value="<?php echo number_format($total_simpanan, 0, ",", "."); ?>" readonly>
        </div>
        <div class="form-group">
            <label for="total-pinjaman">Total Pinjaman:</label>
            <input type="text" id="total-pinjaman" value="<?php echo number_format($total_pinjaman, 0, ",", "."); ?>" readonly>
        </div>
        <div class="form-group">
            <label for="tanggal">Tanggal:</label>
            <input type="date" id="tanggal" name="tanggal" required>
        </div>
        <div class="form-group">
            <label for="keterangan">Keterangan:</label>
            <textarea id="keterangan" name="keterangan" rows="4" required></textarea>
        </div>
        <button type="submit">Generate Laporan</button>
    </form>
</body>
</html>

