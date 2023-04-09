<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'success_message.php';

if (!isset($_SESSION['username']) || !isset($_SESSION['user_id'])) {
    header('Location: admin.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+Knujsl5r6m3T6vo+0B+uHV6z8y1p0pG/768xRLX9+6g8Z" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/admin_dashboard.js" defer></script>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container">
        <h1>Admin Dashboard</h1>
        <nav>
            <ul>
                <li><a href="#" onclick="showAddProductForm()">Termék hozzáadása</a></li>
                <li><a href="#" onclick="showEditDeleteProducts()">Termék szerkesztése/törlése</a></li>
            </ul>
        </nav>

        <div id="add-product-form" style="display: none;">
            <?php include 'add_product.php'; ?>
        </div>

        <div id="edit-delete-products" style="display: none;">
            <?php include 'edit_delete_products.php'; ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha384-KyZXEAg3QhqLMpG8r+Knujsl5r6m3T6vo+0B+uHV6z8y1p0pG/768xRLX9+6g8Z" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-eMNCOe7tC1doHpGoJtKh7z7lGz7fuP4F8nfdFvAOA6Gg/z6Y5J6XqqyGXYM2ntX5" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js" integrity="sha384-cn7l7gDp0eyniUwwAZgrzD06kc/tftFf19TOAs2zVinnD/C7E91j9yyk5//jjpt/" crossorigin="anonymous"></script>
</body>
</html>
