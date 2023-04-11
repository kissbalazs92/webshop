<?php
require_once 'config.php';

$category_id = $_GET['category_id'];

$sql = "SELECT id, name FROM subcategories WHERE category_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$category_id]);
$subcategories = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($subcategories);
