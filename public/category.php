<?php
session_start();
require_once 'config.php';

$category_id = isset($_GET['category_id']) ? intval($_GET['category_id']) : 0;

$sql = "SELECT id, name FROM categories WHERE id = :category_id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
$stmt->execute();
$category = $stmt->fetch();

if (!$category) {
  header('Location: /');
  exit();
}

// Get subcategories for the selected category
$sql = "SELECT id, name FROM subcategories WHERE category_id = :category_id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
$stmt->execute();
$subcategories = $stmt->fetchAll();

// Get products for the selected category
$sql = "SELECT * FROM products WHERE category_id = :category_id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
$stmt->execute();
$products = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <?php include 'header.php'; ?>
  <title><?php echo $category['name']; ?></title>
</head>
<body>
  <h1><?php echo $category['name']; ?></h1>
  <?php if (count($subcategories) > 0): ?>
    <h2>Alkategóriák</h2>
    <ul>
      <?php foreach ($subcategories as $subcategory): ?>
        <li><a href="/category.php?subcategory_id=<?php echo $subcategory['id']; ?>"><?php echo $subcategory['name']; ?></a></li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>
  <?php if (count($products) > 0): ?>
    <h2>Termékek</h2>
    <div class="row">
      <?php foreach ($products as $product): ?>
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title"><?php echo $product['name']; ?></h5>
              <p class="card-text"><?php echo $product['description']; ?></p>
              <a href="/product.php?product_id=<?php echo $product['id']; ?>" class="btn btn-primary">Részletek</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</body>
</html>
