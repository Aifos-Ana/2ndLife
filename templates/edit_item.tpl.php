<?php
function draw_editItem(PDO $db, Shop $item)
{
    ?>

    <body>
        <h1>Edit Item</h1>
        <div class="form-container">
            <form method="post" action="../actions/action_updateItem.php" enctype="multipart/form-data">
                <label for="brand">Brand:</label>
                <input type="text" id="brand" name="brand" value="<?= htmlspecialchars($item->brand) ?>" required>

                <label for="model">Model:</label>
                <input type="text" id="model" name="model" value="<?= htmlspecialchars($item->model) ?>" required>

                <label for="price">Price:</label>
                <input type="number" step="0.01" id="price" name="price" value="<?= htmlspecialchars($item->price) ?>"
                    required>

                <label for="category">Category:</label>
                <input type="text" id="category" name="category" value="<?= htmlspecialchars($item->category) ?>" required>

                <label for="condition">Condition:</label>
                <input type="text" id="condition" name="condition" value="<?= htmlspecialchars($item->condition) ?>"
                    required>

                <label for="size">Size:</label>
                <input type="text" id="size" name="size" value="<?= htmlspecialchars($item->size) ?>" required>

                <label for="description">Description:</label>
                <textarea id="description" name="description"
                    required><?= htmlspecialchars($item->description) ?></textarea>

                <label for="image">Image:</label>
                <input type="file" id="image" name="image" accept="image/*">

                <label for="is_active">Active:</label>
                <input type="checkbox" id="is_active" name="is_active" <?= $item->is_active ? 'checked' : '' ?>>

                <input type="hidden" name="item_id" value="<?= htmlspecialchars($item->id) ?>">

                <button type="submit">Save Changes</button>
            </form>
        </div>
    </body>
<?php } ?>