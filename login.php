<?php
    session_start();

    if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] ===true ) {
        if($_SESSION['role'] === 'admin') {
            header("Location: admin-dashboard.php");
        }
        else {
            header("Location: user-dashboard.php");
        }
        exit();
    }

    include 'db.php';

    if(isset($_POST['submit'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if(empty($username) || empty($password)) {
            $error = "All fields are required";
        }
        else {
            $sql = "SELECT * FROM users WHERE username = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) ===1) {
                $rows = mysqli_fetch_assoc($result);

                if(password_verify($password, $rows['password'])) {
                    $_SESSION['user_id'] = $rows['id'];
                    $_SESSION['username'] = $rows['username'];
                    $_SESSION['role'] = $rows['role'];
                    $_SESSION['logged_in'] = true;
                    
                    if($_SESSION['role'] =='admin') {
                        header("Location: admin-dashboard.php");
                    }
                    else{
                        header("Location: user-dashboard.php");
                    }
                    exit();
                }
                else {
                    $error = "Wrong Password";
                }
            }
            else {
                $error = "Username does not exist";
            }
        }
    }




?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login form</title>
</head>
<body>
    <div>
       <p> Login Account</p>
    </div>
    <?php
        if(isset($error)) {
    ?>
    <div><?php
    echo $error; 
    ?></div>
    <?php }?>
    
    <?php 
    if(isset($_SESSION['success'])) { ?>
    <div><?php
        echo $_SESSION['success']; unset($_SESSION['success']);
    ?></div>
    <?php }?>
    <form method="post">
        <input type="text" name="username" id="username" placeholder="Input username">
        <input type="text" name="password" id="password" placeholder="Input password">
        <button type="submit" name="submit">Login</button>
    </form>
    <a href="logout.php">Logout</a>
</body>
</html>