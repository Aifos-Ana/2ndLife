<?php
declare(strict_types=1);

require_once ('../util/session.php');
$session = new Session();

require_once (__DIR__ . '/../database/connection.db.php');
require_once (__DIR__ . '/../database/user.class.php');
require_once (__DIR__ . '/../templates/common.tpl.php');
require_once (__DIR__ . '/../templates/homepage.tpl.php');

$db = getDatabaseConnection();

$session->logout();

header('Location: ..');

?>