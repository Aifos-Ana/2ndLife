<?php
function draw_addItemForm()
{ ?>

    <h1>Add Item</h1>
    <div class="container">
        <form action="../actions/action_addItem.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="category"><strong>Category:</strong></label>
                <input type="text" class="form-control" id="category" name="category" required>
            </div>
            <div class="form-group">
                <label for="brand"><strong>Brand:</strong></label>
                <input type="text" class="form-control" id="brand" name="brand" required>
            </div>
            <div class="form-group">
                <label for="model"><strong>Model:</strong></label>
                <input type="text" class="form-control" id="model" name="model" required>
            </div>
            <div class="form-group">
                <label for="size"><strong>Size:</strong></label>
                <input type="text" class="form-control" id="size" name="size" required>
            </div>
            <div class="form-group">
                <label for="condition"><strong>Condition:</strong></label>
                <input type="text" class="form-control" id="condition" name="condition" required>
            </div>
            <div class="form-group">
                <label for="description"><strong>Description:</strong></label>
                <textarea class="form-control" id="description" name="description" rows="4"
                    required><?php echo htmlspecialchars($_POST['description'] ?? ''); ?></textarea>
            </div>
            <div class="form-group">
                <label for="price"><strong>Price</strong></label>
                <input type="number" class="form-control" id="price" name="price" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="image"><strong>Image:</strong></label>
                <input type="file" id="image" accept="image/*" name="image" required>
            </div>
            <div class="form-btn">
                <button type="submit" class="btn-primary">Add item</button>
            </div>
        </form>
    </div>
<?php } ?>