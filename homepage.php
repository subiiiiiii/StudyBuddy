<?php
require_once "config.php";
include_once "header.php";
include_once "navbar.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>study Buddy</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/style.css" />
</head>
<?php
require_once "config.php";
require_once "form_handlers/utils.php";
?>
<?php
if (isset ($resource_id) || isset ($category) || isset(subject) || isset ($header_image) || isset ($title) || isset ($short_description) || isset ($long_description) || isset ($subject) || isset ($content) || isset ($content_extension) || isset ($created_at) || isset ($modified_at) || isset ($uploaded_by) || isset ($upvote) || isset ($downvote) )
{
    // receive all input values from the Resource table in sql.
    $resource_id = $_GET['resource_id'];
    $category = $_GET['category'];
    $subject = $_GET['subject'];
    $header_image = $_GET['header_image'];
    $title = $_GET['title'];
    $short_description = $_GET['short_description'];
    $long_description = $_GET['long_description'];
    $subject = $_GET['subject'];
    $content = $_GET['content'];
    $content_extension = $_GET['content_extension'];
    $created_at = $_GET['created_at'];
    $modified_at = $_GET['modified_at'];
    $uploaded_by = $_GET['uploaded_by'];
    $upvote = $_GET['upvote'];
    $downvote = $_GET['downvote'];
}
?>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="file:///C:/Users/user/Desktop/login%20page/homepage.html">
        <img src="logo-removebg-preview.png" width="35" height="40" class="d-inline-block align-top" alt="">
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
            <li class="nav-item active">
                <a class="nav-link" href="#"
                >Home <span class="sr-only">(current)</span></a
                >
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Study Notes</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Textbooks</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Syllabus</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Past Papers</a>
    </div>
    <form class="form-inline">
        <input
            class="form-control mr-sm-2"
            type="search"
            placeholder="Search"
            aria-label="Search"
        />
        <button
            class="btn btn-outline-success my-2 my-sm-0"
            type="submit"
        >
            Search
        </button>
        </div>
        </li>
        </ul>
        </div>
</nav>
<div class="container">

    <div class="card shadow rounded-lg">
        <div class="row">
            <div class="col-1">
                <div class="m-3">
                    <a href="file:///C:/Users/user/Desktop/login%20page/profile.html">
                        <img src="login.png" alt="Image avatar" class="avatar shadow" width="80%"/></a>
                </div>
                <div class="ml-4" style="margin-top: 4rem;">
                    <form>
                        <input type="hidden" name="resource_id">
                        <button class="">
                            <i class="fa-solid fa-square-caret-up"></i>
                        </button>
                    </form>
                    <p class="my-2 font-weight-bold">576</p>
                    <form>
                        <input type="hidden" name="resource_id">
                        <button class="">
                            <i class="fa-solid fa-square-caret-down"></i>
                        </button>
                    </form>
                </div>

            </div>
            <div class="col-11" style="padding:0;">
                <div class="card-body">
                    <a href="file:///C:/Users/user/Desktop/login%20page/profile.html">
                        <div class="box" <h5 class="user">Anusha Pokharel</h5>
                    </a>
                    <p class="card-text"><small class="text-muted">12:00 10 December 2022</small></p>
                </div>
                <div class="card-body" style="text-align:right;"><input type="button" value="Delete" onclick="return confirm('Are you sure you want to delete?');"/> </div>

                <img class="card-img-top" src="userimg.png" alt="Card image cap" width="200" height="300">
                <div class="card-body">
                    <h5 class="file-title">File title</h5>
                    <p class="card-text"><small class="text-muted">Authors</small></p>
                    <p class="card-text">This is a wider card with supporting text below as a natural lead-in to
                        additional
                        content. This content is a little bit longer.</p>
                    <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
