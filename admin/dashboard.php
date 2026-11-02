
<?php
session_start();

if (!isset($_SESSION["admin"])) {
    header("Location: login.php");
    exit;
}

require_once "../config/database.php";

$totalProduk = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM products")
)["total"];

$totalAktif = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM products WHERE status = 'active'")
)["total"];

$totalDiscontinued = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM products WHERE status = 'discontinued'")
)["total"];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - MyStore</title>

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f1f5f9;
        }

        header {
            background: #1e3a8a;
            color: white;
            padding: 20px 35px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header h2 { margin: 0; }

        .logout {
            background: #ef4444;
            color: white;
            padding: 10px 16px;
            border-radius: 7px;
            text-decoration: none;
        }

        main { padding: 35px; }

        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin: 25px 0;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(0,0,0,.07);
        }

        .card h3 {
            color: #64748b;
            margin-top: 0;
        }

        .number {
            font-size: 32px;
            font-weight: bold;
            color: #2563eb;
        }

        .menu {
            background: white;
            padding: 25px;
            border-radius: 12px;
        }

        .menu a {
            display: inline-block;
            background: #2563eb;
            color: white;
            padding: 12px 18px;
            margin: 8px 8px 0 0;
            border-radius: 7px;
            text-decoration: none;
        }

        .menu a:hover { background: #1d4ed8; }
    </style>
</head>

<body>

<header>
    <h2>MyStore | Admin Panel</h2>
    <a class="logout" href="logout.php">Logout</a>
</header>

<main>
    <h1>Dashboard Admin</h1>
    <p>Selamat datang, <b><?= htmlspecialchars($_SESSION["admin"]) ?></b>!</p>

    <div class="cards">
        <div class="card">
            <h3>Total Produk</h3>
            <div class="number"><?= $totalProduk ?></div>
        </div>

        <div class="card">
            <h3>Produk Aktif</h3>
            <div class="number"><?= $totalAktif ?></div>
        </div>

        <div class="card">
            <h3>Produk Discontinued</h3>
            <div class="number"><?= $totalDiscontinued ?></div>
        </div>
    </div>

    <div class="menu">
        <h2>Menu Pengelolaan</h2>
        <a href="products/index.php">Kelola Produk</a>
        <a href="products/create.php">Tambah Produk</a>
    </div>
</main>

</body>
</html>
