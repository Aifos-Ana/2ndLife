<?php
declare(strict_types=1);

require_once (__DIR__ . '/../util/session.php');
$session = new Session();

require_once (__DIR__ . '/../database/connection.db.php');
require_once (__DIR__ . '/../database/shop.class.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userId = $session->getId();
    $category = $_POST['category'] ?? '';
    $brand = $_POST['brand'] ?? '';
    $model = $_POST['model'] ?? '';
    $size = $_POST['size'] ?? '';
    $condition = $_POST['condition'] ?? '';
    $description = $_POST['description'] ?? '';
    $price = floatval($_POST['price'] ?? 0.0);
    $imageUrl = '';

    // Check if an image is uploaded and if it was fully uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK && is_uploaded_file($_FILES['image']['tmp_name'])) {
        // File uploaded successfully
        $tempFileName = $_FILES['image']['tmp_name'];

        // Save the uploaded image
        $uploadDirectory = __DIR__ . '/../img/';

        // Generate a unique filename for the uploaded image
        $imageName = uniqid('item_') . '.png';
        $imageUrl = $uploadDirectory . $imageName;

        // Move the uploaded file to the destination directory
        if (move_uploaded_file($tempFileName, $imageUrl)) {
            // Image uploaded successfully
            $imageUrl = '../img/' . $imageName;
        }
    }

    if ($userId && $category && $brand && $model && $size && $condition && $description && $price && $imageUrl) {
        $db = getDatabaseConnection();
        $itemId = Shop::addItem(
            $db,
            $userId,
            $category,
            $brand,
            $model,
            $size,
            $condition,
            $description,
            $price,
            $imageUrl
        );

        if ($itemId) {
            header('Location: ../index.php');
            exit();
        }
    }
}
?>