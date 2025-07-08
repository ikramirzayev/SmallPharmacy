<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.html");
    exit();
}

require 'config.php'; // veritabanı bağlantısı

// Kayıt ekleme
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $ilac_id = $_POST['ilac_id'];
    $miktar = $_POST['miktar'];
    $tarih = date("Y-m-d");

    $stmt = $conn->prepare("INSERT INTO satin_alma (ilac_id, miktar, tarih) VALUES (?, ?, ?)");
    $stmt->execute([$ilac_id, $miktar, $tarih]);

    // Stoktan düş
    $conn->prepare("UPDATE ilac SET stok = stok - ? WHERE ilac_id = ?")->execute([$miktar, $ilac_id]);
}

// İlaçları çek
$ilaclar = $conn->query("SELECT * FROM ilac")->fetchAll(PDO::FETCH_ASSOC);

// Satın alma kayıtlarını çek
$kaydlar = $conn->query("SELECT s.*, i.ilac_adi FROM satin_alma s JOIN ilac i ON s.ilac_id = i.ilac_id ORDER BY s.tarih DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <title>Satın Alma</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h1>Satın Alma Ekle</h1>

  <nav>
    <a href="index.php">Anasayfa</a>
    <a href="ilaclar.php">İlaçlar</a>
    <a href="logout.php">Çıkış Yap</a>
  </nav>

  <form method="post">
    <label for="ilac_id">İlaç:</label>
    <select name="ilac_id" id="ilac_id" required>
      <?php foreach ($ilaclar as $ilac): ?>
        <option value="<?= $ilac['ilac_id'] ?>"><?= $ilac['ilac_adi'] ?> (stok: <?= $ilac['stok'] ?>)</option>
      <?php endforeach; ?>
    </select><br><br>

    <label for="miktar">Miktar:</label>
    <input type="number" name="miktar" id="miktar" required><br><br>

    <input type="submit" value="Kaydı Ekle">
  </form>

  <h2>Satın Alma Kayıtları</h2>
  <table>
    <tr>
      <th>İlaç</th>
      <th>Miktar</th>
      <th>Tarih</th>
    </tr>
    <?php foreach ($kaydlar as $kayit): ?>
      <tr>
        <td><?= htmlspecialchars($kayit['ilac_adi']) ?></td>
        <td><?= htmlspecialchars($kayit['miktar']) ?></td>
        <td><?= htmlspecialchars($kayit['tarih']) ?></td>
      </tr>
    <?php endforeach; ?>
  </table>
</body>
</html>
