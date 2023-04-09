<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['edit_product'])) {
        $productId = $_POST['product_id'];
        header('Location: /edit_product.php?id=' . $productId);
    } elseif (isset($_POST['delete_product'])) {
        $productId = $_POST['product_id'];
        $sql = "DELETE FROM products WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$productId]);
    }
}

$sql = "SELECT * FROM products";
$stmt = $pdo->query($sql);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit/Delete Products</title>
</head>
<body>
    <h1>Edit/Delete Products</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Product Name</th>
                <th>Stock</th>
                <th>Gross Price</th>
                <th>Net Price</th>
                <th>Description</th>
                <th>Rating</th>
                <th>Reviews</th>
                <th>Sale Price</th>
                <th>Image</th>
                <th>Category</th>
                <th>Subcategory</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?php echo $product['id']; ?></td>
                    <td><?php echo $product['product_name']; ?></td>
                    <td><?php echo $product['stock']; ?></td>
                    <td><?php echo $product['gross_price']; ?></td>
                    <td><?php echo $product['net_price']; ?></td>
                    <td><?php echo $product['description']; ?></td>
                    <td><?php echo $product['rating']; ?></td>
                    <td><?php echo $product['reviews']; ?></td>
                    <td><?php echo $product['sale_price']; ?></td>
                    <td><img src="<?php echo $product['image_path']; ?>" width="100" height="100"></td>
                    <td><?php echo $product['category']; ?></td>
                    <td><?php echo $product['subcategory']; ?></td>
                    <td>
                        <form action="edit_delete_products.php" method="post">
                            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                            <input type="submit" name="edit_product" value="Edit">
                            <input type="submit" name="delete_product" value="Delete" onclick="return confirm('Are you sure you want to delete this product?');">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
