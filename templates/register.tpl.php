<?php function draw_mainPage()
{
    ?>

    <head>
        <link rel="stylesheet" href="../css/authentication.css">
    </head>

    <body>
        <div class="container">
            <a class="links" id="register"></a>
            <div class="content">
                <div id="register">
                    <form method="post" action="../actions/action_register.php">
                        <h1>Register</h1>

                        <p>
                            <label for="name_reg">
                                Name:
                            </label>

                            <input id="name_reg" name="name_reg" required="required" type="text"
                                placeholder="not shown to others" />
                        </p>

                        <p>
                            <label for="username_reg">
                                Username:
                            </label>

                            <input id="username_reg" name="username_reg" required="required" type="text"
                                placeholder="Username" />
                        </p>

                        <p>
                            <label for="email_reg">
                                E-mail:
                            </label>

                            <input id="email_reg" name="email_reg" required="required" type="email" placeholder="E-mail" />
                        </p>

                        <p>
                            <label for="password_reg">
                                Password:
                            </label>

                            <input id="password_reg" name="password_reg" required="required" type="password"
                                placeholder="Password" />
                        </p>

                        <p>
                            <input type="submit" value="Register" />
                        </p>

                        <p class="link">
                            Already have an account?
                            <a href="login.php">
                                Go to Login
                            </a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </body>

<?php } ?>