<?php
declare(strict_types=1);

class Shop
{
    public int $id;
    public int $usr_id;
    public string $category;
    public string $brand;
    public string $model;
    public string $size;
    public string $condition;
    public string $description;
    public float $price;
    public string $image_url;
    public int $is_active;

    public function __construct(
        int $id,
        int $user_id,
        string $category,
        string $brand,
        string $model,
        string $size,
        string $condition,
        string $description,
        float $price,
        string $image_url,
        int $is_active
    ) {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->category = $category;
        $this->brand = $brand;
        $this->model = $model;
        $this->size = $size;
        $this->condition = $condition;
        $this->description = $description;
        $this->price = $price;
        $this->image_url = $image_url;
        $this->is_active = $is_active;
    }

    static function getItems(PDO $db): array
    {
        $stmt = $db->prepare('SELECT * FROM items');
        $stmt->execute();

        $items = array();
        while ($item = $stmt->fetch()) {
            $items[] = new Shop(
                $item['id'],
                $item['user_id'],
                $item['category'],
                $item['brand'],
                $item['model'],
                $item['size'],
                $item['condition'],
                $item['description'],
                $item['price'],
                $item['image_url'],
                $item['is_active']
            );
        }
        return $items;
    }


    static function getSeller(PDO $db, int $itemId): ?User
    {
        $stmt = $db->prepare('SELECT user.* FROM user INNER JOIN items ON user.id = user_id WHERE items.id = ?');
        $stmt->execute([$itemId]);

        $sellerData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($sellerData) {
            return new User(
                $sellerData['id'],
                $sellerData['name'],
                $sellerData['username'],
                $sellerData['email'],
                $sellerData['password'],
                $sellerData['image_url'],
                (bool) $sellerData['is_seller'],
                (bool) $sellerData['is_admin']
            );
        } else {
            return null; // No seller found for the item
        }
    }

    static function getImageUrlById(PDO $db, int $itemId): ?string
    {
        $stmt = $db->prepare('SELECT image_url FROM items WHERE id = ?');
        $stmt->execute([$itemId]);

        $imageUrl = $stmt->fetchColumn();

        return $imageUrl ? $imageUrl : null;
    }

    static function isItemActive(PDO $db, int $itemId): bool
    {
        $stmt = $db->prepare('SELECT is_active FROM items WHERE id = ?');
        $stmt->execute([$itemId]);

        $isActive = $stmt->fetchColumn();

        return $isActive ? (bool) $isActive : false;
    }

    static function getItemById(PDO $db, int $itemId): ?Shop
    {
        $stmt = $db->prepare('SELECT * FROM items WHERE id = ?');
        $stmt->execute([$itemId]);

        $item = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$item) {
            return null;
        }

