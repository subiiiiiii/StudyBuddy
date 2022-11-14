<?php

include 'config.php';

if($_SESSION['logged_in'] == false && $_SESSION['is_admin'] == 0) {
    header("Location: login.php");
}
include_once "header.php";
include_once "navbar.php";
include_once "sidebar.php";

function getAllUser($connection) {
    /* Selecting all the data from the category table. */
    $sql = "SELECT * FROM `user`";
    /* Preparing the SQL statement. */
    $statement = $connection->prepare($sql);
    /* Executing the SQL statement. */
    $statement->execute();
    /* Getting the result of the SQL statement. */
    $result = $statement->get_result();
    /* Creating an empty array. */
    $users = array();
    /* Fetching the data from the database and putting it into an array. */
    $count = $result->num_rows;
    if($count > 0) {
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
    }

    /* Returning the array of categories. */
    return $users;
}


?>

    <table class="table table-striped" id="reportTable">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Full Name</th>
            <th scope="col">Email</th>
            <th scope="col">DOB</th>
            <th scope="col">Admin</th>
            <th scope="col">Picture</th>
            <th scope="col">Date Joined</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $users = getAllUser($connection);
        $sn = 0;
        ?>
        <?php
            foreach($users as $user){
                $sn ++;
        ?>
        <tr>
            <th scope="row"><?php echo $sn; ?></th>
            <td><?php echo $user['first_name']; ?> <?php echo $user['last_name']; ?></td>
            <td><?php echo $user['email']; ?></td>
            <td><?php echo $user['date_of_birth']; ?></td>
            <td><?php if($user['is_admin'] == 1) { echo "Admin"; } else{ echo "User"; } ?></td>
            <td><img src="form_handlers/<?php echo $user['display_picture']; ?>" width="100" height="100"></td>
            <td><?php echo $user['date_joined']; ?></td>
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
