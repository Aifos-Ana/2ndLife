<?php
declare(strict_types=1);

require_once (__DIR__ . '/../util/session.php');
$session = new Session();

require_once (__DIR__ . '/../database/connection.db.php');
require_once (__DIR__ . '/../database/user.class.php');

$db = getDatabaseConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];

    $user_id = $session->getId();

    $session->setName($name);
    $session->setEmail($email);

    // Check if an image is uploaded and if it was fully uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK && is_uploaded_file($_FILES['image']['tmp_name'])) {
        // File uploaded successfully
        $tempFileName = $_FILES['image']['tmp_name'];

        // Save the uploaded image
        $uploadDirectory = __DIR__ . '/../img/';

        // Generate a unique filename for the uploaded image
        $imageName = uniqid('user_') . '.png';
        $imageUrl = $uploadDirectory . $imageName;

        if (move_uploaded_file($tempFileName, $imageUrl)) {
            // Image uploaded successfully
            $imageUrl = '../img/' . $imageName;
        }
        // Update the user's profile picture in the database
        $success = User::updateProfilePicture($db, $user_id, $imageUrl);

        if (!$success) {
            echo "Failed to update profile picture";
        }
    }

    echo "Profile updated successfully";
} else {
    echo "Invalid request method";
}
?>