<?php
session_start();
require_once 'config.php';

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT id, username, password FROM users WHERE username = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['password'])) {
    $_SESSION['username'] = $user['username'];
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['success_message'] = "Sikeres bejelentkezés!";
    header('Location: /');
    exit(); // Hozzáadva, hogy azonnal kilépjen a fájl végrehajtásából
} else {
    $_SESSION['error_message'] = "A felhasználónév vagy jelszó nem megfelelő.";
    header('Location: /login.php');
    exit(); // Hozzáadva, hogy azonnal kilépjen a fájl végrehajtásából
}
$stmt->close();
$pdo = null;
?>
