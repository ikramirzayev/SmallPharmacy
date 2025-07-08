<?php
$host = 'localhost';
$db = 'eczane_db';
$user = 'root';
$pass = 'WJ28@krhps'; // XAMPP için genellikle boş bırakılır

try {
    $conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Veritabanı bağlantı hatası: " . $e->getMessage());
}
?>