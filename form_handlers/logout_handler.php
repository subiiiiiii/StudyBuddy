<?php
    session_start();
    $_SESSION['logged_in'] = false;
    $_SESSION['success_msg'] = "You have been logout successfully.";
    $_SESSION['title_msg'] = "Logout";
    session_destroy();
    header("Location:../login.php");
?>