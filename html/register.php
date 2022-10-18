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
        echo '<br>This email is already used.';
    } else if ($row_un['username'] != false) {
        echo '<br>This username is already used.';
    } else {

        $rooms = '[1]';
        $chat_rooms_name = '["Welcome Chat"]';
        $FA = rand(100000, 999999);
        $baseColors = [
            1 => 'r',
            2 => 'g',
            3 => 'b'
        ];
        $colorMap = [];
        $minValue = 155;
        $maxValue = 200;

        $primaryColorIndex = rand(1, 3);

        $primaryColor = $baseColors[$primaryColorIndex];
        unset($baseColors[$primaryColorIndex]);

        $colorMap[$primaryColor] = 255;

        foreach ($baseColors as $baseColor) {
            $colorMap[$baseColor] = rand($minValue, $maxValue);
        }

        krsort($colorMap);

        $rgbColor = [];
        foreach ($colorMap as $key => $value) {
            $rgbColor[$key] = $value;
        }

        $color = sprintf('#%02x%02x%02x', $rgbColor['r'], $rgbColor['g'], $rgbColor['b']);
        $sql = "INSERT INTO users (name, username, email, password, token, chat_rooms, chat_rooms_name, active, 2FA, color) VALUES ('$name', '$username', '$email', '$password', '$token','$rooms', '$chat_rooms_name', 'false', '$FA', '$color')";
        $result = mysqli_query($connect, $sql);
        if ($result) {
            $to = $email;
            $subject = "Welcome to Edu Chat";
            $message = "Thank you for registering. <br>
            Log in <a href='https://edu'chat.me/login.php'>here</a> and create your first room.";
            send_mail($to, $subject, $message);

            $to = $email;
            $subject = "Activation Code";
            $message = "Your Activation Code: <br><h2>" . $FA . "</h2> <br>
            Enter your code <a href='https://edu'chat.me/index.php'>here</a>.";
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
    <h1>Register</h1>
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