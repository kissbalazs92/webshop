<?php
ob_start();
require_once 'config.php';

function generateUniqueFileName($extension) {
    do {
        $fileName = time() . '_' . uniqid() . '.' . $extension;
    } while (file_exists('uploads/' . $fileName));

    return $fileName;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productName = $_POST['name'];
    $stock = $_POST['stock'];
    $grossPrice = $_POST['gross_price'];
    $netPrice = $_POST['net_price'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $subcategories = $_POST['subcategories'] ?? [];
    $sale_price = $_POST['sale_price'];

    if (empty($productName)) {
        echo "Error: Product name cannot be empty.";
        exit();
    }

    // Fájlok feltöltése és adatbázisba mentése
    $uploadedFiles = [];
    foreach ($_FILES['product_images']['name'] as $index => $filename) {
        if ($_FILES['product_images']['error'][$index] > 0) {
            // ... A kód többi része változatlan ...
        } else {
            $targetDir = "uploads/";
            $fileExtension = pathinfo($filename, PATHINFO_EXTENSION);
            $uniqueFileName = generateUniqueFileName($fileExtension);
            $targetFile = $targetDir . $uniqueFileName;
            move_uploaded_file($_FILES['product_images']['tmp_name'][$index], $targetFile);
            $uploadedFiles[] = $targetFile;
        }
    }

    $sql = "INSERT INTO products (name, stock, gross_price, net_price, description, category_id, sale_price) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$productName, $stock,     $grossPrice, $netPrice, $description, $category, $sale_price]);

    $product_id = $pdo->lastInsertId();

    foreach ($uploadedFiles as $index => $filePath) {
        $sql = "INSERT INTO images (product_id, file_path, image_order) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$product_id, $filePath, $index]);
    }

    foreach ($subcategories as $subcategory_id) {
        $sql = "INSERT INTO product_subcategories (product_id, subcategory_id) VALUES (?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$product_id, $subcategory_id]);
    }

    header('Location: /admin_dashboard.php');
    ob_end_flush();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <script>
        function updateSubcategories() {
            const categorySelect = document.getElementById("category");
            const subcategorySelect = document.getElementById("subcategory");

            const categoryId = categorySelect.value;

            fetch(`get_subcategories.php?category_id=${categoryId}`)
                .then((response) => response.json())
                .then((subcategories) => {
                subcategorySelect.innerHTML = "";
                subcategories.forEach((subcategory) => {
                    const option = document.createElement("option");
                    option.value = subcategory.id;
                    option.text = subcategory.name;
                    subcategorySelect.appendChild(option);
                });
                })
                .catch((error) => {
                console.error("Error fetching subcategories:", error);
                });
            }

document.getElementById("category").addEventListener("change", updateSubcategories);

    </script>
</head>
<body>
    <h1>Add Product</h1>
    <form action="add_product.php" method="post" enctype="multipart/form-data">
    <label for="product_name">Product Name:</label>
        <input type="text" name="name" id="name" required><br>

        <label for="stock">Stock:</label>
        <input type="number" name="stock" id="stock" required><br>

        <label for="gross_price">Gross Price:</label>
        <input type="number" step="0.01" min="0" name="gross_price" id="gross_price" required><br>

        <label for="net_price">Net Price:</label>
        <input type="number" step="0.01" min="0" name="net_price" id="net_price" required><br>

        <label for="description">Description:</label>
        <textarea name="description" id="description" required></textarea><br>

        <label for="sale_price">Sale Price (optional):</label>
        <input type="number" step="0.01" min="0" name="sale_price" id="sale_price"><br>

        <label for="category">Category:</label>
        <select name="category" id="category" onchange="updateSubcategories()" required>
            <?php
            $sql = "SELECT id, name FROM categories";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $categories = $stmt->fetchAll();

            foreach ($categories as $category) {
                echo "<option value='" . $category['id'] . "'>" . $category['name'] . "</option>";
            }
            ?>
        </select><br>

        <label for="subcategory">Subcategory:</label>
        <select name="subcategories[]" id="subcategory" multiple required>
        </select><br>

        <label for="product_images">Product Images:</label>
        <input type="file" name="product_images[]" id="product_images" multiple required><br>

        <input type="submit" value="Add Product">
    </form>
    <script>
        document.addEventListener("DOMContentLoaded", updateSubcategories);
    </script>
</body>
</html>

