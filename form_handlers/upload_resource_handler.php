<?php
require_once "../config.php";
require_once "utils.php";


function validateTitle($value)
{
    /* Checking if the title is not empty. */
    if (empty($value)) {
        return " Title is required.";
    }
    if (!preg_match("/^[a-zA-Z0-9 ']$/", $value)) {
        return "Title must contain only english letters, numbers, 's and spaces.";
    }
    if (strlen($value) > 100) {
        return "Title must be less than 100 characters long.";
    }
    return "";
}

function validateCategory($value)
{
    /* Checking if the category is not empty. */
    if (empty($value)) {
        return " Please select a category.";
    }
    return "";
}
function validateSubject($value)
{
    /* Checking if the subject is not empty. */
    if (empty($value)) {
        return " Please enter the subject.";
    }
    return "";
}

function validateShortDescription($value)
{

    /* Checking if the short description is not empty. */
    if (empty($value)) {
        return " Short description is required.";
    }
    if (!preg_match("/^[a-zA-Z0-9-, '.]*$/", $value)) {
        return "Short description must contain only english letters, numbers, hyphen, commas, 's and spaces.";
    }
    //to check if the short description is less than or equal to 500 characters.
    if (strlen($value) > 500) {
        return "Short description must be less than or equal to 500 characters.";
    }
    return "";
}

function validateLongDescription($value)
{
    $longDescription = sanitizeInput($value);
//    if (!preg_match("/^[a-zA-Z0-9 ']*$/", $value))
//    {
//        return "Long description must contain only english letters, numbers, 's and spaces.";
//    }
    return "";
}


function validateFileOrLongDescription($longDescription, $file)
{
    /**
     * If the long description is empty and the file is empty, return an error message. If the file is not empty, check the
     * file extension. If the file extension is not allowed, return an error message.
     *
     * @param longDescription The long description of the book.
     * @param file The file to be uploaded.
     *
     * @return the error message.
     */
    if (empty($longDescription) && empty($file)) {
        return "Please enter either a long description or a file.";
    }
    // If file is not empty, check for the file extension.
    if (!empty($file)) {
        $ACCEPTABLE_FILE_EXTENSIONS = array("jpg", "jpeg", "png", "pdf", "epub");
        $file_extension = pathinfo($file, PATHINFO_EXTENSION);
//        Convert the file extension to lower case.
        $file_extension = strtolower($file_extension);
        if (!in_array($file_extension, $ACCEPTABLE_FILE_EXTENSIONS)) {
            return "File extension is not allowed.";
        }
    }
    return "";
}

function validateHeaderImage($file)
{
    /**
     * If the file is not empty, check for the file extension. If the file extension is not allowed, return an error
     * message.
     *
     * @param file The file to be uploaded.
     *
     * @return the error message.
     */
    if (!empty($file)) {
        $ACCEPTABLE_FILE_EXTENSIONS = array("jpg", "jpeg", "png");
        $file_extension = pathinfo($file, PATHINFO_EXTENSION);
//        Convert the file extension to lower case.
        $file_extension = strtolower($file_extension);
        if (!in_array($file_extension, $ACCEPTABLE_FILE_EXTENSIONS)) {
            return "File extension is not allowed.";
        }
    }
    return "";
}

function splitAuthors($value)
{
    /* Splitting the string into an array. */
    $authors = explode(",", $value);
    /* Creating an empty array. */
    $sanitized_authors = array();
    foreach ($authors as $author) {
        /* Sanitizing the author's name. */
        $_author = sanitizeInput($author);
        /* Checking if the author is not empty. */
        if ($_author != "") {
            /* Adding the sanitized author to the array. */
            $sanitized_authors[] = ucwords($_author);
        }
    }
    return $sanitized_authors;
}

function validateAuthors($value)
{
    /* Checking if the authors is not empty. */
    if (empty($value)) {
        return " Authors is required.";
    }
    if (!preg_match("/^[a-zA-Z0-9 ']*$/", $value)) {
        return "Authors must contain only english letters, numbers, 's and spaces.";
    }
    return "";
}

