<?php
session_start();
require_once 'config.php';

function getCategories($pdo) {
    $query = $pdo->query("SELECT * FROM categories");
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

function getSubcategories($categoryId, $pdo) {
    $query = $pdo->prepare("SELECT * FROM subcategories WHERE category_id = :categoryId");
    $query->execute([':categoryId' => $categoryId]);
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

function getMostPopularProduct($pdo) {
  $query = $pdo->query("SELECT p.*, i.file_path FROM products p JOIN images i ON i.product_id = p.id AND i.image_order = 1 ORDER BY sales_count DESC LIMIT 1");
  return $query->fetch(PDO::FETCH_ASSOC);
}

function getFirstProductImage($productId, $pdo) {
    $query = $pdo->prepare("SELECT * FROM images WHERE product_id = :productId ORDER BY image_order LIMIT 1");
    $query->execute([':productId' => $productId]);
    return $query->fetch(PDO::FETCH_ASSOC);
}

$categories = getCategories($pdo);
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <title>Webshop</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <scripts rc="js/messages.js"></script>
</head>
<body>
    <header>
    <div class="d-flex justify-content-end align-items-center">
        <?php if (!isset($_SESSION['user_id'])): ?>
            <a class="nav-link login-link" href="login.php">Bejelentkezés</a>
            <a class="nav-link register-link" href="register.php">Regisztráció</a>
        <?php else: ?>
          <div class="nav-item dropdown">
            <a class="nav-link dropdown-toggle profile-link" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?= $_SESSION['username'] ?>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="profile.php">Adataim</a>
                <a class="dropdown-item" href="addresses.php">Címeim</a>
                <a class="dropdown-item" href="previous_ordsers.php">Korábbi rendelések</a>
                <a class="dropdown-item" href="change_password.php">Jelszó megváltoztatása</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="logout.php">Kijelentkezés</a>
            </div>
          </div>
        <?php endif; ?>
        <a class="nav-link cart-link" href="cart.php">
            <i class="fas fa-shopping-cart"></i>
        </a>
    </div>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container">
                <a class="navbar-brand" href="#">Webshop</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="#">Főoldal</a>
                        </li>
                        <?php foreach ($categories as $category): ?>
                            <li class="nav-item category-menu-item">
                                <a class="nav-link" href="#"><?= $category['name'] ?></a>
                                <div class="category-dropdown">
                                    <?php $subcategories = getSubcategories($category['id'], $pdo); ?>
                                    <div class="subcategory-list">
                                        <?php foreach ($subcategories as $subcategory): ?>
                                            <a class="dropdown-item" href="#"><?= $subcategory['name'] ?></a>
                                        <?php endforeach; ?>
                                    </div>
                                    <div class="popular-product">
                                      <?php $popular_product = getMostPopularProduct($pdo); ?>
                                      <?php $popular_product_image = getFirstProductImage($popular_product['id'], $pdo) ?>
                                      <h5>Legnépszerűbb termék</h5>
                                      <div class="product-card">
                                          <img src="<?= $popular_product_image['file_path'] ?>" alt="<?= $popular_product['name'] ?>">
                                          <h6><?= $popular_product['name'] ?></h6>
                                          <p><?= number_format($popular_product['gross_price'], 0, ',', ' ') ?> Ft</p>
                                          <a href="#" class="btn btn-primary">Részletek</a>
                                      </div>
                                  </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <div class="d-flex justify-content-end">
                    <?php if (!isset($_SESSION['user_id'])): ?>
                        <a class="nav-link" href="login.php">Bejelentkezés</a>
                        <a class="nav-link" href="register.php">Regisztráció</a>
                    <?php else: ?>
                        <a class="nav-link" href="profile.php"><?= $_SESSION['first_name'] ?></a>
                    <?php endif; ?>
                    <a class="nav-link" href="cart.php">
                        <i class="fas fa-shopping-cart"></i>
                    </a>
                </div>
            </div>
        </nav>
    </header>
    <?php if (isset($_SESSION['success_message'])): ?>
    <div class="success-message">
        <?php echo $_SESSION['success_message']; ?>
    </div>
    <script data-script="remove-self">
        removeMessage();
    </script>
    <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

