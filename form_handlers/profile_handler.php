<?php
require_once "../config.php";
require_once "utils.php";

function updateProfile($connection, $first_name, $last_name, $email, $date_of_birth, $display_picture, $id)
{
    $sql = "UPDATE user SET first_name=?, last_name=?, date_of_birth=?, email=?, display_picture=? WHERE user_id=?";
    $statement= $connection->prepare($sql);
    $statement->execute([$first_name, $last_name, $date_of_birth, $email, $display_picture, $id]);
    return $statement;
}

if (isset ($_POST['update-profile'])) {
    /* Sanitizing the input from the form. */
    $first_name = sanitizeInput($_POST['fname']);
    // Convert into title case.
    $first_name = ucwords($first_name);
    $last_name = sanitizeInput($_POST['lname']);
    $last_name = ucwords($last_name);
    /* Sanitizing the input from the form. */
    $email = sanitizeInput($_POST['email']);
    $date_of_birth = ($_POST['dob']);
    if($_FILES['pic']['name'] != ""){
        $target_dir = "users/";
        $target_file = $target_dir . basename($_FILES["pic"]["name"]);
        move_uploaded_file($_FILES["pic"]["tmp_name"], $target_file);
        $display_picture = $target_file;
    }else{
        $display_picture = $_POST['pic_data'];
    }
    $id = $_POST['id'];

    $profile = updateProfile($connection, $first_name, $last_name, $email, $date_of_birth, $display_picture, $id);
    if($profile){
        header("Location:../profile.php");
    }

}