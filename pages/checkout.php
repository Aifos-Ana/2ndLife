<?php
declare(strict_types=1);

require_once (__DIR__ . '/../util/session.php');
$session = new Session();

require_once (__DIR__ . '/../database/connection.db.php');
require_once (__DIR__ . '/../database/user.class.php');
require_once (__DIR__ . '/../database/cart.class.php');

require_once (__DIR__ . '/../templates/common.tpl.php');
require_once (__DIR__ . '/../templates/checkout.tpl.php');

$db = getDatabaseConnection();
$css = '../css/checkout.css';

$cart = Cart::getCartByUserId($db, $session->getId());

draw_header($session, $css);
draw_checkout($cart, $db);
draw_footer();
?>