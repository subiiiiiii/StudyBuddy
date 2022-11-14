<?php
error_reporting(0);
include '../config.php';
if($_POST['resource_id']) {
    $resource_id = $_POST['resource_id'];
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM `vote` WHERE resource_id = $resource_id AND user_id = $user_id";
    $statement = $connection->prepare($sql);
    $statement->execute();
    $result = $statement->get_result();
    $count = $result->num_rows;
    if($count > 0) {
        $sql = "UPDATE `vote` SET vote=0 WHERE resource_id = $resource_id AND user_id = $user_id";
        $statement = $connection->prepare($sql);
        $statement->execute();

        if($statement) {
            echo $count;
        }
    } else {
        $sql = "INSERT INTO `vote` (`resource_id`, `user_id`, `vote`) VALUES ($resource_id, $user_id, 0)";
        $statement = $connection->prepare($sql);
        $statement->execute();

        if($statement) {
            echo $count;
        }
    }
}