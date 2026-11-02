
<?php
session_start();

if (!isset($_SESSION["admin"])) {
    header("Location: ../login.php");
    exit;
}

require_once "../../config/database.php";

$error = "";

if (isset($_POST["simpan"])) {

    $nama = $_POST["nama_produk"];
    $kategori = $_POST["kategori"];
    $harga = $_POST["harga"];
    $stok = $_POST["stok"];
    $deskripsi = $_POST["deskripsi"];
    $status = $_POST["status"];

    $stmt = mysqli_prepare($conn,
        "INSERT INTO products
        (nama_produk, kategori, harga, stok, deskripsi, status)
        VALUES (?, ?, ?, ?, ?, ?)"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "ssdiss",
        $nama,
        $kategori,
        $harga,
        $stok,
        $deskripsi,
        $status
    );

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        header("Location: index.php");
        exit;
    } else {
        $error = "Gagal menyimpan produk: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk - MyStore</title>
</head>
<body>

    <h2>Tambah Produk MyStore</h2>

    <?php if ($error != "") : ?>
        <p style="color:red;">
            <?= htmlspecialchars($error) ?>
        </p>
    <?php endif; ?>

    <form method="POST">

        <label>Nama Produk:</label><br>
        <input type="text" name="nama_produk" required>
        <br><br>

        <label>Kategori:</label><br>
        <select name="kategori" required>
            <option value="Elektronik">Elektronik</option>
            <option value="Fashion">Fashion</option>
            <option value="Makanan">Makanan</option>
            <option value="Minuman">Minuman</option>
            <option value="Lainnya">Lainnya</option>
        </select>
        <br><br>

        <label>Harga:</label><br>
        <input type="number" name="harga" min="0" required>
        <br><br>

        <label>Stok:</label><br>
        <input type="number" name="stok" min="0" required>
        <br><br>

        <label>Deskripsi:</label><br>
        <textarea name="deskripsi"></textarea>
        <br><br>

        <label>Status:</label><br>
        <select name="status" required>
            <option value="active">Active</option>
            <option value="discontinued">Discontinued</option>
        </select>
        <br><br>

        <button type="submit" name="simpan">
            Simpan Produk
        </button>

        <a href="index.php">Kembali</a>

    </form>

</body>
</html>
