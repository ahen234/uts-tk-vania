
<?php
session_start();

if (!isset($_SESSION["admin"])) {
    header("Location: ../login.php");
    exit;
}

require_once "../../config/database.php";

$id = (int)($_GET["id"] ?? 0);

if ($id <= 0) {
    die("ID produk tidak valid!");
}

// Ambil data produk
$stmt = mysqli_prepare(
    $conn,
    "SELECT * FROM products WHERE id = ?"
);

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$product = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$product) {
    die("Produk tidak ditemukan!");
}

// Proses update
$error = "";

if (isset($_POST["update"])) {
    $nama = $_POST["nama_produk"];
    $kategori = $_POST["kategori"];
    $harga = $_POST["harga"];
    $stok = $_POST["stok"];
    $deskripsi = $_POST["deskripsi"];
    $status = $_POST["status"];

    $stmt = mysqli_prepare(
        $conn,
        "UPDATE products SET
        nama_produk = ?,
        kategori = ?,
        harga = ?,
        stok = ?,
        deskripsi = ?,
        status = ?
        WHERE id = ?"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "ssdissi",
        $nama,
        $kategori,
        $harga,
        $stok,
        $deskripsi,
        $status,
        $id
    );

    if (mysqli_stmt_execute($stmt)) {
        header("Location: index.php");
        exit;
    } else {
        $error = "Gagal mengubah produk!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk - MyStore</title>
</head>
<body>

<h2>Edit Produk MyStore</h2>

<?php if ($error != "") : ?>
    <p style="color:red;">
        <?= htmlspecialchars($error) ?>
    </p>
<?php endif; ?>

<form method="POST">

    Nama Produk:<br>
    <input type="text" name="nama_produk"
    value="<?= htmlspecialchars($product["nama_produk"]) ?>" required>
    <br><br>

    Kategori:<br>
    <input type="text" name="kategori"
    value="<?= htmlspecialchars($product["kategori"]) ?>" required>
    <br><br>

    Harga:<br>
    <input type="number" name="harga"
    value="<?= htmlspecialchars($product["harga"]) ?>" required>
    <br><br>

    Stok:<br>
    <input type="number" name="stok"
    value="<?= htmlspecialchars($product["stok"]) ?>" required>
    <br><br>

    Deskripsi:<br>
    <textarea name="deskripsi"><?= htmlspecialchars($product["deskripsi"] ?? "") ?></textarea>
    <br><br>

    Status:<br>
    <select name="status">
        <option value="active"
        <?= $product["status"] == "active" ? "selected" : "" ?>>
            Active
        </option>

        <option value="discontinued"
        <?= $product["status"] == "discontinued" ? "selected" : "" ?>>
            Discontinued
        </option>
    </select>
    <br><br>

    <button type="submit" name="update">
        Update Produk
    </button>

    <a href="index.php">Kembali</a>

</form>

</body>
</html>
