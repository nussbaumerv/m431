<?php
include("PHPMailer/mail.php");
include("connect.php");

if ($_COOKIE['uid']) {
    header("Location: index.php");
}

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = '$email'";

    $result = mysqli_query($connect, $sql);

    if (!$result) {
        echo "<script> alert('Daten konnten nicht geladen Werden.'); </script>";
    }

    $row = mysqli_fetch_assoc($result);


    $pwd = $row['password'];


    if (password_verify($password, $pwd)) {
        $date = date("d/m/Y");
        $time = date("H:i:s");

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        $to = $email;
        $subject = "New Login";
        $message = "On " . $date . " at " . $time . " you sucsessfuly logged with the IP-Adress " . $ip . " into your account. <br>
        If this wasn't you please change your password immediately in the <a href='https://edu'chat.me/settings.php'>settings</a>.";
        send_mail($to, $subject, $message);
        setcookie('token', $row['token'], time() + (86400 * 30), "/");
        setcookie('uid', $row['id'], time() + (86400 * 30), "/");
        
        header("Location: index.php");
    } else {
        echo '<fc><br>Wrong Password</fc>';
    }
}

?>
<html>

<head>
    <?php include("header.html"); ?>
    <title>Edu Chat</title>
    <style>
        body {
            background-color: #dbdbdb;
        }

        h1 {
            color: rgb(100, 100, 100);
        }
    </style>

</head>

<body>
    <br>
    <h1>Login</h1>
    <br>
    <form action="" method="post">
        <input class="send_input" name="email" type="email" placeholder="Email"> <br>
        <input class="send_input"name="password" type="password" placeholder="Password"> <br>
        <input class="send_button" name="submit" type="submit">

    </form>
    ––– OR –––
    <br>
    <br>
    <br>
    <a class="send_button" href="register.php">Register</a>

</body>

</html>