<?php
session_start();
require_once 'config.php';

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT id, username, password, is_admin FROM users WHERE username = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['password'])) {
    if ($user['is_admin']) {
        $_SESSION['username'] = $user['username'];
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['is_admin'] = true;
        $_SESSION['success_message'] = "Sikeres bejelentkezés!";
        header('Location: /admin_dashboard.php');
    } else {
        $_SESSION['error_message'] = "Ehhez az oldalhoz csak adminisztrátorok férhetnek hozzá.";
        header('Location: /login.php');
    }
} else {
    $_SESSION['error_message'] = "A felhasználónév vagy jelszó nem megfelelő.";
    header('Location: /admin.php');
}
$stmt->close();
$pdo = null;
?>
