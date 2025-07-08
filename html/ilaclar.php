<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.html");
    exit();
}

require_once __DIR__ . '/../config.php';

// İlac ekleme
if (isset($_POST['ekle'])) {
    $ad = $_POST['ilac_adi'];
    $firma = $_POST['firma'];
    $fiyat = $_POST['fiyat'];
    $stok = $_POST['stok'];

    $stmt = $conn->prepare("INSERT INTO ilac (ilac_adi, firma, fiyat, stok) VALUES (?, ?, ?, ?)");
    $stmt->execute([$ad, $firma, $fiyat, $stok]);
    header("Location: ilaclar.php");
    exit();
}

// İlac silme
if (isset($_GET['sil'])) {
    $id = $_GET['sil'];
    $stmt = $conn->prepare("DELETE FROM ilac WHERE ilac_id = ?");
    $stmt->execute([$id]);
    header("Location: ilaclar.php");
    exit();
}

// İlac güncelleme formu gösterme ve işlem
if (isset($_POST['guncelle'])) {
    $id = $_POST['ilac_id'];
    $ad = $_POST['ilac_adi'];
    $firma = $_POST['firma'];
    $fiyat = $_POST['fiyat'];
    $stok = $_POST['stok'];

    $stmt = $conn->prepare("UPDATE ilac SET ilac_adi = ?, firma = ?, fiyat = ?, stok = ? WHERE ilac_id = ?");
    $stmt->execute([$ad, $firma, $fiyat, $stok, $id]);
    header("Location: ilaclar.php");
    exit();
}

// Güncelleme için ilacı getir
$duzenle_ilac = null;
if (isset($_GET['duzenle'])) {
    $id = $_GET['duzenle'];
    $stmt = $conn->prepare("SELECT * FROM ilac WHERE ilac_id = ?");
    $stmt->execute([$id]);
    $duzenle_ilac = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Tüm ilaçları çek
$ilaclar = $conn->query("SELECT * FROM ilac ORDER BY ilac_adi ASC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8" />
  <title>İlaçlar Yönetimi</title>
  <link rel="stylesheet" href="../styles/style.css" />
</head>
<body>
  <h1>İlaçlar Yönetimi</h1>

  <nav>
    <a href="index.php">Anasayfa</a>
    <a href="satin_alma.php">Satın Alma</a>
    <a href="musteriler.php">Müşteriler</a>
    <a href="logout.php">Çıkış Yap</a>
  </nav>

  <?php if ($duzenle_ilac): ?>
    <h2>İlaç Güncelle</h2>
    <form method="post">
      <input type="hidden" name="ilac_id" value="<?= $duzenle_ilac['ilac_id'] ?>">
      <label for="ilac_adi">İlaç Adı:</label>
      <input type="text" name="ilac_adi" id="ilac_adi" value="<?= htmlspecialchars($duzenle_ilac['ilac_adi']) ?>" required><br><br>

      <label for="firma">Firma:</label>
      <input type="text" name="firma" id="firma" value="<?= htmlspecialchars($duzenle_ilac['firma']) ?>" required><br><br>

      <label for="fiyat">Fiyat:</label>
      <input type="number" step="0.01" name="fiyat" id="fiyat" value="<?= htmlspecialchars($duzenle_ilac['fiyat']) ?>" required><br><br>

      <label for="stok">Stok:</label>
      <input type="number" name="stok" id="stok" value="<?= htmlspecialchars($duzenle_ilac['stok']) ?>" required><br><br>

      <input type="submit" name="guncelle" value="Güncelle">
      <a href="ilaclar.php">İptal</a>
    </form>
  <?php else: ?>
    <h2>Yeni İlaç Ekle</h2>
    <form method="post">
      <label for="ilac_adi">İlaç Adı:</label>
      <input type="text" name="ilac_adi" id="ilac_adi" required><br><br>

      <label for="firma">Firma:</label>
      <input type="text" name="firma" id="firma" required><br><br>

      <label for="fiyat">Fiyat:</label>
      <input type="number" step="0.01" name="fiyat" id="fiyat" required><br><br>

      <label for="stok">Stok:</label>
      <input type="number" name="stok" id="stok" required><br><br>

      <input type="submit" name="ekle" value="Ekle">
    </form>
  <?php endif; ?>

  <h2>İlaç Listesi</h2>
  <table>
    <tr>
      <th>İlaç Adı</th>
      <th>Firma</th>
      <th>Fiyat</th>
      <th>Stok</th>
      <th>İşlemler</th>
    </tr>
    <?php foreach ($ilaclar as $ilac): ?>
      <tr>
        <td><?= htmlspecialchars($ilac['ilac_adi']) ?></td>
        <td><?= htmlspecialchars($ilac['firma']) ?></td>
        <td><?= htmlspecialchars($ilac['fiyat']) ?> TL</td>
        <td><?= htmlspecialchars($ilac['stok']) ?></td>
        <td>
          <a href="ilaclar.php?duzenle=<?= $ilac['ilac_id'] ?>">Düzenle</a> |
          <a href="ilaclar.php?sil=<?= $ilac['ilac_id'] ?>" onclick="return confirm('Silmek istediğinizden emin misiniz?');">Sil</a>
        </td>
      </tr>
    <?php endforeach; ?>
  </table>
</body>
</html>
