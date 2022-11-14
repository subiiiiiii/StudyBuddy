<?php

ob_start();
session_start();

$timezone = date_default_timezone_set("Asia/Kathmandu");

$host = "localhost";
$username = "root";
$password = "";
$database = "studybuddy";

$connection = new mysqli($host, $username, $password, $database);

// Check connection
if ($connection->connect_errno) {
    echo "Failed to connect to MySQL: " . $connection->connect_error;
    exit();
}
