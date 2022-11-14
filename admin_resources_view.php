<?php

include 'config.php';

if($_SESSION['logged_in'] == false && $_SESSION['is_admin'] == 0) {
    header("Location: login.php");
}
include_once "header.php";
include_once "navbar.php";
include_once "sidebar.php";

function getAllResources($connection) {
    /* Selecting all the data from the category table. */
    $sql = "SELECT * FROM `resource`";
    /* Preparing the SQL statement. */
    $statement = $connection->prepare($sql);
    /* Executing the SQL statement. */
    $statement->execute();
    /* Getting the result of the SQL statement. */
    $result = $statement->get_result();
    /* Creating an empty array. */
    $resources = array();
    /* Fetching the data from the database and putting it into an array. */
    $count = $result->num_rows;
    if($count > 0) {
        while ($row = $result->fetch_assoc()) {
            $resources[] = $row;
        }
    }

    /* Returning the array of categories. */
    return $resources;
}


?>

    <table class="table table-striped" id="reportTable">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Title</th>
            <th scope="col">Short Description</th>
            <th scope="col">Visit Resources</th>
            <th scope="col">Picture</th>
            <th scope="col">Delete</th>
            <th scope="col">Created</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $resources = getAllResources($connection);
        $sn = 0;
        ?>
        <?php
            foreach($resources as $resource){
                $sn ++;
        ?>
        <tr>
            <th scope="row"><?php echo $sn; ?></th>
            <td><?php echo $resource['title']; ?></td>
            <td><?php echo $resource['short_description']; ?></td>
            <td><a href="card.php?resource_id=<?php echo $resource['resource_id']; ?>">Visit Resource</a></td>
            <td><img src="form_handlers/<?php echo $resource['header_image']; ?>" width="100" height="100"></td>
            <td><a href="form_handlers/deleteResource.php?redirect=admin&resource_id=<?php echo $resource['resource_id']; ?>"><button class="btn btn-sm btn-danger">Delete</button></a></td>
            <td><?php echo $resource['created_at']; ?></td>
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
