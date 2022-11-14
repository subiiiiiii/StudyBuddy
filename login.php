<?php
include 'config.php';
include_once "header.php";
include_once "navbar.php";
?>

    <div class="container">
        <div class="row mt-5">
            <div class="col-5" style="padding:0;">
                <h1>Login Form</h1>
                <form class="form" method="post" action="form_handlers/login_handler.php">
                    <div class="form-group mt-5">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Enter your email" class="form-control">
                    </div>
                    <div class="form-group mt-2">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="********"
                               class="form-control">
                    </div>

                    <p class="my-2">
                        <small class="text-danger">
                            <?php
                            if (isset($_GET['error_message'])) {
                                echo $_GET['error_message'];
                            }
                            ?>
                        </small>
                        <small class="text-success">
                            <?php
                            if (isset($_GET['success_message'])) {
                                echo $_GET['success_message'];
                            }
                            ?>
                        </small>
                    </p>
                    <input class="btn btn-primary btn-block" name="submit" type="submit" value="Login">
                </form>
                <div>
                    <p class="mt-3 text-center">
                        <span>Don't have an account? <a
                                href="register.php">Register Now!</a></span>
                    </p>
                </div>
            </div>
            <div class="offset-1 col-6" style="padding:0;">
                <img src="assets/images/loginlogo2.png" alt="login page" width="350px" height="400px">
            </div>
        </div>

    </div>
<?php include_once "footer.php" ?>