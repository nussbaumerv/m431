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
    }
    else if($row_un['username'] != false){
        echo '<br>Dieser Username ist bereits vergeben'; 
    } else {

        $rooms = '["1"]';
        $chat_rooms_name = '["Welcome Chat"]';
        $FA = rand(100000,999999);
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
            $message = "Ihr Aktivierungs Code: ".$FA." <br>
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
    <html lang="en">
    <meta charset="utf-8" />
    <title>V-Todo</title>
    <link rel="apple-touch-icon" sizes="128x128" href="icon.png">
    <link rel="shortcut icon" href="icon.png" type="img/vnd.microsoft.icon" />
    <link rel="manifest" href="manifest.webmanifest">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            background-color: #dbdbdb;
            font-family: arial;
            margin: 0px;
            text-align: center;
        }

        input[type="email"],
        input[type="text"],
        input[type="password"] {
            border: solid;
            border-color: grey;
            margin-bottom: 1vh;
            font-size: 16px;
            opacity: 0.97;
            border-radius: 0px;
            color: grey;
            padding: 20px 70px 20px 40px;
            box-shadow: 5px 10px 18px #888888;
        }

        input[type="email"]:focus,
        input[type="text"]:focus,
        input[type="password"]:focus {
            border-radius: 0px;
            outline: none;
            background-color: rgb(220, 220, 220);
            box-shadow: 2px 4px 6px #888888;
        }

        #button {
            border: solid;
            -webkit-appearance: none;
            border-color: grey;
            background-color: rgb(209, 209, 209);
            margin-bottom: 1vh;
            font-size: 16px;
            opacity: 0.97;
            font-weight: normal;
            border-radius: 0px;
            padding: 10px 30px;
            color: grey;
            cursor: pointer;
            box-shadow: 2.5px 5px 9px #888888;
            text-decoration: none;
        }

        #button:hover {
            background-color: rgb(190, 190, 190);
        }

        #button:active {
            box-shadow: none;
        }

        h1 {
            color: rgb(100, 100, 100);
        }

        vc {
            color: red;
        }
    </style>

</head>

<body>
    <br>
    <h1>Registrieren</h1>
    <form action="" method="post">
        <input name="name" type="text" placeholder="Name"> <br>
        <input name="username" type="text" placeholder="Username"> <br>
        <input name="email" type="email" placeholder="Email"> <br>
        <input name="password" type="password" placeholder="Password"> <br>
        <input id="button" name="submit" type="submit">
    </form>
    ––– OR –––
    <br>
    <br>
    <br>
    <a id="button" href="login.php">Login</a>

</body>

</html>