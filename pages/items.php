<?php
declare(strict_types=1);

require_once (__DIR__ . '/../util/session.php');
$session = new Session();

require_once (__DIR__ . '/../database/connection.db.php');
require_once (__DIR__ . '/../database/shop.class.php');
require_once (__DIR__ . '/../database/user.class.php');
require_once (__DIR__ . '/../database/cart.class.php');

require_once (__DIR__ . '/../templates/common.tpl.php');
require_once (__DIR__ . '/../templates/item.tpl.php');

$db = getDatabaseConnection();
$css = '../css/item.css';

draw_header($session, $css);

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $itemId = intval($_GET['id']);
    $item = Shop::getItemById($db, $itemId);
    $seller = Shop::getSeller($db, $itemId);


    if ($item) {
        draw_item($item, $seller, $session);
    } else {
        echo "Item not found!";
    }

}
draw_footer();
?>