function createAuthors($connection, $list_of_authors)
{
    /* Creating a SQL statement that will insert a new author into the database. */
    $create_author_sql = "INSERT INTO author (name) VALUES (?)";
    /* Preparing the SQL statement. */
    $create_author_statement = $connection->prepare($create_author_sql);
    /* Creating an empty array. */
    $inserted_authors = array();
    /* Looping through the array of authors. */
    foreach ($list_of_authors as $author) {
        /* Executing the SQL statement. */
        $create_author_statement->execute([$author]);
        $last_id = uniqid();
        /* Getting the last inserted id. */
        $inserted_authors[] = $connection->insert_id;
    }
    return $inserted_authors;
}


/**
 * It takes in a bunch of parameters, creates a SQL statement, prepares the SQL statement, executes the SQL statement, gets
 * the last inserted id, creates another SQL statement, prepares the SQL statement, loops through the array of authors, and
 * then returns the resource id.
 *
 * @param connection The connection to the database.
 * @param title The title of the resource.
 * @param category The category of the resource.
 * @param short_description This is a short description of the resource.
 * @param long_description This is the long description of the resource.
 * @param content The content of the resource.
 * @param content_extension The extension of the file that was uploaded.
 * @param uploaded_by The id of the user who uploaded the resource.
 */
function uploadResource($connection, $title, $category,$target_file, $subject, $short_description, $long_description, $content, $content_extension, $uploaded_by)
{
    /* Creating a SQL statement that will insert a new resource into the database. */
    $create_resource_sql = "INSERT INTO resource (title, category,header_image, subject, short_description, long_description, content, content_extension, uploaded_by) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    /* Preparing the SQL statement. */

    $create_resource_statement = $connection->prepare($create_resource_sql);
    /* Executing the SQL statement. */
    $create_resource_statement->bind_param("sissssssi", $title, $category, $target_file, $subject, $short_description, $long_description, $content, $content_extension, $uploaded_by);
    $create_resource_statement->execute();
    $resource_id = $connection->insert_id;
    return $resource_id;
}

function createResourceAuthors($connection, $resource_id, $list_of_authors)
{
    /* Creating a SQL statement that will insert a new author-resource relationship into the database. */
    $create_author_resource_sql = "INSERT INTO resourceauthor (resource_id, author_name) VALUES (?, ?)";
    /* Preparing the SQL statement. */
    $create_author_resource_statement = $connection->prepare($create_author_resource_sql);
    /* Looping through the array of authors. */
    foreach ($list_of_authors as $author) {
        /* Executing the SQL statement. */
        $create_author_resource_statement->execute([ $resource_id, $author]);
    }
}


if (isset($_POST['upload'])) {

    //    Extract all the data from the form.
    $title = ucwords($_POST['title']);
    $category = $_POST['category'];
    /* Sanitizing the input from the form. */
    $subject = sanitizeInput($_POST['subject']);
    $short_description = sanitizeInput($_POST['short_description']);
    $long_description = $_POST['long_description'];
    $authors = $_POST['authors'];
    $resource_file = $_FILES['resource_file'];
    $header_image = $_FILES['header_image'];


    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["header_image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $check = getimagesize($_FILES["header_image"]["tmp_name"]);
    move_uploaded_file($_FILES["header_image"]["tmp_name"], $target_file);


    $target_dir_resources = "resources/";
    $target_file_resources = $target_dir_resources . basename($_FILES["resource_file"]["name"]);
    move_uploaded_file($_FILES["resource_file"]["tmp_name"], $target_file_resources);


    // Getting the extension of the resource file.
    $resource_file_extension = pathinfo($resource_file['name'], PATHINFO_EXTENSION);

    // Getting the user from the session.
    $uploaded_by = $_SESSION['user_id'];

    $created_authors = createAuthors($connection, splitAuthors($authors));

    $resource_id = uploadResource(
        $connection,
        $title,
        $category,
        $target_file,
        $subject,
        $short_description,
        $long_description,
        $target_file_resources,
        $resource_file_extension,
        $uploaded_by
    );


    createResourceAuthors($connection, $resource_id, $created_authors);
    $_SESSION['success_msg'] = "Resource uploaded successfully.";
    $_SESSION['title_msg'] = "Resources";
    header("Location: ../card.php?resource_id=$resource_id");
}


?>