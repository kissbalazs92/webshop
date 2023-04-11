<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = $_POST['product_id'];
    $productName = $_POST['name'];
    $stock = $_POST['stock'];
    $grossPrice = $_POST['gross_price'];
    $netPrice = $_POST['net_price'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $subcategories = $_POST['subcategory'];
    $sale_price = $_POST['sale_price'];

    $sql = "UPDATE products SET name = ?, stock = ?, gross_price = ?, net_price = ?, description = ?, category_id = ?, sale_price = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$productName, $stock, $grossPrice, $netPrice, $description, $category, $sale_price, $productId]);

    $sql = "DELETE FROM product_subcategories WHERE product_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$productId]);

    foreach ($subcategories as $subcategory_id) {
        $sql = "INSERT INTO product_subcategories (product_id, subcategory_id) VALUES (?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$productId, $subcategory_id]);
    }

    header('Location: /admin_dashboard.php');
}

$productId = $_GET['id'];
$sql = "SELECT * FROM products WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$productId]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

$sql = "SELECT subcategory_id FROM product_subcategories WHERE product_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$productId]);
$selectedSubcategories = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

$sql = "SELECT id, name FROM categories";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$categories = $stmt->fetchAll();

$sql = "SELECT id, name FROM subcategories";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$subcategories = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
</head>
<body>
    <h1>Edit Product</h1>
    <form action="edit_product.php" method="post">
        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">

        <label for="name">Product Name:</label>
        <input type="text" name="name" id="name" value="<?php echo $product['name']; ?>" required><br>

        <label for="stock">Stock:</label>
        <input type="number" name="stock" id="stock" value="<?php echo $product['stock']; ?>" required><br>

        <label for="gross_price">Gross Price:</label>
        <input type="number" step="0.01" min="0" name="gross_price" id="gross_price" value="<?php echo $product['gross_price']; ?>" required><br>

        <label for="net_price">Net Price:</label>
        <input type="number" step="0.01" min="0" name="net_price" id="net_price" value="<?php echo $product['net_price']; ?>" required><br>

        <label for="description">Description:</label>
        <textarea name="description" id="description" required><?php echo $product['description']; ?></textarea><br>

        <label for="sale_price">Sale Price (optional):</label>
        <input type="number" step="0.01" min="0" name="sale_price" id="sale_price" value="<?php echo $product['sale_price']; ?>"><br>

        <label for="category">Category:</label>
        <select name="category" id="category" required>
            <?php
            foreach ($categories as $category) {
                $selected = $product['category_id'] == $category['id'] ? "selected" : "";
                echo "<option value='" . $category['id'] . "' $selected>" . $category['name'] . "</option>";
            }
            ?>
        </select><br>

        <label for="subcategory">Subcategory:</label>
        <select name="subcategory[]" id="subcategory" multiple required>
            <?php
            foreach ($subcategories as $subcategory) {
                $selected = in_array($subcategory['id'], $selectedSubcategories) ? "selected" : "";
                echo "<option value='" . $subcategory['id'] . "' $selected>" . $subcategory['name'] . "</option>";
            }
            ?>
        </select><br>

        <input type="submit" value="Update Product">
    </form>
</body>
</html>
