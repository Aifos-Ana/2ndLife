function removeItem(itemId) {
                if (confirm("Are you sure you want to remove this item?")) {
                    // Send AJAX request to remove item from the cart
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "../actions/action_removeItemCart.php", true);
                    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState == 4 && xhr.status == 200) {
                            // Reload the cart content after successful removal
                            location.reload();
                        }
                    };
                    xhr.send("itemId=" + itemId);
                }
}
            
function addToCart(itemId) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "../actions/action_addItemCart.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    alert(xhr.responseText);
                } else {
                    alert("Failed to add item to cart. Please try again later.");
                }
            }
        };
        xhr.send("itemId=" + itemId);
    }