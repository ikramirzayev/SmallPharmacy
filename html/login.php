<?php
session_start();

require_once __DIR__ . '/../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ad = $_POST['ad'];
    $kullanici_adi = $_POST['kullanici_adi'];

    $stmt = $conn->prepare("SELECT * FROM admin WHERE ad = ? AND kullanici_adi = ?");
    $stmt->execute([$ad, $kullanici_adi]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin) {
        $_SESSION['admin'] = true;
        header("Location: index.php");
        exit();
    } else {
        echo "<p>Hatalı ad veya kullanıcı adı. <a href='login.html'>Tekrar deneyin</a></p>";
    }
} else {
    header("Location: login.html");
    exit();
}
