<?php
declare(strict_types=1);

require_once (__DIR__ . '/../util/session.php');
$session = new Session();

require_once (__DIR__ . '/../database/connection.db.php');
require_once (__DIR__ . '/../database/shop.class.php');

$db = getDatabaseConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['item_id'])) {
    $itemId = (int) $_POST['item_id'];
    $brand = $_POST['brand'] ?? '';
    $model = $_POST['model'] ?? '';
    $price = (float) ($_POST['price'] ?? 0);
    $category = $_POST['category'] ?? '';
    $condition = $_POST['condition'] ?? '';
    $size = $_POST['size'] ?? '';
    $description = $_POST['description'] ?? '';
    $isActive = isset($_POST['is_active']) ? 1 : 0;

    // Check if an image is uploaded and if it was fully uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        // File uploaded successfully
        $tempFileName = $_FILES['image']['tmp_name'];
        $uploadDirectory = __DIR__ . '/../img/';
        $imageName = uniqid('item_') . '.png';
        $imageUrl = $uploadDirectory . $imageName;

        if (move_uploaded_file($tempFileName, $imageUrl)) {
            // Image uploaded successfully
            $imageUrl = '../img/' . $imageName;
            $success = Shop::updateItemPicture($db, $itemId, $imageUrl);

            if (!$success) {
                // Failed to update profile picture
                echo "Failed to update profile picture";
                exit;
            }
        } else {
            // Failed to move uploaded file
            echo "Failed to move uploaded file";
            exit;
        }
    }

    $success = Shop::editItem($db, $itemId, $category, $brand, $model, $size, $condition, $description, $price, $isActive);
    if ($success) {
        header('Location: ..');
    } else {
        echo "Failed to update item";
    }

} else {
    $_SESSION['message'] = 'Invalid request.';
    header('Location: ..');
}
?>