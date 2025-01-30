<?php
declare(strict_types=1);

require_once (__DIR__ . '/../util/session.php');
$session = new Session();

require_once (__DIR__ . '/../database/connection.db.php');
require_once (__DIR__ . '/../database/shop.class.php');

$db = getDatabaseConnection();

$items = Shop::searchItems($db, $_GET['search']);

echo json_encode($items);
?>