<?php
// Statik giriş bilgileri (şifre veritabanından alınmıyor)
$dogru_kullanici = "admin";
$dogru_sifre = "1234";

session_start();

if ($_POST['username'] === $dogru_kullanici && $_POST['password'] === $dogru_sifre) {
    $_SESSION['admin'] = true;
    header("Location: index.php"); // index.html değil, PHP sürümüne yönlendireceğiz
    exit();
} else {
    echo "<p>Hatalı kullanıcı adı veya şifre. <a href='login.html'>Tekrar dene</a></p>";
}
?>