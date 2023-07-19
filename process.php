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

// Menangani simpanan
if (isset($_POST['simpanan_btn'])) {
    // Mengambil data dari form
    $nama_anggota = $_POST['nama_anggota'];
    $jml_simpanan = $_POST['jml_simpanan'];

    // Menambahkan simpanan ke database
    $sql = "INSERT INTO simpanan (nama_anggota, jml_simpanan) VALUES ('$nama_anggota', '$jml_simpanan')";

    if (mysqli_query($conn, $sql)) {
        // Menghitung total simpanan
        $query_total_simpanan = "SELECT SUM(jml_simpanan) AS total_simpanan FROM simpanan WHERE nama_anggota = '$nama_anggota'";
        $result = mysqli_query($conn, $query_total_simpanan);
        $row = mysqli_fetch_assoc($result);
        $total_simpanan = $row['total_simpanan'];

        if ($total_simpanan !== null) {
            echo "Simpanan berhasil ditambahkan. Total simpanan Anda: " . $total_simpanan;
        } else {
            echo "Simpanan berhasil ditambahkan. Total simpanan Anda: 0";
        }
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// // Menangani pinjaman
// if (isset($_POST['pinjaman_btn'])) {
//     // Mengambil data dari form
//     $nama_anggota = $_POST['nama_anggota'];
//     $jml_pinjaman = $_POST['jml_pinjaman'];

//     // Menambahkan pinjaman ke database
//     $sql = "INSERT INTO pinjaman (nama_anggota, jml_pinjaman) VALUES ('$nama_anggota', '$jml_pinjaman')";

//     if (mysqli_query($conn, $sql)) {
//         // Menghitung total pinjaman
//         $query_total_pinjaman = "SELECT SUM(jml_pinjaman) AS total_pinjaman FROM pinjaman WHERE nama_anggota = '$nama_anggota'";
//         $result = mysqli_query($conn, $query_total_pinjaman);
//         $row = mysqli_fetch_assoc($result);
//         $total_pinjaman = $row['total_pinjaman'];

//         if ($total_pinjaman !== null) {
//             echo "Pinjaman berhasil ditambahkan. Total simpanan Anda: " . $total_pinjaman;
//         } else {
//             echo "pinjaman berhasil ditambahkan. Total simpanan Anda: 0";
//         }
//     } else {
//         echo "Error: " . $sql . "<br>" . mysqli_error($conn);
//     }
// }



// Menangani pinjaman
if (isset($_POST['pinjaman_btn'])) {
    // Mengambil data dari form
    $nama_anggota = $_POST['nama_anggota'];
    $jml_pinjaman = $_POST['jml_pinjaman'];

    // Membuat pinjaman dalam database
    $sql = "INSERT INTO pinjaman (nama_anggota, jml_pinjaman) VALUES ('$nama_anggota', '$jml_pinjaman')";

    if (mysqli_query($conn, $sql)) {
        echo "Pinjaman berhasil dibuat.";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
