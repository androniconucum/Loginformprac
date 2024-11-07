<?php
    session_start();

    if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !==true || $_SESSION['role'] !=='admin') {
        header("Location: login.php");
        exit();
    }

    include 'db.php';

    $sql = "SELECT * FROM USERS";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_all($result, MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
        <div>Hello</div>
        <a href="logout.php">Logout</a>
        <table>
            <thread>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thread>
            <tbody>
                <?php foreach($user as $user) { ?>
                    <tr>
                        <td><?php echo $user['id']; ?></td>
                        <td><?php echo $user['username']?></td>
                        <td><?php echo $user['password']?></td>
                        <td><?php echo $user['role']?></td>
                        
                    </tr>
                    <?php } ?>
            </tbody>
        </table>
</body>
</html>