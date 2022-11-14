<?php
require_once "config.php";
include_once "header.php";
include_once "navbar.php";
if(!isset($_SESSION['logged_in'])){
    header('Location:login.php');
}

function getAllCategories($connection) {
    /* Selecting all the data from the category table. */
    $sql = "SELECT * FROM `category`";
    /* Preparing the SQL statement. */
    $statement = $connection->prepare($sql);
    /* Executing the SQL statement. */
    $statement->execute();
    /* Getting the result of the SQL statement. */
    $result = $statement->get_result();
    /* Creating an empty array. */
    $categories = array();
    /* Fetching the data from the database and putting it into an array. */
    while ($row = $result->fetch_assoc()) {
        /* Adding the row to the array. */
        $categories[] = $row;
    }
    /* Returning the array of categories. */
    return $categories;
}
?>


<div class="container my-4">
    <h3 class="h3">Upload Study Resource</h3>
    <form method="post" action="form_handlers/upload_resource_handler.php" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" aria-describedby="titleHelp" placeholder="Enter title" name="title" required>
            <small id="titleHelp" class="form-text text-muted">Some help text about title</small>
        </div>
        <div class="form-group">
            <label for="category">Category</label>
            <select class="form-control" id="category" aria-describedby="categoryHelp" placeholder="Select a category" name="category" required>
                <option value="" disabled selected >Select a category</option>
                <?php
                /* Getting the array of categories. */
                $categories = getAllCategories($connection);
                /* Looping through the array of categories. */
                foreach ($categories as $category) {
                    /* Printing the category. */
                    echo "<option value='" . $category['category_id'] . "'>" . $category['name'] . "</option>";
                }
                ?>
            </select>
            <small id="categoryHelp" class="form-text text-muted">Some help text about category</small>
        </div>
        <div class="form-group">
            <label for="subject">Subject</label>
            <input type="text" class="form-control" id="subject" aria-describedby="subjectHelp" placeholder="Enter the subject" name="subject" required>
            <small id="subjectHelp" class="form-text text-muted">Please enter the full form of the subject.</small>
        </div>
        <div class="form-group">
            <label for="short_description">Short Description</label>
            <input type="text" class="form-control" id="short_description" aria-describedby="short_descriptionHelp" placeholder="Enter short description" name="short_description" required>
            <small id="short_descriptionHelp" class="form-text text-muted">Please specify the institution/university if your resource is specific to them.</small>
        </div>
        <div class="form-group">
            <label for="long_description">Long Description</label>
            <input type="text" class="form-control" id="long_description" aria-describedby="long_descriptionHelp" placeholder="Enter long description" name="long_description">
            <small id="long_descriptionHelp" class="form-text text-muted">"Describe about your resource"</small>
        </div>
        <div class="form-group">
            <label for="file">Resource File</label>
            <input type="file" class="form-control-file" id="file" name="resource_file">
            <small id="fileHelp" class="form-text text-muted">Files may be PDF, JPG, PNG, EPUB</small>
        </div>
        <div class="form-group">
            <label for="author">Name of Author</label>
            <input type="text" class="form-control" id="author" aria-describedby="authorHelp" placeholder="Enter author" name="authors">
            <small id="short_descriptionHelp" class="form-text text-muted">Separate authors by comma</small>
        </div>
        <div class="form-group">
            <label for="header_image">Header Image</label>
            <input type="file" class="form-control-file" id="header_image" name="header_image">
            <small id="imageHelp" class="form-text text-muted">This image will be shown at the front of the resource</small>
        </div>
        <input type="submit" class="btn btn-primary btn-block" value="Upload Study Resource" name="upload">
    </form>
</div>
<?php
include_once "footer.php" ?>


