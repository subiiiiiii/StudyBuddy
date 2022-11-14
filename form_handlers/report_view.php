<?php
include '../config.php';
    if($_GET['resource_id']) {

        $resource_id = $_GET['resource_id'];

        $sql = "UPDATE report SET is_reviewed=1 WHERE resource_id=?";
        $statement= $connection->prepare($sql);
        $statement->execute([$resource_id]);

        if($statement) {
            $_SESSION['success_msg'] = "Resources reviewed successfully.";
            $_SESSION['title_msg'] = "Report";
            header("Location:../review_report.php");
        } else {
            $_SESSION['error_msg'] = "Failed to reviewed resources.";
            $_SESSION['title_msg'] = "Report";
            echo "Failed to delete";
        }

        }
    else {
            echo "Failed to report";

    }

    ?>