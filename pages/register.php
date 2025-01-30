<?php
declare(strict_types=1);

require_once (__DIR__ . '/../util/session.php');
$session = new Session();

require_once (__DIR__ . '/../database/connection.db.php');
require_once (__DIR__ . '/../database/user.class.php');

require_once (__DIR__ . '/../templates/common.tpl.php');
require_once (__DIR__ . '/../templates/register.tpl.php');

$db = getDatabaseConnection();
$css = '../css/authentication.css';

draw_header($session, $css);
draw_mainPage();
draw_footer();
?>