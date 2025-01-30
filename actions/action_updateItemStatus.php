<?php
declare(strict_types=1);

require_once (__DIR__ . '/../util/session.php');
$session = new Session();

require_once (__DIR__ . '/../database/connection.db.php');
require_once (__DIR__ . '/../database/cart.class.php');

$db = getDatabaseConnection();

// Update the status of items in the cart for the current user
$userId = $session->getId();
$success = Cart::updateCartItemsStatus($db, $userId);

header('Location: ../index.php');

?>