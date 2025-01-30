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

    try {
        if (Cart::isItemInCart($db, $itemId, $userId)) {
            http_response_code(400);
            echo "Item is already in the cart";
        } else {
            $success = Cart::addItem($db, $itemId, $userId);

            if ($success) {
                http_response_code(200);
                echo "Item added to cart successfully";
            } else {
                http_response_code(500);
                echo "Failed to add item to cart";
            }
        }
    } catch (Exception $e) {
        error_log('Error adding item to cart: ' . $e->getMessage());
        http_response_code(500);
        echo "Failed to add item to cart";
    }
} else {
    http_response_code(400);
    echo "Item ID not provided";
}
?>