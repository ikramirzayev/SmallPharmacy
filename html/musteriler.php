<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.html");
    exit();
}

require_once __DIR__ . '/../config.php';
// Müşteri ekleme
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $ad = $_POST['ad'];
    $soyad = $_POST['soyad'];

    $stmt = $conn->prepare("INSERT INTO musteri (ad, soyad) VALUES (?, ?)");
    $stmt->execute([$ad, $soyad]);
}

// Müşterileri çek
$musteriler = $conn->query("SELECT * FROM musteri ORDER BY musteri_id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <title>Müşteri Yönetimi</title>
  <link rel="stylesheet" href="../styles/style.css">
</head>
<body>
  <h1>Müşteriler</h1>

  <nav>
    <a href="index.php">Anasayfa</a>
    <a href="ilaclar.php">İlaçlar</a>
    <a href="satin_alma.php">Satın Alma</a>
    <a href="logout.php">Çıkış Yap</a>
  </nav>

  <h2>Yeni Müşteri Ekle</h2>
  <form method="post">
    <label for="ad">Ad:</label>
    <input type="text" name="ad" id="ad" required><br><br>

    <label for="soyad">Soyad:</label>
    <input type="text" name="soyad" id="soyad" required><br><br>

    <input type="submit" value="Ekle">
  </form>

  <h2>Mevcut Müşteriler</h2>
  <table>
    <tr>
      <th>#</th>
      <th>Ad</th>
      <th>Soyad</th>
    </tr>
    <?php foreach ($musteriler as $m): ?>
      <tr>
        <td><?= $m['musteri_id'] ?></td>
        <td><?= htmlspecialchars($m['ad']) ?></td>
        <td><?= htmlspecialchars($m['soyad']) ?></td>
      </tr>
    <?php endforeach; ?>
  </table>
</body>
</html>