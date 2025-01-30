<?php
function draw_mainPage()
{
    ?>

    <head>
        <link rel="stylesheet" href="../css/authentication.css">
    </head>

    <body>
        <div class="container">
            <a class="links" id="login"></a>

            <div class="content">
                <div id="login">
                    <form method="post" action="../actions/action_login.php">
                        <h1>Login</h1>
                        <p>
                            <label for="email_login">
                                E-mail:
                            </label>

                            <input id="email_login" name="email_login" required="required" type="text"
                                placeholder="E-mail" />
                        </p>

                        <p>
                            <label for="password_login">
                                Password:
                            </label>

                            <input id="password_login" name="password_login" required="required" type="password"
                                placeholder="Password" />
                        </p>
                        <p>
                            <input type="submit" value="Login" />
                        </p>

                        <p class="link">
                            Don't have an account?
                            <a href="register.php">
                                Register
                            </a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </body>

<?php } ?>