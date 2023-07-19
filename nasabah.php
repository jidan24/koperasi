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

// Memproses data jika form dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mengambil data dari form
    $nama = $_POST['nama'];
    $umur = $_POST['umur'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Menyimpan anggota ke dalam database
    $sql = "INSERT INTO anggota (nama, umur, email, password) VALUES ('$nama', '$umur', '$email', '$password')";

    if (mysqli_query($conn, $sql)) {
        // Redirect kembali ke halaman admin setelah menambahkan anggota
        header("Location: admin.php");
        exit;
    } else {
        echo "Gagal menambahkan anggota: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Form Nasabah</title>
  <link rel="stylesheet" type="text/css" href="nasabah.css">
</head>
<body>
  <h2>Form Tambah Anggota</h2>
  <form action="" method="POST">
    <label for="nama">Nama Anggota:</label>
    <input type="text" id="nama" name="nama" required>

    <label for="umur">Umur Anggota:</label>
    <input type="number" id="umur" name="umur" required>

    <label for="email">Email Anggota:</label>
    <input type="email" id="email" name="email" required>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>

    <button type="submit">Tambah Anggota</button>
  </form>
</body>
</html>
