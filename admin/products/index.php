
<?php
session_start();

if (!isset($_SESSION["admin"])) {
    header("Location: ../login.php");
    exit;
}

require_once "../../config/database.php";

$query = mysqli_query($conn, "SELECT * FROM products ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Produk - MyStore</title>
</head>
<body>

    <h1>Data Produk MyStore</h1>

    <a href="../dashboard.php">Kembali ke Dashboard</a>
    <br><br>

    <a href="create.php">+ Tambah Produk</a>

    <br><br>

    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Nama Produk</th>
            <th>Kategori</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($query)) : ?>
        <tr>
            <td><?= $row["id"] ?></td>
            <td><?= htmlspecialchars($row["nama_produk"]) ?></td>
            <td><?= htmlspecialchars($row["kategori"]) ?></td>
            <td>Rp<?= number_format($row["harga"], 0, ',', '.') ?></td>
            <td><?= $row["stok"] ?></td>
            <td><?= $row["status"] ?></td>
            <td>
                <a href="edit.php?id=<?= $row["id"] ?>">Edit</a> |
                <a href="delete.php?id=<?= $row["id"] ?>"
                   onclick="return confirm('Yakin ingin menghapus produk?')">
                   Hapus
                </a>
            </td>
        </tr>
        <?php endwhile; ?>

    </table>

</body>
</html>
