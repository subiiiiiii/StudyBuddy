<?php
    require_once "config.php";
    require_once "form_handlers/utils.php";
    require_once "header.php";
    require_once "navbar.php";

    if(!isset($_SESSION['logged_in'])){
        header('Location:login.php');
    }

?>
<!DOCTYPE html>
<html>
<head>
    <title>Study Buddy</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/style.css" />
    <link rel="stylesheet" href="assets/css/column.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.2.0/css/fontawesome.min.css" integrity="sha384-z4tVnCr80ZcL0iufVdGQSUzNvJsKjEtqYZjiQrrYKlpGow+btDHDfQWkFjoaz/Zr" crossorigin="anonymous">
<!--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />-->
<style>
        .img-account-profile {
            height: 10rem;
        }
        .rounded-circle {
            border-radius: 50% !important;
        }
        .card {
            box-shadow: 0 0.15rem 1.75rem 0 rgb(33 40 50 / 15%);
        }
        .card .card-header {
            font-weight: 500;
        }
        .card-header:first-child {
            border-radius: 0.35rem 0.35rem 0 0;
        }
        .card-header {
            padding: 1rem 1.35rem;
            margin-bottom: 0;
            background-color: rgba(33, 40, 50, 0.03);
            border-bottom: 1px solid rgba(33, 40, 50, 0.125);
        }
        .form-control, .dataTable-input {
            display: block;
            width: 100%;
            padding: 0.875rem 1.125rem;
            font-size: 0.875rem;
            font-weight: 400;
            line-height: 1;
            color: #69707a;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #c5ccd6;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            border-radius: 0.35rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .nav-borders .nav-link.active {
            color: #0061f2;
            border-bottom-color: #0061f2;
        }
        .nav-borders .nav-link {
            color: #69707a;
            border-bottom-width: 0.125rem;
            border-bottom-style: solid;
            border-bottom-color: transparent;
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
            padding-left: 0;
            padding-right: 0;
            margin-left: 1rem;
            margin-right: 1rem;
        }
    </style>
</head>

<?php
    if (isset ($resource_id) || isset ($category) || isset($subject) || isset ($header_image) || isset ($title) || isset ($short_description) || isset ($long_description) || isset ($subject) || isset ($content) || isset ($content_extension) || isset ($created_at) || isset ($modified_at) || isset ($uploaded_by) || isset ($upvote) || isset ($downvote) )
    {
        // receive all input values from the Resource table in sql.
        $resource_id = $_GET['resource_id'];
    }
?>

<?php
    $resource_id = $_GET['resource_id'];
    $sql = "SELECT * FROM resource WHERE resource_id = '$resource_id'";
    $result = mysqli_query($connection, $sql);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

$sql_vote = "SELECT * FROM `vote` WHERE resource_id = $resource_id AND vote=1";
$statement_vote = $connection->prepare($sql_vote);
$statement_vote->execute();
$result_vote = $statement_vote->get_result();

$count_vote = $result_vote->num_rows;


$sql_downvote = "SELECT * FROM `vote` WHERE resource_id = $resource_id AND vote=0";
$statement_downvote = $connection->prepare($sql_downvote);
$statement_downvote->execute();
$result_downvote = $statement_downvote->get_result();

$count_downvote = $result_downvote->num_rows;

$sql_category = "SELECT * FROM category WHERE category_id = '".$row['category']."'";
$result_category = mysqli_query($connection, $sql_category);
$row_category = mysqli_fetch_array($result_category, MYSQLI_ASSOC);


$sql_authorres = "SELECT * FROM resourceauthor WHERE resource_id = '$resource_id'";
$result_authorres = mysqli_query($connection, $sql_authorres);
$authors = array();
while($row1 = mysqli_fetch_assoc($result_authorres)) {
    $sql_author = "SELECT * FROM author WHERE author_id = '".$row1['author_name']."'";
    $result_author = mysqli_query($connection, $sql_author);
    while($row2 = mysqli_fetch_assoc($result_author)) {
        $authors[] = $row2;
    }
}

$sql_user = "SELECT * FROM user WHERE user_id = '".$row['uploaded_by']."'";
$result_user = mysqli_query($connection, $sql_user);
$row3 = mysqli_fetch_array($result_user, MYSQLI_ASSOC);
?>

