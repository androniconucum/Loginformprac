<?php
    session_start();
    include 'db.php';

    if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !==true || $_SESSION['role'] !=='user') {
        header('Location: login.php');
        exit();
    }

    include 'db.php';

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div>Hello user</div>
</body>
</html>