<?php
include("alert.php");
include("PHPMailer/mail.php");
if (isset($_POST['submit_add'])) {
    $email = $_POST['email'];
    $sql_add = "SELECT * FROM users WHERE email = '$email'";
    $result_add = mysqli_query($connect, $sql_add);

    $row_add = mysqli_fetch_assoc($result_add);
    $uid_add = $row_add['id'];

    if ($uid_add == "") {
        echo "<script>createAlert('User is not registred<br>A Invitation email was sent.'); </script>";
        $to = $email;
        $subject = "Edu Chat Einladung";
        $message = "Sie wurden von " . $username . " zur " . $room_name . " Gruppe auf Edu Chat eingeladen. <br>
        Registrieren Sie sich Jetzt <a href='https://edu'chat.me/register.php'>hier</a>.";
        send_mail($to, $subject, $message);
    } else {
        $json_id_add = $row_add['chat_rooms'];
        $json_names_add = $row_add['chat_rooms_name'];

        $array_id_add = json_decode($json_id_add, true);
        $array_name_add = json_decode($json_names_add, true);

        if (in_array($room, $array_id_add)) {
            echo "<script>createAlert('User is already in Groupe'); </script>";
        } else {
            array_push($array_id_add, $room);
            array_push($array_name_add, $room_name);

            $array_id_add = json_encode($array_id_add);
            $array_name_add = json_encode($array_name_add);

            $sql_update = "UPDATE users SET chat_rooms = '$array_id_add', chat_rooms_name ='$array_name_add' WHERE id = '$uid_add'";
            $result_update = mysqli_query($connect, $sql_update);
            if ($result_update) {
                $to = $email;
                $subject = "Neue Edu Chat Gruppe";
                $message = "Hi " . $row_add['username'] . "<br>Sie wurden von " . $username . " zur " . $room_name . " Gruppe auf Edu Chat hinzugefuegt. <br>
                Loggen Sie sich <a href='https://edu'chat.me/login.php'>hier</a> ein und starten Sie jetzt mit dem chatten.";
                send_mail($to, $subject, $message);
                echo "<script>createAlert('User was added to Groupe'); </script>";
            } else {
                echo "<script>createAlert('Something went wrong'); </script>";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include("header.html"); ?>
    <title>Settings: <?php echo $room_name; ?></title>
    <style>
        * {
            text-align: center;
        }

        .send_input {
            border: solid;
            border-color: grey;
            margin-bottom: 1vh;
            font-size: 16px;
            opacity: 0.97;
            border-radius: 0px;
            color: grey;
            padding: 10px 40px 10px 40px;
            box-shadow: 5px 10px 18px #888888;
        }

        .send_input:focus {
            border-radius: 0px;
            outline: none;
            background-color: rgb(220, 220, 220);
            box-shadow: 2px 4px 6px #888888;
        }

        .send_button {
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
        }

        .send_button:hover {
            background-color: rgb(190, 190, 190);
        }

        .send_button:active {
            box-shadow: none;
        }
    </style>
</head>

<body>
    <br><br>
    <h1><?php echo $room_name; ?></h1>
    <br>
    <h3>Add User to Room</h3>
    <br>
    <form method="post">
        <input placeholder="Email" class="send_input" type="email" name="email"> <br>
        <button class="send_button" name="submit_add" type="submit">Send</button>
    </form>
</body>

</html>