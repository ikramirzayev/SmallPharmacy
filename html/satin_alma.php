<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.html");
    exit();
}

require_once __DIR__ . '/../config.php';

// Satın alma ekleme işlemi
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $ilac_id = $_POST['ilac_id'];
    $miktar = $_POST['miktar'];

    // Müşteri adı ve soyadı tek input olarak
    $musteri_tamadi = trim($_POST['musteri_adi']);
    // İsim ve soyisim boşlukla ayrılmış kabul edelim
    $isim_parcalari = explode(' ', $musteri_tamadi, 2);
    $ad = $isim_parcalari[0];
    $soyad = isset($isim_parcalari[1]) ? $isim_parcalari[1] : '';

    // Müşteri var mı kontrol et
    $stmt = $conn->prepare("SELECT musteri_id FROM musteri WHERE ad = ? AND soyad = ?");
    $stmt->execute([$ad, $soyad]);
    $musteri = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($musteri) {
        $musteri_id = $musteri['musteri_id'];
    } else {
        // Yeni müşteri ekle
        $stmt = $conn->prepare("INSERT INTO musteri (ad, soyad) VALUES (?, ?)");
        $stmt->execute([$ad, $soyad]);
        $musteri_id = $conn->lastInsertId();
    }

    $tarih = date("Y-m-d");

    // Satın alma kaydını ekle
    $stmt = $conn->prepare("INSERT INTO satin_alma (musteri_id, ilac_id, miktar, tarih) VALUES (?, ?, ?, ?)");
    $stmt->execute([$musteri_id, $ilac_id, $miktar, $tarih]);

    // Stoktan düş
    $conn->prepare("UPDATE ilac SET stok = stok - ? WHERE ilac_id = ?")->execute([$miktar, $ilac_id]);
}

// İlaçları çek
$ilaclar = $conn->query("SELECT * FROM ilac")->fetchAll(PDO::FETCH_ASSOC);

// Satın alma kayıtlarını çek (müşteri adıyla)
$kaydlar = $conn->query("
    SELECT s.*, i.ilac_adi, m.ad, m.soyad 
    FROM satin_alma s
    JOIN ilac i ON s.ilac_id = i.ilac_id
    JOIN musteri m ON s.musteri_id = m.musteri_id
    ORDER BY s.tarih DESC
")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <title>Satın Alma</title>
  <link rel="stylesheet" href="../styles/style.css">
</head>
<body>
  <h1>Satın Alma Ekle</h1>

  <nav>
    <a href="index.php">Anasayfa</a>
    <a href="ilaclar.php">İlaçlar</a>
    <a href="musteriler.php">Müşteriler</a>
    <a href="logout.php">Çıkış Yap</a>
  </nav>

  <form method="post">
    <label for="musteri_adi">Müşteri Adı ve Soyadı:</label>
    <input type="text" name="musteri_adi" id="musteri_adi" placeholder="Örn: Ahmet Yılmaz" required><br><br>

    <label for="ilac_id">İlaç:</label>
    <select name="ilac_id" id="ilac_id" required>
      <?php foreach ($ilaclar as $ilac): ?>
        <option value="<?= $ilac['ilac_id'] ?>"><?= htmlspecialchars($ilac['ilac_adi']) ?> (stok: <?= $ilac['stok'] ?>)</option>
      <?php endforeach; ?>
    </select><br><br>

    <label for="miktar">Miktar:</label>
    <input type="number" name="miktar" id="miktar" required min="1"><br><br>

    <input type="submit" value="Kaydı Ekle">
  </form>

  <h2>Satın Alma Kayıtları</h2>
  <table>
    <tr>
      <th>Müşteri</th>
      <th>İlaç</th>
      <th>Miktar</th>
      <th>Tarih</th>
    </tr>
    <?php foreach ($kaydlar as $kayit): ?>
      <tr>
        <td><?= htmlspecialchars($kayit['ad'] . ' ' . $kayit['soyad']) ?></td>
        <td><?= htmlspecialchars($kayit['ilac_adi']) ?></td>
        <td><?= htmlspecialchars($kayit['miktar']) ?></td>
        <td><?= htmlspecialchars($kayit['tarih']) ?></td>
      </tr>
    <?php endforeach; ?>
  </table>
</body>
</html>
