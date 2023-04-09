<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productName = $_POST['product_name'];
    $stock = $_POST['stock'];
    $grossPrice = $_POST['gross_price'];
    $netPrice = $_POST['net_price'];
    $description = $_POST['description'];
    $rating = $_POST['rating'];
    $reviews = $_POST['reviews'];
    $salePrice = $_POST['sale_price'];
    $category = $_POST['category'];
    $subcategory = $_POST['subcategory'];

    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($_FILES["product_image"]["name"]);
    move_uploaded_file($_FILES["product_image"]["tmp_name"], $targetFile);

    $sql = "INSERT INTO products (product_name, stock, gross_price, net_price, description, rating, reviews, sale_price, image_path, category, subcategory) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$productName, $stock, $grossPrice, $netPrice, $description, $rating, $reviews, $salePrice, $targetFile, $category, $subcategory]);

    header('Location: /admin_dashboard.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
</head>
<body>
    <h1>Add Product</h1>
    <form action="add_product.php" method="post" enctype="multipart/form-data">
        <label for="product_name">Product Name:</label>
        <input type="text" name="product_name" id="product_name" required><br>

        <label for="stock">Stock:</label>
        <input type="number" name="stock" id="stock" required><br>

        <label for="gross_price">Gross Price:</label>
        <input type="number" name="gross_price" id="gross_price" required><br>

        <label for="net_price">Net Price:</label>
        <input type="number" name="net_price" id="net_price" required><br>

        <label for="description">Description:</label>
        <textarea name="description" id="description" required></textarea><br>

        <label for="rating">Rating:</label>
        <input type="number" name="rating" id="rating" required><br>

        <label for="reviews">Reviews:</label>
        <textarea name="reviews" id="reviews"></textarea><br>

        <label for="sale_price">Sale Price (optional):</label>
        <input type="number" name="sale_price" id="sale_price"><br>

        <label for="category">Category:</label>
        <input type="text" name="category" id="category" required><br>

        <label for="subcategory">Subcategory:</label>
        <input type="text" name="subcategory" id="subcategory" required><br>

        <label for="product_image">Product Image:</label>
        <input type="file" name="product_image" id="product_image" required><br>

        <input type="submit" value="Add Product">
    </form>
</body>
</html
