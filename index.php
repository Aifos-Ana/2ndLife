<?php
declare(strict_types=1);

require_once (__DIR__ . '/util/session.php');
$session = new Session();

require_once (__DIR__ . '/database/connection.db.php');
require_once (__DIR__ . '/database/shop.class.php');

require_once (__DIR__ . '/templates/common.tpl.php');
require_once (__DIR__ . '/templates/homepage.tpl.php');

$db = getDatabaseConnection();
$css = '../css/homepage.css';

$items = Shop::getItems($db);
draw_header($session, $css);
drawItems($items, $db);
drawFilters($items);
draw_footer();
?>