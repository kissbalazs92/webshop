<?php
session_start();
require_once 'config.php';

$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$address = $_POST['address'];

// Check if username or email already exists
$check_sql = "SELECT id FROM users WHERE username = ? OR email = ?";
$check_stmt = $pdo->prepare($check_sql);
$check_stmt->execute([$username, $email]);
if ($check_stmt->fetchColumn()) {
    $_SESSION['error_message'] = "A felhasználónév vagy e-mail cím már létezik.";
    header('Location: /registration.php');
    exit;
}

$sql = "INSERT INTO users (username, password, first_name, last_name, email, phone, address) VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $pdo->prepare($sql);
$result = $stmt->execute([$username, $password, $first_name, $last_name, $email, $phone, $address]);

if ($result) {
    $_SESSION['success_message'] = "Sikeres regisztráció!";
    header('Location: /login.php');
} else {
    $_SESSION['error_message'] = "Hiba történt a regisztráció során. Kérjük, próbálja újra.";
    header('Location: /registration.php');
}
?>
