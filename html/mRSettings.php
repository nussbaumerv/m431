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
            echo "<script>createAlert('User is already in Room'); </script>";
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
                echo "<script>createAlert('User was added to Room'); </script>";
            } else {
                echo "<script>createAlert('Something went wrong'); </script>";
            }
        }
    }
}

if (isset($_POST['submit_mod'])) {
    $email = $_POST['email'];
    $sql_add = "SELECT * FROM users WHERE email = '$email'";
    $result_add = mysqli_query($connect, $sql_add);

    $row_add = mysqli_fetch_assoc($result_add);
    $uid_add = $row_add['id'];

    $json_id_add = $row_add['chat_rooms'];
    $array_id_add = json_decode($json_id_add, true);

    if (in_array($room, $array_id_add)) {
        $sql_r = "SELECT * FROM rooms WHERE id = '$room'";
        $result_r = mysqli_query($connect, $sql_r);
        $row_r = mysqli_fetch_assoc($result_r);

        $json_mod = $row_r['mods'];
        $array_mod = json_decode($json_mod, true);

        if (in_array($uid_add, $array_mod)) {
            echo "<script>createAlert('User is already in Mod'); </script>";
        } else {
            array_push($array_mod, $uid_add);

            $json_mod = json_encode($array_mod);

            $sql_update = "UPDATE rooms SET mods = '$json_mod' WHERE id = '$room'";
            $result_update = mysqli_query($connect, $sql_update);
            if ($result_update) {
                $to = $email;
                $subject = "Mod in Edu Chat Gruppe";
                $message = "Hi " . $row_add['username'] . "<br>Sie wurden von " . $username . " im " . $room_name . " zu einem Mod befoerdert. <br>
                Loggen Sie sich <a href='https://edu'chat.me/login.php'>hier</a> ein und starten Sie jetzt mit dem chatten als Mod.";
                send_mail($to, $subject, $message);
                echo "<script>createAlert('Mod was added to Room'); </script>";
            } else {
                echo "<script>createAlert('Something went wrong'); </script>";
            }
        }
    } else {
        echo "<script>createAlert('User is not in room yet. Add the user to this room first.'); </script>";
    }
}
if (isset($_POST['submit_leave'])) {
    $sql_remove = "SELECT * FROM users WHERE id = '$uid'";
    $result_remove = mysqli_query($connect, $sql_remove);
    $row_remove = mysqli_fetch_assoc($result_remove);

    $json_id_remove = $row_remove['chat_rooms'];
    $json_names_remove = $row_remove['chat_rooms_name'];

    $array_id_remove = json_decode($json_id_remove, true);
    $array_name_remove = json_decode($json_names_remove, true);

    $sql_r = "SELECT * FROM rooms WHERE id = '$room'";
    $result_r = mysqli_query($connect, $sql_r);
    $row_r = mysqli_fetch_assoc($result_r);

    $json_mod = $row_r['mods'];
    $array_mod = json_decode($json_mod, true);


    $key_id = array_search($room, $array_id_remove);
    $key_mod = array_search($uid, $array_mod);

    if (false !== $key_id && false !== $key_mod) {
        unset($array_id_remove[$key_id]);
        unset($array_name_remove[$key_id]);
        unset($array_mod[$key_mod]);

        $array_id_remove = json_encode($array_id_remove);
        $array_name_remove = json_encode($array_name_remove);
        $json_mod = json_encode($array_mod);

        $sql_update = "UPDATE users SET chat_rooms = '$array_id_remove', chat_rooms_name ='$array_name_remove' WHERE id = '$uid'";
        $result_update = mysqli_query($connect, $sql_update);

        $sql_update_mod = "UPDATE rooms SET mods = '$json_mod' WHERE id = '$room'";
        $result_update_mod = mysqli_query($connect, $sql_update_mod);

        if ($result_update && $result_update_mod) {
            echo "<script>createAlert('You sucsessfuly left this room'); </script>";
            header("Location: index.php");
        } else {
            echo "<script>createAlert('Something went wrong'); </script>";
        }
    } else {
        echo "<script>createAlert('Something went wrong'); </script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include("header.html"); ?>
    <title>Settings: <?php echo $room_name; ?></title>
    <style>
        #leave {
            background-color: orange;
            color: black;
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
    <br>
    <h3>Add Mod to Room</h3>
    <br>
    <form method="post">
        <input placeholder="Email" class="send_input" type="email" name="email"> <br>
        <button class="send_button" name="submit_mod" type="submit">Send</button>
    </form>
    <br>

    <form method="post">
        <button id="leave" class="send_button" name="submit_leave" type="submit">Leave room</button>
    </form>
</body>

</html>