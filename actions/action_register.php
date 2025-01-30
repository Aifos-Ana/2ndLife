<?php
declare(strict_types=1);

require_once (__DIR__ . '/../util/session.php');
$session = new Session();

if ($session->isLoggedIn()) {
    $session->addMessage('error', 'You are already logged in');
}

require_once (__DIR__ . '/../database/connection.db.php');
require_once (__DIR__ . '/../database/user.class.php');
require_once (__DIR__ . '/../templates/register.tpl.php');

$db = getDatabaseConnection();

if (isset($_POST['user-type'])) {
    $isAdmin = $_POST['user-type'];
}

$name = $_POST['name_reg'];
$user = $_POST['username_reg'];
$email = $_POST['email_reg'];
$password = $_POST['password_reg'];

User::createUser($db, $email, $password, $name, $user);

$userLogged = User::getUserWithPassword($db, $email, $password);

//$id = $db->lastInsertId();

/*if ($userLogged->is_Admin) {
    $session->setAdmin();
} else {
    $session->setSeller();
}*/

if (isset($userLogged)) {
    $session->setEmail($userLogged->email);
    $session->setName($userLogged->name);
    $session->setId($userLogged->id);
    $session->addMessage('success', 'Register successful!');
    header('Location: ../index.php');
} else {
    $session->addMessage('error', 'Invalid username or email');
    header('Location: ../pages/register.php');
}
?>