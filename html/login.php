<?php
session_start();
include("PHPMailer/mail.php");
include("connect.php");

if ($_SESSION['uid']) {
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
        $subject = "Neues Login";
        $message = "Am " . $date . " um " . $time . " loggte sich ein User mit der IP Adresse " . $ip . " erfolgreich in Ihren Account ein. <br>
        Fals Sie dies nicht waren ändern Sie bitte sofort Ihr Passwort in den <a href='https://edu'chat.me/settings.php'>einstellungen</a>.";
        send_mail($to, $subject, $message);
        setcookie('token', $row['token'], time() + (86400 * 30), "/");
        setcookie('uid', $row['id'], time() + (86400 * 30), "/");
        
        header("Location: index.php");
    } else {
        echo '<fc><br>Falsches Passwort</fc>
    <script> document.getElementById("pw").value = "";
    document.getElementById("pw").placeholder = "Falsches Passwort"; </script>';
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
    <a class="send_button" href="register.php">Registrieren</a>

</body>

</html>