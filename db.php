<?php
$hostname = "localhost";
$username = "root";
$password = "december12";
$dbname = "practice";

$conn = mysqli_connect($hostname, $username, $password, $dbname);

if (!$conn) {
    die("Connection error" . mysqli_connect_error());
}


?> 