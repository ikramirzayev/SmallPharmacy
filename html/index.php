<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8" />
  <title>Eczane Sistemi</title>
  <link rel="stylesheet" href="../styles/style.css" />
</head>
<body>
  <h1>Eczane Yönetim Paneli</h1>

  <nav>
    <a href="ilaclar.php">İlaçlar</a>
    <a href="musteriler.php">Müşteriler</a>
    <a href="satin_alma.php">Satın Alma</a>
    <a href="logout.php">Çıkış Yap</a>
  </nav>

  <p>Hoş geldiniz, admin!</p>
</body>
</html>
