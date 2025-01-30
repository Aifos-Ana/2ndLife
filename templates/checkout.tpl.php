<?php
function draw_checkout(array $cartItems, PDO $db)
{
    $totalValue = 0;
    foreach ($cartItems as $item) {
        $totalValue += $item->price;
    }
    $totalValue = $totalValue + ($totalValue * 0.1);

    ?>

    <head>
        <script src="../javascript/checkout_script.js" defer></script>
    </head>

    <div id="checkoutContainer">
        <h2>Checkout</h2>
        <p>Total: $<?php echo htmlspecialchars(number_format($totalValue, 1)); ?></p>

        <form id="checkoutForm" action="../actions/action_checkout.php" method="post">
            <label for="cardNumber">Card Number:</label>
            <input type="text" id="cardNumber" name="cardNumber" placeholder="1234 5678 9012 3456" required><br>

            <label for="expiryDate">Expiry Date:</label>
            <input type="text" id="expiryDate" name="expiryDate" placeholder="MM/YY" required><br>

            <label for="cvv">CVV:</label>
            <input type="text" id="cvv" name="cvv" placeholder="123" required><br>

            <label for="cardHolder">Cardholder Name:</label>
            <input type="text" id="cardHolder" name="cardHolder" placeholder="John Doe" required><br>

            <input type="submit" value="Submit Payment">
        </form>

    </div>
    <div id="paymentComplete">
        Payment Complete! Thank you for your purchase.
        <form action="../index.php">
            <input type="submit" value="Back home" />
        </form>
    </div>
<?php } ?>