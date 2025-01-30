<?php
class Session
{
    private array $messages;

    public function __construct()
    {
        session_start();

        $this->messages = isset($_SESSION['messages']) ? $_SESSION['messages'] : array();
        unset($_SESSION['messages']);
    }

    public function isLoggedIn(): bool
    {
        return isset($_SESSION['email']);
    }

    public function logout()
    {
        session_destroy();
    }

    public function getId(): ?int
    {
        return isset($_SESSION['id']) ? $_SESSION['id'] : null;
    }

    public function getEmail(): ?string
    {
        return isset($_SESSION['email']) ? $_SESSION['email'] : null;
    }
    public function getName(): ?string
    {
        return isset($_SESSION['name']) ? $_SESSION['name'] : null;
    }

    public function setId(int $id)
    {
        $_SESSION['id'] = $id;
    }

    public function setName(string $name)
    {
        $_SESSION['name'] = $name;
    }

    public function setAdmin()
    {
        $_SESSION['is_Admin'] = true;
    }

    public function setSeller()
    {
        $_SESSION['is_Seller'] = true;
    }
    public function setBuyer()
    {
        $_SESSION['is_Buyer'] = true;
    }

    public function setEmail(string $email)
    {
        $_SESSION['email'] = $email;
    }

    public function setImageData($imageData)
    {
        $_SESSION['profile_image'] = $imageData;
    }

    public function getImage()
    {
        return isset($_SESSION['imageUrl']) ? $_SESSION['imageUrl'] : null;
    }


    public function addMessage(string $type, string $text)
    {
        $_SESSION['messages'][] = array('type' => $type, 'text' => $text);
    }

    public function getMessages()
    {
        return $this->messages;
    }

    public function generateToken()
    {
        if (!isset($_SESSION['csrf'])) {
            $_SESSION['csrf'] = bin2hex(openssl_random_pseudo_bytes(32));
        }
    }

    public function getUserRole()
    {
        return isset($_SESSION['user_role']) ? $_SESSION['user_role'] : null;
    }

    public function isAdmin()
    {
        return $this->getUserRole() === 'admin';
    }

    public function isSeller()
    {
        return $this->getUserRole() === 'seller';
    }

    public function isBuyer()
    {
        return $this->getUserRole() === 'normal';
    }

}
?>