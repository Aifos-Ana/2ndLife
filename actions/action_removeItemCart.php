<?php
declare(strict_types=1);

require_once (__DIR__ . '/../util/session.php');
$session = new Session();

require_once (__DIR__ . '/../database/connection.db.php');
require_once (__DIR__ . '/../database/cart.class.php');

$db = getDatabaseConnection();

if (isset($_POST['itemId'])) {
    $itemId = (int) $_POST['itemId'];
    $userId = $session->getId();

    // Remove the item from the cart
    $success = Cart::removeItem($db, $itemId, $userId);

    if ($success) {
        http_response_code(200);
        echo "Item removed successfully";
    } else {
        http_response_code(500);
        echo "Failed to remove item";
    }
} else {
    http_response_code(400);
    echo "Item ID not provided";
}
?>