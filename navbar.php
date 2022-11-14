<?php
$category_sql = "SELECT * FROM `category` ";
/* Preparing the SQL statement. */
$category_statement = $connection->prepare($category_sql);
/* Executing the SQL statement. */
$category_statement->execute();
/* Getting the result of the SQL statement. */
$category_result = $category_statement->get_result();
/* Creating an empty array. */
$categories = array();
while ($row = $category_result->fetch_assoc()) {
    $categories[] = $row;
}
/* Fetching the data from the database and putting it into an array. */
//$count = $result->num_rows;
//if($count > 0) {
//    while ($row = $result->fetch_assoc()) {
//        $resources[] = $row;
//    }
//}
//else{
//    echo "<br><h3>No results found</h3>";
//}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Study Buddy</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="icon" href="assets/images/logonobg.png" type="image/x-icon">
    <!--adds icon in the title-->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css" />
<!--    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>-->
<!--    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="index.php">
        <img src="assets/images/logonobg.png" width="50" height="60" class="d-inline-block align-top" alt="">
        <b class="brand"> Study Buddy</b>
    </a>
    <button
        class="navbar-toggler"
        type="button"
        data-toggle="collapse"
        data-target="#navbarNavDropdown"
        aria-controls="navbarNavDropdown"
        aria-expanded="false"
        aria-label="Toggle navigation"
    >
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
            <?php
            foreach ($categories as $category) {
            ?>

            <li class="nav-item">
                <a class="nav-link" href="category.php?category_id=<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></a>
            </li>


            <?php
            }
            ?>
        </ul>
    </div>
    <div>
        <a class="nav-link" href="upload_resource.php"><button class="btn btn-sm btn-primary">Upload</button></a>
    </div>
    <form class="form-inline" action="search.php" method="get">
        <input
            class="form-control mr-sm-2"
            type="search"
            placeholder="Search"
            aria-label="Search"
            name="q"
        />
        <button
            class="btn btn-outline-success my-2 my-sm-0"
            type="submit"
        >
            Search
        </button>
    </form>
    &nbsp;
    <?php if(isset($_SESSION['user_id'])) { ?>
    <div class="dropdown">
        <button class="btn btn-outline-success dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?php echo $_SESSION['full_name']; ?>
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="profile.php">Profile</a>
            <?php if($_SESSION['is_admin'] == 1) { ?>
            <a class="dropdown-item" href="admin_dashboard.php">Visit Admin</a>
            <?php } ?>
            <a class="dropdown-item" href="form_handlers/logout_handler.php">Logout</a>
        </div>
    </div>
    <?php } else {
        echo '&nbsp;<a href="login.php"><button class="btn btn-outline-success" type="button">Login</button></a>';
    } ?>

</nav>
<?php if(isset($_SESSION['success_msg'])) {
    $success_msg = $_SESSION['success_msg'];
    $title = $_SESSION['title_msg'];
    unset($_SESSION['success_msg']);
    unset($_SESSION['title_msg']);
    ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong><?php echo $title; ?>!</strong> <?php echo $success_msg; ?>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<?php } elseif (isset($_SESSION['error_msg'])){
    $error_msg = $_SESSION['error_msg'];
    $title = $_SESSION['title_msg'];
    unset($_SESSION['error_msg']);
    unset($_SESSION['title_msg']);
    ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong><?php echo $title; ?>!</strong> <?php echo $error_msg; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php } ?>

</body>
</html>