        return new Shop(
            $item['id'],
            $item['user_id'],
            $item['category'],
            $item['brand'],
            $item['model'],
            $item['size'],
            $item['condition'],
            $item['description'],
            $item['price'],
            $item['image_url'],
            $item['is_active']
        );
    }

    static function getItemsByUserId(PDO $db, int $userId): array
    {
        $stmt = $db->prepare('SELECT * FROM items WHERE user_id = ?');
        $stmt->execute([$userId]);

        $items = [];
        while ($item = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $items[] = new Shop(
                $item['id'],
                $item['user_id'],
                $item['category'],
                $item['brand'],
                $item['model'],
                $item['size'],
                $item['condition'],
                $item['description'],
                $item['price'],
                $item['image_url'],
                $item['is_active']
            );
        }
        return $items;
    }

    static function searchItems(PDO $db, string $searchString): array
    {
        $stmt = $db->prepare('SELECT * FROM items 
                  WHERE brand LIKE :searchString 
                  OR model LIKE :searchString
                  OR category LIKE :searchString
                  OR condition LIKE :searchString');

        $stmt->bindValue(':searchString', "%$searchString%", PDO::PARAM_STR);

        $stmt->execute();

        $items = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $item = new Shop(
                $row['id'],
                $row['user_id'],
                $row['category'],
                $row['brand'],
                $row['model'],
                $row['size'],
                $row['condition'],
                $row['description'],
                $row['price'],
                $row['image_url'],
                $row['is_active']
            );
            $items[] = $item;
        }

        return $items;
    }

    public static function filterItems($db, $category, $brand, $model, $size, $condition, $min_price, $max_price)
    {
        $query = 'SELECT * FROM items WHERE price BETWEEN :min_price AND :max_price';
        $params = [':min_price' => $min_price, ':max_price' => $max_price];

        if (!empty($category)) {
            $query .= ' AND category IN (' . implode(',', array_fill(0, count($category), '?')) . ')';
            $params = array_merge($params, $category);
        }
        if (!empty($brand)) {
            $query .= ' AND brand IN (' . implode(',', array_fill(0, count($brand), '?')) . ')';
            $params = array_merge($params, $brand);
        }
        if (!empty($model)) {
            $query .= ' AND model IN (' . implode(',', array_fill(0, count($model), '?')) . ')';
            $params = array_merge($params, $model);
        }
        if (!empty($size)) {
            $query .= ' AND size IN (' . implode(',', array_fill(0, count($size), '?')) . ')';
            $params = array_merge($params, $size);
        }
        if (!empty($condition)) {
            $query .= ' AND condition IN (' . implode(',', array_fill(0, count($condition), '?')) . ')';
            $params = array_merge($params, $condition);
        }

        // Debugging: Log the query and parameters
        error_log("Query: $query");
        error_log("Parameters: " . print_r($params, true));

        $stmt = $db->prepare($query);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public static function addItem(
        PDO $db,
        int $userId,
        string $category,
        string $brand,
        string $model,
        string $size,
        string $condition,
        string $description,
        float $price,
        string $imageUrl
    ) {

        $query = 'INSERT INTO items (user_id, category, brand, model, size, condition, description, price, image_url, is_active) 
                  VALUES (:user_id, :category, :brand, :model, :size, :condition, :description, :price, :image_url, 1)';
        $stmt = $db->prepare($query);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':category', $category, PDO::PARAM_STR);
        $stmt->bindParam(':brand', $brand, PDO::PARAM_STR);
        $stmt->bindParam(':model', $model, PDO::PARAM_STR);
        $stmt->bindParam(':size', $size, PDO::PARAM_STR);
        $stmt->bindParam(':condition', $condition, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':price', $price, PDO::PARAM_STR);
        $stmt->bindParam(':image_url', $imageUrl, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return $db->lastInsertId();
        } else {
            return false;
        }
    }

    public static function itemNotActive(PDO $db, int $itemId)
    {
        $query = 'UPDATE items SET is_active = 0 WHERE id = :item_id';
        $stmt = $db->prepare($query);
        $stmt->bindParam(':item_id', $itemId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public static function editItem(
        PDO $db,
        int $itemId,
        string $category,
        string $brand,
        string $model,
        string $size,
        string $condition,
        string $description,
        float $price,
        int $isActive
    ) {
        $query = 'UPDATE items 
              SET category = :category, 
                  brand = :brand, 
                  model = :model, 
                  size = :size, 
                  condition = :condition, 
                  description = :description, 
                  price = :price,
                  is_active = :is_active
              WHERE id = :item_id';
        $stmt = $db->prepare($query);
        $stmt->bindParam(':item_id', $itemId, PDO::PARAM_INT);
        $stmt->bindParam(':category', $category, PDO::PARAM_STR);
        $stmt->bindParam(':brand', $brand, PDO::PARAM_STR);
        $stmt->bindParam(':model', $model, PDO::PARAM_STR);
        $stmt->bindParam(':size', $size, PDO::PARAM_STR);
        $stmt->bindParam(':condition', $condition, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':price', $price, PDO::PARAM_STR);
        $stmt->bindParam(':is_active', $isActive, PDO::PARAM_INT);

        return $stmt->execute();
    }
    public static function deleteItem(PDO $db, int $itemId): bool
    {
        $stmt = $db->prepare("DELETE FROM items WHERE id = :id");
        $stmt->bindParam(':id', $itemId, PDO::PARAM_INT);
        return $stmt->execute();
    }


    public static function updateItemPicture(PDO $db, int $itemId, string $imageData): bool
    {
        try {
            // Prepare the SQL statement to update the profile picture
            $query = "UPDATE items SET image_url = :imageData WHERE id = :itemId";
            $stmt = $db->prepare($query);

            // Bind parameters
            $stmt->bindParam(':imageData', $imageData, PDO::PARAM_LOB);
            $stmt->bindParam(':itemId', $itemId, PDO::PARAM_INT);

            // Execute the statement
            $stmt->execute();

            // Check if any rows were affected (item picture updated successfully)
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
}
?>