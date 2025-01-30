<?php
declare(strict_types=1);

require_once (__DIR__ . '/../util/session.php');
$session = new Session();

require_once (__DIR__ . '/../database/connection.db.php');
require_once (__DIR__ . '/../database/shop.class.php');

require_once (__DIR__ . '/../templates/common.tpl.php');
require_once (__DIR__ . '/../templates/add_item.tpl.php');

$db = getDatabaseConnection();
$css = '../css/add_item.css';

draw_header($session, $css);
draw_addItemForm();
draw_footer();
?>