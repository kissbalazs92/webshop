<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['edit_product'])) {
        $productId = $_POST['product_id'];
        header('Location: /edit_product.php?id=' . $productId);
    } elseif (isset($_POST['delete_product'])) {
        $productId = $_POST['product_id'];

        $sql = "DELETE FROM product_subcategories WHERE product_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$productId]);

        $sql = "DELETE FROM images WHERE product_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$productId]);

        $sql = "DELETE FROM products WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$productId]);
    }
}

if (isset($_POST['edit_images'])) {
    $productId = $_POST['product_id'];
    header('Location: /edit_images.php?id=' . $productId);
}

$sql = "SELECT p.*, c.name as category_name, s.name as subcategory_name
        FROM products p
        LEFT JOIN categories c ON p.category_id = c.id
        LEFT JOIN product_subcategories ps ON p.id = ps.product_id
        LEFT JOIN subcategories s ON ps.subcategory_id = s.id";
$stmt = $pdo->query($sql);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($products as &$product) {
    $product_id = $product['id'];
    $sql = "SELECT file_path FROM images WHERE product_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$product_id]);
    $product['images'] = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

    $sql = "SELECT AVG(rating) as avg_rating, COUNT(*) as review_count
            FROM reviews WHERE product_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$product_id]);
    $review_data = $stmt->fetch(PDO::FETCH_ASSOC);
    $product['avg_rating'] = $review_data['avg_rating'];
    $product['review_count'] = $review_data['review_count'];
}
unset($product);
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
                <!--<th>Gross Price</th
                <th>Net Price</th>
                <th>Description</th>
                <th>Rating</th>
                <th>Reviews</th>
                <th>Sale Price</th>
                <th>Images</th>-->
                <th>Category</th>
                <!--<th>Subcategory</th>-->
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?php echo $product['id']; ?></td>
                    <td><?php echo $product['name']; ?></td>
                    <td><?php echo $product['stock']; ?></td>
                    <!--<td><//?php echo $product['gross_price']; ?></td>
                    <td><//?php echo $product['net_price']; ?></td>
                    <td><//?php echo $product['description']; ?></td>
                    <td><//?php echo round($product['avg_rating'], 1); ?></td>
                    <td><//?php echo $product['review_count']; ?></td>
                    <td><//?php echo $product['sale_price']; ?></td>
                    <td>
                        <//?php foreach ($product['images'] as $image_path): ?>
                            <img src="<//?php echo $image_path; ?>" width="100" height="100">
                        <//?php endforeach; ?>
                    </td>-->
                    <td><?php echo $product['category_name']; ?></td>
                    <!--<td><//?php echo $product['subcategory_name']; ?></td>-->
                    <td>
                        <form action="edit_delete_products.php" method="post">
                            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                            <input type="submit" name="edit_product" value="Edit">
                            <input type="submit" name="delete_product" value="Delete" onclick="return confirm('Are you sure you want to delete this product?');">
                            <input type="submit" name="edit_images" value="Edit Images">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>

