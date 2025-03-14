<?php
// Konfigurasi database
$host = "localhost";
$user = "root";
$pass = "";
$db = "biodata_db";

// Membuat koneksi ke database
$conn = new mysqli($host, $user, $pass, $db);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Membuat tabel jika belum ada
$sql = "CREATE TABLE IF NOT EXISTS biodata (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100),
    umur INT,
    alamat TEXT,
    email VARCHAR(100),
    hobi TEXT
)";
$conn->query($sql);

// Menyimpan data dari form ke database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $umur = $_POST['umur'];
    $alamat = $_POST['alamat'];
    $email = $_POST['email'];
    $hobi = $_POST['hobi'];
    
    $stmt = $conn->prepare("INSERT INTO biodata (nama, umur, alamat, email, hobi) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sisss", $nama, $umur, $alamat, $email, $hobi);
    
    if ($stmt->execute()) {
        echo "<p>Data berhasil disimpan!</p>";
    } else {
        echo "<p>Gagal menyimpan data.</p>";
    }
    $stmt->close();
}

// Mengambil data dari database
$result = $conn->query("SELECT * FROM biodata");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Biodata</title>
</head>
<body>
    <h2>Form Biodata</h2>
    <form method="post" action="">
        Nama: <input type="text" name="nama" required><br>
        Umur: <input type="number" name="umur" required><br>
        Alamat: <textarea name="alamat" required></textarea><br>
        Email: <input type="email" name="email" required><br>
        Hobi: <input type="text" name="hobi" required><br>
        <button type="submit">Simpan</button>
    </form>

    <h2>Data Biodata</h2>
    <table border="1">
        <tr>
            <th>Nama</th>
            <th>Umur</th>
            <th>Alamat</th>
            <th>Email</th>
            <th>Hobi</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row["nama"]; ?></td>
                <td><?php echo $row["umur"]; ?></td>
                <td><?php echo $row["alamat"]; ?></td>
                <td><?php echo $row["email"]; ?></td>
                <td><?php echo $row["hobi"]; ?></td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>

<?php
$conn->close();
?>

