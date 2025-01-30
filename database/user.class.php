<?php
declare(strict_types=1);

class User
{
    public int $id;
    public string $firstName;
    public string $lastName;
    public string $name;
    public string $username;
    public string $password;
    public string $email;
    public string $image_url;
    public bool $is_Seller;
    public bool $is_Admin;

    public function __construct(
        int $id,
        string $name,
        string $username,
        string $email,
        string $password,
        string $image_url,
        bool $is_Seller,
        bool $is_Admin
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->image_url = $image_url;
        $this->is_Admin = $is_Admin;
        $this->is_Seller = $is_Seller;
    }

    static function updateProfile(PDO $db, string $name, string $email, string $password)
    {
        $stmt = $db->prepare('
        UPDATE user SET name = ?, email = ?, password = ?
        WHERE id = ?
    ');

        $stmt->execute(array($name, $email, $password));
    }


    function updatePassword($db, $hash)
    {
        $stmt = $db->prepare('
        UPDATE user SET password = ?
        WHERE id = ?
     ');

        $stmt->execute(array($hash, $this->id));
    }

    static function getUserWithPassword(PDO $db, string $email, string $password): ?User
    {
        $stmt = $db->prepare('
        SELECT id, name, username, email, password, image_url, is_seller, is_admin
        FROM user 
        WHERE lower(email) = ? AND password = ?
      ');

        $stmt->execute(array(strtolower($email), $password));

        if ($User = $stmt->fetch()) {
            foreach ($User as $key => $value) {
                if (is_null($value)) {
                    $User[$key] = "";
                }
            }

            return new User(
                $User['id'],
                $User['name'],
                $User['username'],
                $User['email'],
                $User['password'],
                $User['image_url'],
                (boolean) $User['is_seller'],
                (boolean) $User['is_admin']
            );
        } else {
            return null;
        }
    }


    static function getUserWithID(PDO $db, int $id): User
    {
        $stmt = $db->prepare('
        SELECT id, name, username, email, password, image_url, is_seller, is_admin
        FROM user 
        WHERE id = ?
      ');

        $stmt->execute(array($id));
        $User = $stmt->fetch();

        return new User(
            $User['id'],
            $User['name'],
            $User['username'],
            $User['email'],
            $User['password'],
            $User['image_url'],
            (boolean) $User['is_seller'],
            (boolean) $User['is_admin']
        );
    }

    static function createUser(PDO $db, string $email, string $password, string $name, string $username): bool
    {
        $stmt = $db->prepare('
        INSERT INTO user(name, username, password, email) 
        VALUES(?, ?, ?, ?)'
        );

        $stmt->execute(array($name, $username, $password, $email));

        return true;
    }

    public function userType()
    {
        if ($this->is_Admin) {
            return "admin";
        } elseif ($this->is_Seller) {
            return "seller";
        } else {
            return "normal";
        }
    }

    static function getImageUrlById(PDO $db, int $userId): ?string
    {
        $stmt = $db->prepare('SELECT image_url FROM user WHERE id = ?');
        $stmt->execute([$userId]);

        $imageUrl = $stmt->fetchColumn();

        return $imageUrl ? $imageUrl : null;
    }

    public static function updateProfilePicture(PDO $db, int $userId, string $imageData): bool
    {
        try {
            // Prepare the SQL statement to update the profile picture
            $query = "UPDATE user SET image_url = :imageData WHERE id = :userId";
            $stmt = $db->prepare($query);

            // Bind parameters
            $stmt->bindParam(':imageData', $imageData, PDO::PARAM_LOB);
            $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);

            // Execute the statement
            $stmt->execute();

            // Check if any rows were affected (profile picture updated successfully)
            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false; // No rows were affected, indicating a failure to update
            }
        } catch (PDOException $e) {
            // Handle any database errors
            // You may want to log the error or handle it differently based on your application's requirements
            return false;
        }


    }

    public function elevateUserType(PDO $db, string $newUserType)
    {
        switch ($newUserType) {
            case 'admin':
                $this->is_Admin = true;
                $this->is_Seller = true;
                break;
            case 'seller':
                $this->is_Admin = false;
                $this->is_Seller = true;
                break;
            case 'normal':
            default:
                $this->is_Admin = false;
                $this->is_Seller = false;
                break;
        }

        $stmt = $db->prepare('UPDATE users SET is_Seller = ?, is_Admin = ? WHERE id = ?');
        return $stmt->execute([$this->is_Seller, $this->is_Admin, $this->id]);
    }

}
?>