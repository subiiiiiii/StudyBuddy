<?php
require_once "../config.php";
require_once "utils.php";


/* Setting the session variable to an empty string. */
if (isset ($_POST['submit'])) {
    /* Getting the email and password from the form. */
    $logEmail = sanitizeInput($_POST['email']);
    /* Sanitizing the email. */
    $userEmail = filter_var($logEmail, FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    /* Hashing the password. */
    $hashedPassword = md5($password);

    // Write a  SQL query to match the email and password.
    $loginCheckSQL = "SELECT * FROM `user` WHERE email=? AND password=?";
    /* Preparing the SQL statement. */
    $loginCheckStatement = $connection->prepare($loginCheckSQL);
    $loginCheckStatement->bind_param('ss', $userEmail, $hashedPassword);
    $loginCheckStatement->execute();

    /* Getting the result of the query. */
    $loginCheckExecution = $loginCheckStatement->get_result();

    /* Checking if the result has one row. */
    if ($loginCheckExecution->num_rows == 1) {

        $user = $loginCheckExecution->fetch_assoc();
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['full_name'] = $user['first_name'];
        $_SESSION['email'] = $userEmail;
        $_SESSION['is_admin'] = $user['is_admin'];
        $_SESSION['logged_in'] = true;

        $_SESSION['success_msg'] = "You have successfully logged in.";
        $_SESSION['title_msg'] = "Login";
        /* Redirecting the user to the index page. */
        header("Location:../index.php");
    }else {
        $_SESSION['error_msg'] = "Invalid email or password.";
        $_SESSION['title_msg'] = "Login";
        header("Location: ../login.php");
    }
    } else {
        /* Setting the session variable to an error message. */
        $error_message = "Invalid email or password.";
        header("Location:../login.php?error_message=" . $error_message);
    }