<?php
function draw_profileSelf(PDO $db, Session $session, User $users, array $sellingItems)
{ ?>

    <head>
        <script src="../javascript/profile_script.js" defer></script>
    </head>

    <body>
        <div class="profile-container">
            <div class="profile">
                <img id="profileImage" src="/../<?= htmlspecialchars($users->image_url) ?>" alt="Profile Picture">
                <span class="nameH2">
                    <h2> <?= htmlspecialchars($session->getName()) ?>'s Profile</h2>
                </span>
                <div class="details">
                    <p><span class="info-label">Name:</span> <span class="name">
                            <?= htmlspecialchars($session->getName()) ?>
                        </span>
                    </p>
                    <p><span class="info-label">Email:</span> <span
                            class="email"><?= htmlspecialchars($session->getEmail()) ?></span></p>
                    <p><span class="info-label">User type:</span> <span class="user_type">
                            <?= htmlspecialchars($users->userType()) ?>
                        </span>
                    </p>
                </div>
                <button class="edit-button">Edit Profile</button>
                <form id="profileForm" style="display: none;">
                    <label for="nameInput">Name:</label>
                    <input type="text" id="nameInput" name="name" value="<?= htmlspecialchars($session->getName()) ?>">
                    <label for="emailInput">Email:</label>
                    <input type="email" id="emailInput" name="email" value="<?= htmlspecialchars($session->getEmail()) ?>">
                    <label for="imageInput">Profile Image:</label>
                    <input type="file" id="imageInput" accept="image/*" name="image">
                    <div class="form-group">
                        <button type="submit" class="save-button">Save Changes</button>
                    </div>
                </form>
            </div>
            <?php if ($users->is_Seller || $users->is_Admin): ?>
                <?php if (empty($sellingItems)): ?>
                    <div class="no-items-message">
                        <p>No items for sale yet...</p>
                    </div>
                <?php else: ?>
                    <div class="selling-items">
                        <h3>Items for Sale:</h3>
                        <ul>
                            <?php foreach ($sellingItems as $item): ?>
                                <?php if (Shop::isItemActive($db, $item->id)): ?>
                                    <article>
                                        <a href="../pages/items.php?id=<?= htmlspecialchars($item->id) ?>">
                                            [<?= htmlspecialchars($item->condition) ?>] | <?= htmlspecialchars($item->name) ?>
                                            <?= htmlspecialchars($item->brand) ?> - <?= htmlspecialchars($item->model) ?>
                                            ($<?= htmlspecialchars($item->price) ?>)
                                            <img src="../<?= htmlspecialchars($item->image_url) ?>" />
                                        </a>
                                        <form action="../actions/action_deleteItem.php" method="post"
                                            onsubmit="return confirm('Are you sure you want to delete this item?');">
                                            <input type="hidden" name="item_id" value="<?= htmlspecialchars($item->id) ?>">
                                            <div class="delete_bttn">
                                                <button type="submit" class="delete-button">Delete</button>
                                            </div>
                                        </form>
                                    </article>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                        <h3>Items sold:</h3>
                        <?php $noItemsSold = true;
                        foreach ($sellingItems as $item):
                            if (!Shop::isItemActive($db, $item->id)):
                                $noItemsSold = false;
                            endif;
                        endforeach;
                        if ($noItemsSold): ?>
                            <div class="no-items-message">
                                <p>No items sold yet...</p>
                            </div>
                        <?php else: ?>
                            <ul>
                                <?php foreach ($sellingItems as $item): ?>
                                    <?php if (!Shop::isItemActive($db, $item->id)): ?>
                                        <article>
                                            <a href="../pages/items.php?id=<?= htmlspecialchars($item->id) ?>">
                                                [<?= htmlspecialchars($item->condition) ?>] | <?= htmlspecialchars($item->name) ?>
                                                <?= htmlspecialchars($item->brand) ?> - <?= htmlspecialchars($item->model) ?>
                                                ($<?= htmlspecialchars($item->price) ?>)
                                                <img src="../<?= htmlspecialchars($item->image_url) ?>" />
                                            </a>
                                        </article>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                        <div class="add-item-button-container">
                            <button onclick="window.location.href='../pages/add_item.php'">Add New Item</button>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </body>
<?php } ?>




