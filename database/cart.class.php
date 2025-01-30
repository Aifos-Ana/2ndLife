<?php
declare(strict_types=1);

class Cart
{
    public int $item_id;
    public int $user_id;
    public string $description;
    public float $price;

    public function __construct(int $item_id, int $user_id, string $description, float $price)
    {
        $this->item_id = $item_id;
        $this->user_id = $user_id;
        $this->description = $description;
        $this->price = $price;
    }

    static function getCartByUserId(PDO $db, int $user_id): array
    {
        $stmt = $db->prepare('SELECT sc.*, i.description, i.price
        FROM shopping_carts sc
        INNER JOIN items i ON sc.item_id = i.id
        WHERE sc.user_id = :user_id');
        $stmt->execute(['user_id' => $user_id]);

        $carts = array();

        while ($cart = $stmt->fetch()) {
            $item_id = $cart['item_id'];
            $user_id = $cart['user_id'];
            $description = $cart['description'];
            $price = $cart['price'];

            // Ensure that all necessary data is present
            if ($item_id !== null && $user_id !== null && $description !== null && $price !== null) {
                $carts[] = new Cart($item_id, $user_id, $description, $price); // Pass the price
            } else {
                // Log any unexpected data or handle the error appropriately
                error_log("Unexpected data in shopping cart: " . var_export($cart, true));
            }
        }

        return $carts;
    }

    public static function removeItem(PDO $db, int $itemId, int $userId): bool
    {
        $stmt = $db->prepare('DELETE FROM shopping_carts WHERE item_id = :item_id AND user_id = :user_id');
        return $stmt->execute(['item_id' => $itemId, 'user_id' => $userId]);
    }

    public static function addItem(PDO $db, int $itemId, int $userId): bool
    {
        // Check if the item is already in the cart
        if (self::isItemInCart($db, $itemId, $userId)) {
            // If the item is already in the cart, return false
            return false;
        }

        // If the item is not in the cart, add it
        $stmt = $db->prepare('INSERT INTO shopping_carts (item_id, user_id) VALUES (:item_id, :user_id)');
        return $stmt->execute(['item_id' => $itemId, 'user_id' => $userId]);
    }

    public static function isItemInCart(PDO $db, int $itemId, int $userId): bool
    {
        $stmt = $db->prepare('SELECT COUNT(*) FROM shopping_carts WHERE item_id = :item_id AND user_id = :user_id');
        $stmt->execute(['item_id' => $itemId, 'user_id' => $userId]);
        $count = $stmt->fetchColumn();
        return $count > 0;
    }

    public static function updateCartItemsStatus(PDO $db, int $userId): bool
    {
        $stmt = $db->prepare('UPDATE items
                              SET is_active = 0
                              WHERE id IN (SELECT item_id FROM shopping_carts WHERE user_id = :user_id)');
        return $stmt->execute(['user_id' => $userId]);
    }

    public static function removeAllItemsFromCart(PDO $db, int $userId): bool
    {
        $stmt = $db->prepare('DELETE FROM shopping_carts WHERE user_id = :user_id');
        return $stmt->execute(['user_id' => $userId]);
    }

}
?>