<body>
<div class="container-xl px-4 mt-4">
    <div class="row">
        <div class="col-xl-4">
            <!-- Profile picture card-->
            <div class="card mb-4 mb-xl-0">
                <div class="card-header"><?php echo $row['title']; ?></div>
                <div class="card-body">
                    <!-- Profile picture image-->
                    <img class="img-account-profile rounded-circle mb-2" src="form_handlers/<?php echo $row['header_image']; ?>" alt="">
                    <!-- Profile picture help block-->
                    <!-- Profile picture upload button-->
                    <br>
                    <span>Short Description:<b> <?php echo $row['short_description']; ?> </b> </span><br>
                    <br>
                    <span>Long Description: <?php echo $row['long_description']; ?></span><br> <br>
                    <span class="pull-right">Subject: <?php echo $row['subject']; ?></span><br>
                    <span class="pull-right">Category: <?php echo $row_category['name']; ?></span><br>
                    <span class="pull-right">Author:
                        <ul>
                        <?php

                        foreach($authors as $author) {
                            echo "<li>".$author['name']."</li>";
                        }
                        ?>
                    </ul>
                    </span>
                    <span class="pull-right">Uploaded By: <?php echo $row3['first_name']; ?> <?php echo $row3['last_name']; ?> (<?php echo $row3['title']; ?>)</span><br>
                    <?php if($row['uploaded_by'] != $_SESSION['user_id']){ ?>
                    <button type="button" class="btn btn-sm btn-danger" style="float: right" data-toggle="modal" data-target="#reportModal">
                        Report
                    </button>
                    <?php } ?>

                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <!-- Account details card-->
            <div class="card mb-4">
                <div class="card-header"><span>Resource File</span><?php if($row['uploaded_by'] == $_SESSION['user_id']){?><a href="form_handlers/deleteResource.php?resource_id=<?php echo $row['resource_id']; ?>" style="float: right">Delete</a><?php } else{ ?><div style="float: right;"> <button class="btn btn-sm btn-primary" id="upvote" data-resource_id=<?php echo $row['resource_id']; ?>><span id="count_up"><?php echo $count_vote; ?></span> Upvote</button> <button class="btn btn-sm btn-primary" id="downvote" id="downvote" data-resource_id=<?php echo $row['resource_id']; ?>><span id="count_down"><?php echo $count_downvote; ?></span> Downvote</button> </div><?php } ?></div>
                <div class="card-body">
                    <?php if($row['content_extension'] == 'pdf'){ ?>
                        <iframe src="form_handlers/<?php echo $row['content']; ?>" width="100%" height="500px"></iframe>
                    <?php } else if($row['content_extension'] == 'epub') { ?>
                        <iframe src="https://epubjs.herokuapp.com/?url=https://www.learncodeonline.in/form_handlers/<?php echo $row['content']; ?>" width="100%" height="500px"></iframe>
                    <?php } else{ ?>
                    <img src="form_handlers/<?php echo $row['content']; ?>" alt="content_extension" width="100%" height="100%">
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="reportModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Report Resources</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="form_handlers/report_handler.php" method="POST">
                    <input type="hidden" name="resource_id" value="<?php echo $row['resource_id']; ?>">
                    <div class="form-group">
                        <label for="reportReasonType" class="col-form-label">Reason Type:</label>
                        <select id="reportReasonType" name="type">
                            <option value="Intellectual Property Violation">Intellectual Property Violation</option>
                            <option value="Misguiding Information">Misguiding Information</option>
                            <option value="Inappropriate Content">Inappropriate Content</option>
                            <option value="Copyrighted Content">Copyrighted Content</option>
                            <option value="Spam">Spam</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="reportReason" class="col-form-label">Reason:</label>
                        <textarea class="form-control" id="reportReason" name="reason"></textarea>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" name="report">Report</button>
            </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function() {
    $('#upvote').click(function(e) {
        e.preventDefault();
        var resource_id = $(this).data('resource_id');
        $.ajax({
            type: "POST",
            url: 'form_handlers/upvote.php',
            data: {
                resource_id: resource_id
            },
            success: function(response)
            {
                location.reload();
           }
       });
     });
});

$(document).ready(function() {
    $('#downvote').click(function(e) {
        e.preventDefault();
        var resource_id = $(this).data('resource_id');
        $.ajax({
            type: "POST",
            url: 'form_handlers/downvote.php',
            data: {
                resource_id: resource_id
            },
            success: function(response)
            {
                location.reload();
           }
       });
     });
});
</script>
</body>
</html>