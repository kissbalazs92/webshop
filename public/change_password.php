<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: /login.php');
    exit();
}
include 'header.php';
?>

<h1>Jelszó megváltoztatása</h1>
<form action="/change_password_process.php" method="post">
  <?php if (isset($_SESSION['error_message'])): ?>
      <div class="alert alert-danger">
          <?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
      </div>
  <?php endif; ?>
  <div class="form-group">
    <label for="old_password">Régi jelszó:</label>
    <input type="password" class="form-control" id="old_password" name="old_password" required>
  </div>
  <div class="form-group">
    <label for="new_password">Új jelszó:</label>
    <input type="password" class="form-control" id="new_password" name="new_password" required>
  </div>
  <div class="form-group">
    <label for="confirm_new_password">Új jelszó megerősítése:</label>
    <input type="password" class="form-control" id="confirm_new_password" name="confirm_new_password" required>
  </div>
  <button type="submit" class="btn btn-primary">Jelszó megváltoztatása</button>
</form>

