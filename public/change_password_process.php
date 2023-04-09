<?php
session_start();
require_once 'config.php';

$user_id = $_SESSION['user_id'];
$old_password = $_POST['old_password'];
$new_password = $_POST['new_password'];
$confirm_new_password = $_POST['confirm_new_password'];

$sql = "SELECT password FROM users WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(1, $user_id);
$stmt->execute();
$result = $stmt->fetchAll();
$user = $result[0] ?? null;

if ($user && password_verify($old_password, $user['password'])) {
    if ($new_password == $confirm_new_password) {
        $new_password_hashed = password_hash($new_password, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET password = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(1, $new_password_hashed);
        $stmt->bindParam(2, $user_id);

        if ($stmt->execute()) {
            $_SESSION['success_message'] = "A jelszó sikeresen megváltozott!";
            header('Location: /');
        } else {
            $_SESSION['error_message'] = "Hiba történt a jelszó megváltoztatása során. Kérjük, próbálja újra.";
            header('Location: /change_password.php');
        }
    } else {
        $_SESSION['error_message'] = "Az új jelszavak nem egyeznek. Kérjük, próbálja újra.";
        header('Location: /change_password.php');
    }
} else {
    $_SESSION['error_message'] = "A régi jelszó nem megfelelő. Kérjük, próbálja újra.";
    header('Location: /change_password.php');
}
?>

