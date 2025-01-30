<?php
function draw_item(Shop $item, User $seller, Session $session)
{
    ?>

    <head>
        <script src="../javascript/cart_script.js" defer></script>
    </head>
    <section id="item">
        <div class="seller-details">
            <h3>Seller Information</h3>
            <a href="../pages/profile.php?id=<?= htmlspecialchars($seller->id) ?>">
                <img src="/../<?php echo htmlspecialchars($seller->image_url); ?>" alt="Seller Image">
            </a>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($seller->name); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($seller->email); ?></p>
        </div>
        <div class="item-details">
            <h2><?php echo htmlspecialchars($item->brand . ' - ' . $item->model); ?></h2>
            <img src="/../<?php echo htmlspecialchars($item->image_url); ?>" alt="Item Image">
            <p><strong>Price:</strong> $<?php echo number_format($item->price, 2); ?></p>
            <p><strong>Category:</strong> <?php echo htmlspecialchars($item->category); ?></p>
            <p><strong>Condition:</strong> <?php echo htmlspecialchars($item->condition); ?></p>
            <p><strong>Size:</strong> <?php echo htmlspecialchars($item->size); ?></p>
            <p><strong>Description:</strong> <?php echo htmlspecialchars($item->description); ?></p>
            <p><strong>Status:</strong> <?php echo $item->is_active ? 'On Sale' : 'Sold'; ?></p>

            <?php if ($item->is_active && $session->isLoggedIn() && $session->getId() != $seller->id): ?>
                <button onclick="addToCart(<?php echo htmlspecialchars($item->id); ?>)">Add to Cart</button>
            <?php else: ?>
                <button disabled>Add to Cart</button>
            <?php endif; ?>

            <!-- Edit Item button, visible only to the seller or an admin -->
            <?php if ($session->isLoggedIn() && ($session->getId() == $seller->id || $session->isAdmin()) && $item->is_active): ?>
                <button onclick="window.location.href='../pages/edit_item.php?id=<?= htmlspecialchars($item->id) ?>'">Edit
                    Item</button>
            <?php endif; ?>

        </div>
    </section>
<?php } ?>