<?php 
    session_start();
    include 'db.php';

        if(isset($_POST['submit'])) {
            $username = $_POST['username'];
            $password  = $_POST['password'];
            $email = $_POST['email'];

            if(empty($username) || empty($password) || empty($email)) {
                $error = "All fields are required";
            }
            elseif(!preg_match("/^(?=.*[A-Z])(?=.*\d)/", $username)) {
                $error = "Username must contain an uppercase letter and a number";
            }
            elseif(!preg_match("/^(?=.*[A-Z])(?=.*\d)(?=.*[-@.!_\/*&%]).{8,}$/", $password)) {
                $error = "Password must contain an uppercase letter, number, and special character";
            }
            else {
                $checkUsername = mysqli_query($conn, "SELECT * FROM users WHERE username  = '$username'");
                $checkEmail = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");

                if(mysqli_num_rows($checkUsername) > 0) {
                    $error = "Username already taken";
                }
                elseif(mysqli_num_rows($checkEmail) > 0) {
                    $error = "Email aready used";
                }
                else {
                    $hashPassword = password_hash($password, PASSWORD_DEFAULT);
                    $sql = "INSERT INTO users(username, password, email) VALUES('$username', '$hashPassword', '$email')";
                }

                if(mysqli_query($conn, $sql)) {
                    $_SESSION['success'] = "Registration successful";
                    header("Location: register.php");
                    exit();
                }
                else {
                    $error = "Error:" . mysqli_error($conn);
                }
            }
            }
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nico's Login Form</title>
</head>
<body>
    <div>My Login Form</div>
    <?php
        if(isset($error)) { 
    ?>
    <div class="error"><?php
        echo $error;
     ?></div>
     <?php
        } 
     ?>
     <?php 
        if(isset($_SESSION['success'])) {
     ?>
     <div class="success"><?php
        echo $_SESSION['success']; unset($_SESSION['success']);
     ?></div>
     <?php } ?>
    <form method="post">
        <input type="text" name="username" id="username" placeholder="Username">
        <input type="password" name="password" id="password" placeholder="Password">
        <input type="email" name="email" id="email" placeholder="Email">
        <button type="submit" name="submit">Register</button>
    </form>
</body>
</html>