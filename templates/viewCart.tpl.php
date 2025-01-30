<?php function draw_cart(array $cartItems, PDO $db)
{
    $totalPrice = 0;
    foreach ($cartItems as $cartItem) {
        $totalPrice += $cartItem->price;
    }
    // Assuming VAT is 10% of the total price
    $vat = $totalPrice * 0.1;
    $totalWithVat = $totalPrice + $vat;
    ?>

    <head>
        <script src="../javascript/cart_script.js" defer></script>
    </head>
    <section id="CartContainer">
        <section id="Cart">
            <article>
                <?php if (empty($cartItems)) { ?>
                    <p>No items</p>
                <?php } else { ?>
                    <?php foreach ($cartItems as $cartItem) { ?>
                        <ul>
                            <li>
                                <p><strong>Item: </strong> <?= htmlspecialchars($cartItem->description) ?></p>
                                <p><strong>Price:</strong> $<?= htmlspecialchars($cartItem->price) ?>
                                    <element class="Cart_button_container">
                                        <button onclick="removeItem(<?= htmlspecialchars($cartItem->item_id) ?>)">Remove
                                            Item</button>
                                    </element>
                                </p>
                            </li>
                        </ul>
                    <?php } ?>
                <?php } ?>
            </article>
        </section>
        <section id="CartSummary">
            <article>
                <p><strong>Total Price:</strong> $<?= htmlspecialchars($totalPrice) ?></p>
                <p><strong>VAT (10%):</strong> $<?= htmlspecialchars($vat) ?></p>
                <p><strong>Total with VAT:</strong> $<?= htmlspecialchars($totalWithVat) ?></p>
                <?php if (empty($cartItems)) { ?>
                    <button disabled>Proceed to Checkout</button>
                    <p style="color: red;">You can't checkout with an empty cart</p>
                <?php } else { ?>
                    <button onclick="window.location.href = '../pages/checkout.php';">Proceed to Checkout</button>
                <?php } ?>
            </article>
        </section>
    </section>
<?php } ?>