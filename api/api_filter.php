<?php
declare(strict_types=1);

require_once (__DIR__ . '/../util/session.php');
$session = new Session();

require_once (__DIR__ . '/../database/connection.db.php');
require_once (__DIR__ . '/../database/shop.class.php');


$db = getDatabaseConnection();

// Retrieve and sanitize filters from GET parameters
$category = $_GET['category'] ?? null;
$brand = $_GET['brand'] ?? null;
$model = $_GET['model'] ?? null;
$size = $_GET['size'] ?? null;
$condition = $_GET['condition'] ?? null;
$minPrice = $_GET['min_price'] ?? null;
$maxPrice = $_GET['max_price'] ?? null;

// Call the filterItems method from the Shop class to filter items
$filteredItems = Shop::filterItems($db, $category, $brand, $model, $size, $condition, $minPrice, $maxPrice);

// Output the filtered items as JSON
header('Content-Type: application/json');
echo json_encode($filteredItems);
?>