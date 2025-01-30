<?php
function drawItems(array $items, PDO $db)
{ ?>

    <head>
        <script src="../javascript/homepage_script.js" defer></script>
    </head>
    <header>
        <h2>Items:</h2>
        <input id="search" type="text" placeholder="search">
    </header>
    <section id="items">
        <?php foreach ($items as $item) {
            $imageUrl = htmlspecialchars(Shop::getImageUrlById($db, $item->id));
            $isItemActive = Shop::isItemActive($db, $item->id);
            if (/*$isItemActive*/ true) { ?>
                <article data-id="<?= htmlspecialchars($item->id) ?>" data-condition="<?= htmlspecialchars($item->condition) ?>"
                    data-brand="<?= htmlspecialchars($item->brand) ?>" data-model="<?= htmlspecialchars($item->model) ?>"
                    data-price="<?= htmlspecialchars($item->price) ?>" data-image-url="<?= $imageUrl ?>">
                    <a href="../pages/items.php?id=<?= htmlspecialchars($item->id) ?>">
                        [<?= htmlspecialchars($item->condition) ?>] |
                        <?= htmlspecialchars($item->brand) ?> - <?= htmlspecialchars($item->model) ?>
                        ($<?= htmlspecialchars($item->price) ?>)
                        <img src="<?= htmlspecialchars($item->image_url) ?>" />
                    </a>
                </article>
            <?php }
        } ?>
    </section>
    <?php
} ?>

<?php
function drawFilters(array $items)
{
    // Extract unique values for each filter category
    $categories = array_unique(array_map(fn($item) => $item->category, $items));
    $brands = array_unique(array_map(fn($item) => $item->brand, $items));
    $models = array_unique(array_map(fn($item) => $item->model, $items));
    $sizes = array_unique(array_map(fn($item) => $item->size, $items));
    $conditions = array_unique(array_map(fn($item) => $item->condition, $items));

    ?>
    <form id="Filters" method="POST" action="../api/api_filter.php">
        <section id="Filters">
            <h3> Filters: </h3>

            <!-- Category Filters -->
            <ul>
                <li>
                    <label for="category">Category:</label>
                    <ul>
                        <?php foreach ($categories as $category) { ?>
                            <li>
                                <input type="checkbox" id="<?= htmlspecialchars($category) ?>" name="category[]"
                                    value="<?= htmlspecialchars($category) ?>">
                                <label for="<?= htmlspecialchars($category) ?>"><?= htmlspecialchars($category) ?></label>
                            </li>
                        <?php } ?>
                    </ul>
                </li>
            </ul>

            <!-- Brand Filters -->
            <ul>
                <li>
                    <label for="brand">Brand:</label>
                    <ul>
                        <?php foreach ($brands as $brand) { ?>
                            <li>
                                <input type="checkbox" id="<?= htmlspecialchars($brand) ?>" name="brand[]"
                                    value="<?= htmlspecialchars($brand) ?>">
                                <label for="<?= htmlspecialchars($brand) ?>"><?= htmlspecialchars($brand) ?></label>
                            </li>
                        <?php } ?>
                    </ul>
                </li>
            </ul>

            <!-- Model Filters -->
            <ul>
                <li>
                    <label for="model">Model:</label>
                    <ul>
                        <?php foreach ($models as $model) { ?>
                            <li>
                                <input type="checkbox" id="<?= htmlspecialchars($model) ?>" name="model[]"
                                    value="<?= htmlspecialchars($model) ?>">
                                <label for="<?= htmlspecialchars($model) ?>"><?= htmlspecialchars($model) ?></label>
                            </li>
                        <?php } ?>
                    </ul>
                </li>
            </ul>

            <!-- Size Filters -->
            <ul>
                <li>
                    <label for="size">Size:</label>
                    <ul>
                        <?php foreach ($sizes as $size) { ?>
                            <li>
                                <input type="checkbox" id="<?= htmlspecialchars($size) ?>" name="size[]"
                                    value="<?= htmlspecialchars($size) ?>">
                                <label for="<?= htmlspecialchars($size) ?>"><?= htmlspecialchars($size) ?></label>
                            </li>
                        <?php } ?>
                    </ul>
                </li>
            </ul>

            <!-- Condition Filters -->
            <ul>
                <li>
                    <label for="condition">Condition:</label>
                    <ul>
                        <?php foreach ($conditions as $condition) { ?>
                            <li>
                                <input type="checkbox" id="<?= htmlspecialchars($condition) ?>" name="condition[]"
                                    value="<?= htmlspecialchars($condition) ?>">
                                <label for="<?= htmlspecialchars($condition) ?>"><?= htmlspecialchars($condition) ?></label>
                            </li>
                        <?php } ?>
                    </ul>
                </li>
            </ul>

            <!-- Price Filters -->
            <ul>
                <li>
                    <label for="min_price">Min Price:</label>
                    <input type="range" id="min_price" name="min_price" min="0" max="3000" value="0"
                        oninput="updateMinPrice()">
                    <span id="min_price_display">$0</span>
                </li>
                <li>
                    <label for="max_price">Max Price:</label>
                    <input type="range" id="max_price" name="max_price" min="0" max="3000" value="3000"
                        oninput="updateMaxPrice()">
                    <span id="max_price_display">$3000</span>
                </li>
            </ul>

            <button type="button" onclick="applyFilters()">Apply Filters</button>
        </section>
    </form>
    <?php
}
?>