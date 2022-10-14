<?php
include("PHPMailer/mail.php");
include "connect.php";
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password = password_hash($password, PASSWORD_DEFAULT);
    $token = openssl_random_pseudo_bytes(16);
    $token = bin2hex($token);

    $sql_select_email = "SELECT * FROM users WHERE email = '$email'";
    $result_select_email = mysqli_query($connect, $sql_select_email);
    $row_email = mysqli_fetch_assoc($result_select_email);

    $sql_select_un = "SELECT * FROM users WHERE username = '$username'";
    $result_select_un = mysqli_query($connect, $sql_select_un);
    $row_un = mysqli_fetch_assoc($result_select_un);

    if ($row_email['email'] != false) {
        echo '<br>Diese E-Mail-Adresse ist bereits vergeben';
    } else if ($row_un['username'] != false) {
        echo '<br>Dieser Username ist bereits vergeben';
    } else {

        $rooms = '[1]';
        $chat_rooms_name = '["Welcome Chat"]';
        $FA = rand(100000, 999999);
        $sql = "INSERT INTO users (name, username, email, password, token, chat_rooms, chat_rooms_name, active, 2FA) VALUES ('$name', '$username', '$email', '$password', '$token','$rooms', '$chat_rooms_name', 'false', '$FA')";
        $result = mysqli_query($connect, $sql);
        if ($result) {
            $to = $email;
            $subject = "Wilkommen bei Edu Chat";
            $message = "Vielen Dank, dass Sie sich registriert haben. <br>
            Loggen Sie sich <a href='https://edu'chat.me/login.php'>hier</a> ein und erstellen Sie Ihren ersten Room.";
            send_mail($to, $subject, $message);

            $to = $email;
            $subject = "Aktivierungs Code";
            $message = "Ihr Aktivierungs Code: " . $FA . " <br>
            Geben Sie ihren Code hier <a href='https://edu'chat.me/index.php'>hier</a> ein.";
            send_mail($to, $subject, $message);

            header("Location: login.php");
        } else {
            echo "Something went wrong";
        }
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
    <h1>Registrieren</h1>
    <br>
    <form action="" method="post">
        <input class="send_input" name="name" type="text" placeholder="Name"> <br>
        <input class="send_input" name="username" type="text" placeholder="Username"> <br>
        <input class="send_input" name="email" type="email" placeholder="Email"> <br>
        <input class="send_input" name="password" type="password" placeholder="Password"> <br>
        <input class="send_button" name="submit" type="submit">
    </form>
    ––– OR –––
    <br>
    <br>
    <br>
    <a class="send_input" href="login.php">Login</a>

</body>

</html>