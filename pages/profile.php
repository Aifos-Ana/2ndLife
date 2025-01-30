<?php
declare(strict_types=1);

require_once (__DIR__ . '/../util/session.php');
$session = new Session();

require_once (__DIR__ . '/../database/connection.db.php');
require_once (__DIR__ . '/../database/user.class.php');
require_once (__DIR__ . '/../database/shop.class.php');

require_once (__DIR__ . '/../templates/common.tpl.php');
require_once (__DIR__ . '/../templates/profile.tpl.php');

$db = getDatabaseConnection();
$css = '../css/profile.css';

draw_header($session, $css);

if (isset($_GET['id'])) {
    $user_id = intval($_GET['id']);

    $users = User::getUserWithID($db, $user_id);
    $loggedInUser = ($users->id == $session->getId());
    $sellingItems = Shop::getItemsByUserId($db, $users->id);

    draw_profile($db, $session, $users, $sellingItems);
} else {
    $current_user_id = $session->getId();
    $current_user = User::getUserWithID($db, $current_user_id);

    if ($current_user_id == $current_user->id) {
        $sellingItems = Shop::getItemsByUserId($db, $current_user->id);

        draw_profileSelf($db, $session, $current_user, $sellingItems);

    }
}
draw_footer();
?>