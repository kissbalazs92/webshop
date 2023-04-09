<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Webshop</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="css/style.css">
  <script src="js/messages.js"></script>
</head>
<body>
  <?php
    // A session-ök kiírása
    echo '<pre>';
    print_r($_SESSION);
    echo '</pre>';
  ?>
  <nav class="navbar navbar-expand-lg">
    <a class="navbar-brand" href="/">Főoldal</a>
    <?php if (!isset($_SESSION['username'])): ?>
      <div class="navbar-nav">
        <a class="nav-item nav-link" href="/login.php">Bejelentkezés</a>
        <a class="nav-item nav-link" href="/registration.php">Regisztráció</a>
      </div>
    <?php else: ?>
      <div class="navbar-nav">
        <div class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown">
            <?php echo $_SESSION['username']; ?>
          </a>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="#">Adataim</a>
            <a class="dropdown-item" href="#">Címeim</a>
            <a class="dropdown-item" href="#">Korábbi rendelések</a>
            <a class="dropdown-item" href="/change_password.php">Jelszó megváltoztatása</a>
            <a class="dropdown-item" href="/logout.php">Kijelentkezés</a>
          </div>
        </div>
      </div>
    <?php endif; ?>
  </nav>
  <?php if (isset($_SESSION['success_message'])): ?>
    <div class="success-message">
        <?php echo $_SESSION['success_message']; ?>
    </div>
    <script data-script="remove-self">
        removeMessage();
    </script>
    <?php unset($_SESSION['success_message']); ?>
  <?php endif; ?>
  <div class="container">
</body>
</html>