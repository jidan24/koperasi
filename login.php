<?php
// Mengimport file conn.php untuk koneksi ke database
require_once "conn.php";

// Periksa apakah tombol "Login" ditekan
if (isset($_POST['login'])) {
    // Ambil data dari form login
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query untuk memeriksa keberadaan username dan password di tabel anggota
    $query = "SELECT * FROM anggota WHERE user = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $query);

    // Periksa hasil query
    if (mysqli_num_rows($result) == 1) {
        // Login berhasil
        $row = mysqli_fetch_assoc($result);
        $namaAnggota = $row['nama_anggota'];
        echo "Selamat datang, $namaAnggota!";

        // Arahkan ke halaman home.php setelah login berhasil
        header("Location: home.php");
        exit();
    } else {
        // Login gagal
        echo "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Form Login</title>
    <link rel="stylesheet" type="text/css" href="login.css">
</head>
<body>
    <div class="login-container">
        <h2>Form Login</h2>
        <form action="" method="POST">
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username" required><br><br>
            
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required><br><br>
            
            <input type="submit" name="login" value="Login">
        </form>
    </div>
</body>
</html>

