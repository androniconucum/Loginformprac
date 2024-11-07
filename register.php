<?php
   session_start();
   include 'db.php';

   if(isset($_POST['submit'])) {
    $username = $_POST['username']; 
    $password = $_POST['password'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    if(empty($username) || empty($password) || empty($email) || empty($role)) {
        $error = "All fields are required";
    }
    elseif(!preg_match("/^(?=.*[A-Z])(?=.*\d)/", $username)) {
        $error = "username must have a capital letter and a number";
    }
    elseif(!preg_match("/^(?=.*[A-Z])(?=.*\d)(?=.*[@._!?\/])/", $password)) {
        $error = "password must contain a capital letter, a number, and a special character";
    }
    else {
        $checkusername = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
        $checkEmail = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");

        if(mysqli_num_rows($checkusername) > 0) {
            $error = "username already used";
        }
        elseif(mysqli_num_rows($checkEmail) > 0) {
            $error = "email already registered";
        }
        else {
            $hashPassword = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users(username, password, email, role) VALUES ('$username', '$hashPassword', '$email', '$role')";

            if(mysqli_query($conn, $sql)) {
                $_SESSION['success'] = "Registered successful";
                header("Location: register.php");
                exit();
            }
            else {
                $error = "Error: " . mysqli_error($conn);
            }
        }
    }
   }

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My login form</title>
</head>
<body>
    <div>
        Welcome to my login form
    </div>
    <?php
    if(isset($error)) {
    ?>
    <div class="error"><?php
    echo $error;
    ?></div>
    <?php } ?>

    <?php 
    if(isset($_SESSION['success'])) {
    ?>
    <div class="success"><?php echo $_SESSION['success']; unset($_SESSION['success']) ?></div>
    <?php } ?>
    <form method="post">
        <input type="text" name="username" id="username" placeholder="Insert Username">
        <input type="password" name="password" id="password" placeholder="Insert Password">
        <input type="email" name="email" id="email" placeholder="Insert Email">
        <select name="role" id="role">
            <option value="">Select Role</option>
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select>
        <button type="submit" name="submit">Register</button>
    </form>
    <div><p>already have an account?<a href="login.php">Login here</a></p></div>
</body>
</html>