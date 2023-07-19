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
$row_total_simpanan = mysqli_fetch_assoc($result_total_simpanan);
$total_simpanan = $row_total_simpanan['total_simpanan'];

// Mendapatkan total pinjaman awal (sebelum filter)
$sql_total_pinjaman = "SELECT SUM(jml_pinjaman) AS total_pinjaman FROM pinjaman";
$result_total_pinjaman = mysqli_query($conn, $sql_total_pinjaman);
$row_total_pinjaman = mysqli_fetch_assoc($result_total_pinjaman);
$total_pinjaman = $row_total_pinjaman['total_pinjaman'];

// Query untuk mendapatkan daftar nama anggota
$query_anggota = "SELECT DISTINCT nama_anggota FROM simpanan";
$result_anggota = mysqli_query($conn, $query_anggota);

// Filter Nama Anggota (Simpanan)
if (isset($_GET['filter_simpanan']) && $_GET['filter_simpanan'] != '') {
    $filter_simpanan = $_GET['filter_simpanan'];

    // Mendapatkan total simpanan sesuai filter
    $sql_total_simpanan = "SELECT SUM(jml_simpanan) AS total_simpanan FROM simpanan WHERE nama_anggota = '$filter_simpanan'";
    $result_total_simpanan = mysqli_query($conn, $sql_total_simpanan);
    $row_total_simpanan = mysqli_fetch_assoc($result_total_simpanan);
    $total_simpanan = $row_total_simpanan['total_simpanan'];
}

// Filter Nama Anggota (Pinjaman)
if (isset($_GET['filter_pinjaman']) && $_GET['filter_pinjaman'] != '') {
    $filter_pinjaman = $_GET['filter_pinjaman'];

    // Mendapatkan total pinjaman sesuai filter
    $sql_total_pinjaman = "SELECT SUM(jml_pinjaman) AS total_pinjaman FROM pinjaman WHERE nama_anggota = '$filter_pinjaman'";
    $result_total_pinjaman = mysqli_query($conn, $sql_total_pinjaman);
    $row_total_pinjaman = mysqli_fetch_assoc($result_total_pinjaman);
    $total_pinjaman = $row_total_pinjaman['total_pinjaman'];
}

// Query untuk mendapatkan data transaksi simpanan (sesuai filter)
$query_simpanan = "SELECT * FROM simpanan";
if (isset($filter_simpanan)) {
    $query_simpanan .= " WHERE nama_anggota = '$filter_simpanan'";
}
$result_simpanan = mysqli_query($conn, $query_simpanan);

// Query untuk mendapatkan data transaksi pinjaman (sesuai filter)
$query_pinjaman = "SELECT * FROM pinjaman";
if (isset($filter_pinjaman)) {
    $query_pinjaman .= " WHERE nama_anggota = '$filter_pinjaman'";
}
$result_pinjaman = mysqli_query($conn, $query_pinjaman);

// Reset Semua Transaksi
if (isset($_POST['reset_btn'])) {
    // Menghapus semua data transaksi simpanan
    $sql_delete_simpanan = "DELETE FROM simpanan";
    $result_delete_simpanan = mysqli_query($conn, $sql_delete_simpanan);

    // Menghapus semua data transaksi pinjaman
    $sql_delete_pinjaman = "DELETE FROM pinjaman";
    $result_delete_pinjaman = mysqli_query($conn, $sql_delete_pinjaman);

    // Mereset ID dengan AUTO_INCREMENT ke 1
    $sql_reset_id = "ALTER TABLE simpanan AUTO_INCREMENT = 1";
    $result_reset_id = mysqli_query($conn, $sql_reset_id);
    $sql_reset_id = "ALTER TABLE pinjaman AUTO_INCREMENT = 1";
    $result_reset_id = mysqli_query($conn, $sql_reset_id);

    if ($result_delete_simpanan && $result_delete_pinjaman && $result_reset_id) {
        // Redirect kembali ke halaman admin setelah reset transaksi
        header("Location: admin.php");
        exit;
    } else {
        echo "Gagal mereset riwayat transaksi.";
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="admin.css">
    <title>Transaksi Simpanan dan Pinjaman - Admin</title>
    <script>
        function filterTable() {
            var filterValue = document.getElementById("filterInput").value;
            window.location.href = "?filter_simpanan=" + filterValue;
        }

        function filterPinjamanTable() {
            var filterValue = document.getElementById("filterPinjamanInput").value;
            window.location.href = "?filter_pinjaman=" + filterValue;
        }
    </script>
</head>
<body>

<div class="header">
    <h1>Dashboard</h1>
</div>

<div class="menu">
    <ul>
        <li><a href="home.php">Home</a></li>
        <li><a href="nasabah.php">Nasabah</a></li>
        <li><a href="laporan.php">Laporan</a></li>
    </ul>
</div>

<h1>Transaksi Simpanan dan Pinjaman - Admin</h1>

<h3>Total Simpanan: <?php echo "Rp " . number_format($total_simpanan, 0, ",", "."); ?></h3>
<h3>Total Pinjaman: <?php echo "Rp " . number_format($total_pinjaman, 0, ",", "."); ?></h3>

<div class="filter-container">
    <label for="filterInput">Filter berdasarkan Nama Anggota (Simpanan):</label>
    <select id="filterInput" onchange="filterTable()">
        <option value="">Semua</option>
        <?php
        while ($row = mysqli_fetch_assoc($result_anggota)) {
            echo "<option value='" . $row['nama_anggota'] . "'>" . $row['nama_anggota'] . "</option>";
        }
        ?>
    </select>
    <button onclick="filterTable()">Filter</button>
</div>

<h2>Transaksi Simpanan</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Nama Anggota</th>
        <th>Jumlah Simpanan</th>
    </tr>
    <?php
    while ($row = mysqli_fetch_assoc($result_simpanan)) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['nama_anggota'] . "</td>";
        echo "<td>" . $row['jml_simpanan'] . "</td>";
        echo "</tr>";
    }
    ?>
</table>

<div class="filter-container">
    <label for="filterPinjamanInput">Filter berdasarkan Nama Anggota (Pinjaman):</label>
    <select id="filterPinjamanInput" onchange="filterPinjamanTable()">
        <option value="">Semua</option>
        <?php
        mysqli_data_seek($result_anggota, 0); // Mengembalikan pointer result_anggota ke awal
        while ($row = mysqli_fetch_assoc($result_anggota)) {
            echo "<option value='" . $row['nama_anggota'] . "'>" . $row['nama_anggota'] . "</option>";
        }
        ?>
    </select>
    <button onclick="filterPinjamanTable()">Filter</button>
</div>

<h2>Transaksi Pinjaman</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Nama Anggota</th>
        <th>Jumlah Pinjaman</th>
    </tr>
    <?php
    while ($row = mysqli_fetch_assoc($result_pinjaman)) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['nama_anggota'] . "</td>";
        echo "<td>" . $row['jml_pinjaman'] . "</td>";
        echo "</tr>";
    }
    ?>
</table>

<div class="reset-container">
    <form action="" method="POST">
        <button type="submit" name="reset_btn">Reset Semua Riwayat Transaksi</button>
    </form>
</div>

</body>
</html>
