<?php
declare(strict_types=1);

require_once (__DIR__ . '/../util/session.php');
$session = new Session();

require_once (__DIR__ . '/../database/connection.db.php');
require_once (__DIR__ . '/../database/shop.class.php');

$db = getDatabaseConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['item_id'])) {
    $itemId = (int) $_POST['item_id'];

    if (Shop::deleteItem($db, $itemId)) {
        $_SESSION['message'] = 'Item deleted successfully.';
    } else {
        $_SESSION['message'] = 'Failed to delete the item.';
    }

    header('Location: ../pages/profile.php');
    exit;
} else {
    $_SESSION['message'] = 'Invalid request.';
    header('Location: ../pages/profile.php');
    exit;
}