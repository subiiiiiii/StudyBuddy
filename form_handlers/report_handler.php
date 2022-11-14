<?php
require_once "../config.php";
require_once "utils.php";

function report($connection, $resource_id, $user_id, $type, $reason)
{
    $reportSQL = "INSERT INTO `report` (`resource_id`, `user_id`, `type`, `reason`) VALUES (?, ?, ?, ?)";
    $reportStatement = $connection->prepare($reportSQL);
    $reportStatement->bind_param('iiss', $resource_id, $user_id, $type, $reason);
    $reportStatement->execute();
    return $reportStatement;
}


if (isset ($_POST['report'])) {
    /* Sanitizing the input from the form. */
    $resource_id = sanitizeInput($_POST['resource_id']);
    // Convert into title case.
    $resource_id = ucwords($resource_id);

    $type = sanitizeInput($_POST['type']);
    $type = ucwords($type);
    /* Sanitizing the input from the form. */
    $reason = sanitizeInput($_POST['reason']);
    $reason = ucwords($reason);

    $user_id = $_SESSION['user_id'];


    $report = report($connection, $resource_id, $user_id, $type, $reason);

    if ($report) {
        $_SESSION['success_msg'] = "Resources reported successfully.";
        $_SESSION['title_msg'] = "Report";
        header("Location:../card.php?resource_id=$resource_id");
    } else {
        $_SESSION['error_msg'] = "Failed to report";
        $_SESSION['title_msg'] = "Report";
    }
}