<?php
$host = 'localhost';
$db = 'eczane';
$user = 'root'; // XAMPP varsayılanı
$pass = '';     // şifre boş olabilir

try {
    $conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Veritabanı bağlantısı başarısız: " . $e->getMessage());
}
?>