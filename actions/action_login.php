<?php
declare(strict_types=1);

require_once (__DIR__ . '/../util/session.php');
$session = new Session();

require_once (__DIR__ . '/../database/connection.db.php');
require_once (__DIR__ . '/../database/user.class.php');
require_once (__DIR__ . '/../templates/login.tpl.php');

$db = getDatabaseConnection();

$User = User::getUserWithPassword($db, $_POST['email_login'], $_POST['password_login']);

if (isset($User)) {
    $session->setId($User->id);
    $session->setEmail($User->email);
    $session->setName($User->name);
    $session->addMessage('success', 'Login successful!');
    if ($User->is_Admin)
        $session->setAdmin();
    else if ($User->is_Seller)
        $session->setSeller();
    else
        $session->setBuyer();
    header('Location: ..');
} else {
    $session->addMessage('error', 'Wrong password!');
    header('Location: ../pages/login.php');
}

header('Location: ' . $_SERVER['HTTP_REFERER']);
?>