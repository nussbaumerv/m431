<?php
include("alert.php");
include("connect.php");
include("menu.php");
$uid = $_COOKIE['uid'];

if ($uid) {
    $sql = "SELECT * FROM users WHERE id = '$uid'";
    $result = mysqli_query($connect, $sql);
    if (!$result) {
        echo "<script> alert('Daten konnten nicht geladen Werden.'); </script>";
    }

    $row = mysqli_fetch_assoc($result);

    if ($row['token'] != $_COOKIE['token']) {
        header("Location: login.php");
    }
} else {
    header("Location: login.php");
}

if (isset($_POST['submit_pwd'])) {
    $password = $_POST['password'];
    $password = password_hash($password, PASSWORD_DEFAULT);

    $sql_update = "UPDATE users SET password = '$password' WHERE id = '$uid'";
    $result_update = mysqli_query($connect, $sql_update);
    if ($result_update) {
        echo "<script>createAlert('Password sucessfuly changed'); </script>";
        header("Location: logout.php");
    } else {
        echo "<script>createAlert('Something went wrong'); </script>";
    }
}
if (isset($_POST['submit_email'])) {
    $email = $_POST['email'];

    $sql_update = "UPDATE users SET email = '$email' WHERE id = '$uid'";
    $result_update = mysqli_query($connect, $sql_update);
    if ($result_update) {
        echo "<script>createAlert('Email sucessfuly changed'); </script>";
    } else {
        echo "<script>createAlert('Something went wrong'); </script>";
    }
}

if (isset($_POST['submit_user'])) {
    $user = $_POST['user'];

    $sql_update = "UPDATE users SET username = '$user' WHERE id = '$uid'";
    $result_update = mysqli_query($connect, $sql_update);
    if ($result_update) {
        echo "<script>createAlert('Username sucessfuly changed'); </script>";
    } else {
        echo "<script>createAlert('Something went wrong'); </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include("header.html"); ?>
    <title>Settings</title>
    <style>
        #logout {
            background-color: orange;
            text-decoration: none;
            color: black;
        }
    </style>
</head>

<body>
    <br>
    <h1>Settings</h1>
    <br>
    <h3>Passwort ändern</h3>
    <br>
    <form method="post">
        <input placeholder="Password" class="send_input" type="password" name="password" required> <br>
        <button class="send_button" name="submit_pwd" type="submit">Send</button>
    </form>
    <br>

    <h3>Username ändern</h3>
    <br>
    <form method="post">
        <input placeholder="Username" class="send_input" type="text" name="user" required> <br>
        <button class="send_button" name="submit_user" type="submit">Send</button>
    </form>
    <br>

    <h3>Email ändern</h3>
    <br>
    <form method="post">
        <input placeholder="Email" class="send_input" type="email" name="email" required> <br>
        <button class="send_button" name="submit_email" type="submit">Send</button>
    </form>

    <br><br>
    <a href="logout.php" id="logout" class="send_button">Logout</a>

</body>

</html>