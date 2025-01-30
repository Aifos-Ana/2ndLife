<?php
function draw_header(Session $session, string $css)
{ ?>
    <!DOCTYPE html>
    <html lang="en-US">

    <head>
        <meta charset="utf-8" />
        <title>2ndLife</title>
        <link rel="icon" type="image/x-icon" href="/../img/favicon.ico">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <link rel="stylesheet" href="../css/common.css">
        <link rel="stylesheet" href="<?= $css ?>">
    </head>

    <body>
        <header>
            <a href="/">
                <div class="header-container">
                    <img src="../img/icon.png" alt="2nd life logo">
                    <h1>2ndLife</h1>
                </div>
            </a>
            <ul class="list">
                <?php if (!$session->isLoggedin()) { ?>
                    <li><a href="../pages/login.php">Log In</a></li>
                    <li><a href="../pages/register.php">Register</a></li>
                <?php } else { ?>
                    <li><a href="../pages/profile.php"><?= htmlspecialchars($session->getName()) ?>'s Profile</a></li>
                    <li><a href="../pages/viewCart.php">Shopping Cart</a></li>
                    <?php drawLogoutForm($session); ?>
                <?php } ?>
            </ul>
        </header>
        <section id="messages">
            <?php foreach ($session->getMessages() as $message) { ?>
                <article class="<?= htmlspecialchars($message['type']) ?>">
                    <?= htmlspecialchars($message['text']) ?>
                </article>
            <?php } ?>
        </section>
        <main>
        <?php } ?>

        <?php function draw_footer()
        { ?>
        </main>
        <footer>
            <a href="">2ndLife &copy; 2024</a>
        </footer>
    </body>

    </html>
<?php } ?>

<?php function drawLogoutForm(Session $session)
{ ?>
    <form action="../actions/action_logout.php" method="post" class="logout">
        <button type="submit">Logout</button>
    </form>
<?php } ?>