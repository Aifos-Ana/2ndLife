function validateForm() {
            var cardNumber = document.getElementById('cardNumber').value;
            var expiryDate = document.getElementById('expiryDate').value;
            var cvv = document.getElementById('cvv').value;
            var cardHolder = document.getElementById('cardHolder').value;

            // Validate card number format (16 digits)
            if (!/^\d{16}$/.test(cardNumber)) {
                alert('Please enter a valid card number.');
                return false;
            }

            // Validate expiry date format (MM/YY)
            if (!/^(0[1-9]|1[0-2])\/\d{2}$/.test(expiryDate)) {
                alert('Please enter a valid expiry date (MM/YY).');
                return false;
            }

            // Validate CVV format (3 digits)
            if (!/^\d{3}$/.test(cvv)) {
                alert('Please enter a valid CVV.');
                return false;
            }

            // Validate cardholder name format (any text)
            if (!/^[\w\s]+$/.test(cardHolder)) {
                alert('Please enter a valid cardholder name.');
                return false;
            }

            return true; // Form is valid
}

document.getElementById("checkoutForm").addEventListener("submit", function(event) {
            event.preventDefault();

            var formData = new FormData(this);
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "../actions/action_checkout.php", true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    // Hide the form
                    document.getElementById("checkoutContainer").style.display = "none";
                    // Show the payment complete message after 3 seconds
                    setTimeout(function() {
                        document.getElementById("paymentComplete").style.display = "block";
                    }, 3000);
                }
            };
            xhr.send(formData);
        });

    