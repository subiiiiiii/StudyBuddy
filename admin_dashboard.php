<?php

include 'config.php';

if($_SESSION['logged_in'] == false && $_SESSION['is_admin'] == 0) {
    header("Location: login.php");
}
include_once "header.php";
include_once "navbar.php";
include_once "sidebar.php";

$sql_report = "SELECT * FROM `report` WHERE is_reviewed = 0";
/* Preparing the SQL statement. */
$statement_report = $connection->prepare($sql_report);
/* Executing the SQL statement. */
$statement_report->execute();
/* Getting the result of the SQL statement. */
$result_report = $statement_report->get_result();
/* Fetching the data from the database and putting it into an array. */
$count_report = $result_report->num_rows;



$sql_report_done = "SELECT * FROM `report` WHERE is_reviewed = 1";
/* Preparing the SQL statement. */
$statement_report_done = $connection->prepare($sql_report_done);
/* Executing the SQL statement. */
$statement_report_done->execute();
/* Getting the result of the SQL statement. */
$result_report_done = $statement_report_done->get_result();
/* Fetching the data from the database and putting it into an array. */
$count_report_done = $result_report_done->num_rows;


$sql_user = "SELECT * FROM `user`";
/* Preparing the SQL statement. */
$statement_user = $connection->prepare($sql_user);
/* Executing the SQL statement. */
$statement_user->execute();
/* Getting the result of the SQL statement. */
$result_user = $statement_user->get_result();
/* Fetching the data from the database and putting it into an array. */
$count_user = $result_user->num_rows;


$sql_resource = "SELECT * FROM `resource`";
/* Preparing the SQL statement. */
$statement_resource = $connection->prepare($sql_resource);
/* Executing the SQL statement. */
$statement_resource->execute();
/* Getting the result of the SQL statement. */
$result_resource = $statement_resource->get_result();
/* Fetching the data from the database and putting it into an array. */
$count_resource = $result_resource->num_rows;



?>

<div class="row">
    <div class="col-3" style="background-color: lightgreen; color: white; padding: 70px; margin: 20px;">
        <div class="row">
            <div class="col-4"><h2 class="text-white"><?php echo $count_user; ?></h2></div>
            <div class="col-8"><h3 class="text-white">All Users</h3></div>
        </div>
    </div>
    <div class="col-4" style="background-color: lightblue; color: white; padding: 70px; margin: 20px;">
        <div class="row">
            <div class="col-4"><h2 class="text-white"><?php echo $count_resource; ?></div>
            <div class="col-8"><h3 class="text-white">All Resources</h3></div>
        </div>
    </div>
    <div class="col-3" style="background-color: lightsalmon; color: white; padding: 70px; margin: 20px;">
        <div class="row">
            <div class="col-4"><h2 class="text-white"><?php echo $count_report; ?></div>
            <div class="col-8"> <h3 class="text-white">Resources Report</h3></div>
        </div>
    </div>
    <div class="col-3" style="background-color: lightcoral; color: white; padding: 70px; margin: 20px;">
        <div class="row">
            <div class="col-4"><h2 class="text-white"><?php echo $count_report_done; ?></div>
            <div class="col-8"><h3 class="text-white">Resources Report view</h3></div>
        </div>
    </div>
</div>

</div>
</div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>