<?php function draw_profile(PDO $db, Session $session, User $users, array $sellingItems)
{ ?>

    <head>
        <script src="../javascript/profile_script.js" defer></script>
    </head>

    <body>
        <div class="profile-container">
            <div class="profile">
                <img id="profileImage" src="/../<?= htmlspecialchars($users->image_url) ?>" alt="Profile Picture">
                <span class="nameH2">
                    <h2><?= htmlspecialchars($users->name) ?>'s Profile</h2>
                </span>

                <div class="details">
                    <p><span class="info-label">Name:</span> <span class="name">
                            <?= htmlspecialchars($users->name) ?>
                        </span>
                    </p>
                    <p><span class="info-label">Email:</span> <span class="email">
                            <?= htmlspecialchars($users->email) ?>
                        </span>
                    </p>
                    <p><span class="info-label">User type:</span> <span class="user_type" id="userType">
                            <?php if ($users->userType() == "admin") { ?>
                                <?= htmlspecialchars("Admin") ?>
                            <?php } elseif ($users->userType() == "seller") { ?>
                                <?= htmlspecialchars("Seller") ?>
                            <?php } else { ?>
                                <?= htmlspecialchars("Buyer") ?>
                            <?php } ?>
                        </span></p>
                    <?php if ($session->isAdmin()) { ?>
                        <label class="info-label" for="userTypeSelect">Change User Type:</label>
                        <select id="userTypeSelect">
                            <option value="admin">Admin</option>
                            <option value="seller">Seller</option>
                            <option value="normal">Buyer</option>
                        </select>
                        <button id="promoteButton">Promote</button>
                    <?php } ?>
                </div>
            </div>
            <?php if ($users->is_Seller || $users->is_Admin) {
                if (empty($sellingItems)) { ?>
                    <div class="no-items-message">
                        <p>No items for sale yet...</p>
                    </div>
                <?php } else { ?>
                    <div class="selling-items">
                        <h3>Items for Sale:</h3>
                        <ul>
                            <?php foreach ($sellingItems as $item) {
                                $isItemActive = Shop::isItemActive($db, $item->id);
                                if ($isItemActive) { ?>
                                    <article>
                                        <a href="../pages/items.php?id=<?= htmlspecialchars($item->id) ?>">
                                            [<?= htmlspecialchars($item->condition) ?>] | <?= htmlspecialchars($item->name) ?>
                                            <?= htmlspecialchars($item->brand) ?> - <?= htmlspecialchars($item->model) ?>
                                            ($<?= htmlspecialchars($item->price) ?>)
                                            <img src="../<?= htmlspecialchars($item->image_url) ?>" />
                                        </a>
                                    </article>
                                <?php }
                            } ?>
                        </ul>
                        <h3>Items sold:</h3>
                        <?php
                        $noItemsSold = true;
                        foreach ($sellingItems as $item) {
                            $isItemActive = Shop::isItemActive($db, $item->id);
                            if (!$isItemActive) {
                                $noItemsSold = false;
                                break;
                            }
                        }
                        if ($noItemsSold) { ?>
                            <div class="no-items-message">
                                <p>No items sold yet...</p>
                            </div>
                        <?php } else { ?>
                            <ul>
                                <?php foreach ($sellingItems as $item) {
                                    $isItemActive = Shop::isItemActive($db, $item->id);
                                    if (!$isItemActive) { ?>
                                        <article>
                                            <a href="../pages/items.php?id=<?= htmlspecialchars($item->id) ?>">
                                                [<?= htmlspecialchars($item->condition) ?>] | <?= htmlspecialchars($item->name) ?>
                                                <?= htmlspecialchars($item->brand) ?> - <?= htmlspecialchars($item->model) ?>
                                                ($<?= htmlspecialchars($item->price) ?>)
                                                <img src="../<?= htmlspecialchars($item->image_url) ?>" />
                                            </a>
                                        </article>
                                    <?php }
                                } ?>
                            </ul>
                        <?php } ?>
                    </div>
                <?php }
            } ?>
    </body>

<?php } ?>