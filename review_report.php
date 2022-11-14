<?php

include 'config.php';

if($_SESSION['logged_in'] == false && $_SESSION['is_admin'] == 0) {
    header("Location: login.php");
}
include_once "header.php";
include_once "navbar.php";
include_once "sidebar.php";

function getAllReport($connection) {
    /* Selecting all the data from the category table. */
    $sql = "SELECT * FROM `report` WHERE is_reviewed = 0";
    /* Preparing the SQL statement. */
    $statement = $connection->prepare($sql);
    /* Executing the SQL statement. */
    $statement->execute();
    /* Getting the result of the SQL statement. */
    $result = $statement->get_result();
    /* Creating an empty array. */
    $report = array();
    /* Fetching the data from the database and putting it into an array. */
    $count = $result->num_rows;
    if($count > 0) {
        while ($row = $result->fetch_assoc()) {
            $report[] = $row;
        }
    }

    /* Returning the array of categories. */
    return $report;
}


?>

    <table class="table table-striped" id="reportTable">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Reason Type</th>
            <th scope="col">Reason</th>
            <th scope="col">Resources</th>
            <th scope="col">Date</th>
            <th scope="col">Status</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $reports = getAllReport($connection);
        $sn = 0;
        ?>
        <?php
            foreach($reports as $report){
                $sn ++;
        ?>
        <tr>
            <th scope="row"><?php echo $sn; ?></th>
            <td><?php echo $report['type']; ?></td>
            <td><?php echo $report['reason']; ?></td>
            <td><a href="card.php?resource_id=<?php echo $report['resource_id']; ?>">Visit Resource</a></td>
            <td><?php echo $report['created_at']; ?></td>
            <td><a href="form_handlers/report_view.php?resource_id=<?php echo $report['resource_id']; ?>"><button class="btn btn-sm btn-success">Done review</button></a></td>
        </tr>
        <?php
            }
            ?>
        </tbody>
    </table>
</div>
</div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>

<script>
$(document).ready(function () {
    $('#reportTable').DataTable();
});
</script>
