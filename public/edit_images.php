<?php
require_once 'config.php';

$productId = $_GET['id'];

function generateUniqueFileName($fileName) {
    $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
    $uniqueName = time() . '_' . uniqid() . '.' . $fileExtension;
    return $uniqueName;
}

function uploadImage($image, $productId, $pdo) {
    $uniqueName = generateUniqueFileName($image['name']);
    $targetDir = "uploads/";
    $targetFile = $targetDir . $uniqueName;
    if (move_uploaded_file($image['tmp_name'], $targetFile)) {
        $currentMaxOrderQuery = "SELECT MAX(image_order) as max_order FROM images WHERE product_id = ?";
        $stmt = $pdo->prepare($currentMaxOrderQuery);
        $stmt->execute([$productId]);
        $maxOrder = $stmt->fetch(PDO::FETCH_ASSOC);
        $newImageOrder = is_null($maxOrder['max_order']) ? 1 : $maxOrder['max_order'] + 1;
        
        $sql = "INSERT INTO images (product_id, file_path, image_order) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$productId, $targetFile, $newImageOrder]);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_image'])) {
        $imageId = $_POST['image_id'];
        $sql = "DELETE FROM images WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$imageId]);
        header('Location: /edit_images.php?id=' . $productId);
    } elseif (isset($_POST['save_image_order'])) {
        foreach ($_POST['image_order'] as $imageId => $imageOrder) {
            $sql = "UPDATE images SET image_order = ? WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$imageOrder, $imageId]);
        }
        header('Location: /edit_images.php?id=' . $productId);
    } elseif (isset($_FILES['new_images'])) {
        foreach ($_FILES['new_images']['tmp_name'] as $index => $tmpName) {
            if ($_FILES['new_images']['error'][$index] === UPLOAD_ERR_OK) {
                $image = [
                    'name' => $_FILES['new_images']['name'][$index],
                    'tmp_name' => $_FILES['new_images']['tmp_name'][$index]
                ];
                uploadImage($image, $productId, $pdo);
            }
        }
        header('Location: /edit_images.php?id=' . $productId);
    }
}

$sql = "SELECT file_path, id, image_order FROM images WHERE product_id = ? ORDER BY image_order";
$stmt = $pdo->prepare($sql);
$stmt->execute([$productId]);
$images = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Images</title>
</head>
<body>
    <h1>Edit Images</h1>
    <form action="edit_images.php?id=<?php echo $productId; ?>" method="post" enctype="multipart/form-data">
        <?php foreach ($images as $image): ?>
            <div>
                <img src="<?php echo $image['file_path']; ?>" width="100" height="100">
                <label for="image_order_<?php echo $image['id']; ?>">Order:</label>
                <input type="number" name="image_order[<?php echo $image['id']; ?>]" id="image_order_<?php echo $image['id']; ?>" value="<?php echo $image['image_order']; ?>">
                <input type="hidden" name="image_id" value="<?php echo $image['id']; ?>">
                <input type="submit" name="delete_image" value="Delete">
            </div>
        <?php endforeach; ?>
        <input type="submit" name="save_image_order" value="Save Image Order">
        <br><br>
        <label for="new_images">Add new images:</label>
        <input type="file" name="new_images[]" id="new_images" multiple>
        <br>
        <input type="submit" value="Upload New Images">
    </form>
</body>
</html>
