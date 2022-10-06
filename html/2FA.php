<?php
include("alert.php");
include("PHPMailer/mail.php");
if (isset($_POST['submit_code'])) {
    $code = $_POST['code'];
    $sql_add = "SELECT * FROM users WHERE id = '$uid'";
    $result_add = mysqli_query($connect, $sql_add);

    $row_add = mysqli_fetch_assoc($result_add);
    $codeSql = $row_add['2FA'];

    if ($code == $codeSql) {
        $sql_update = "UPDATE users SET active = 'true' WHERE id = '$uid'";
        $result_update = mysqli_query($connect, $sql_update);
        if ($result_update) {
            header("Location: index.php");
        } else {
            echo "<script>createAlert('Something went wrong'); </script>";
        }
    } else {
        $to = $row['email'];
        $subject = "Aktivierungs Code";
        $message = "Ihr Aktivierungs Code: ".$codeSql." <br>
        Geben Sie ihren Code hier <a href='https://edu'chat.me/index.php'>hier</a> ein.";
        send_mail($to, $subject, $message);
        echo "<script>createAlert('Incorect Code<br>Your Code was sent again.'); </script>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $room_name; ?></title>
    <style>
        * {
            text-align: center;
            font-family: arial;
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
    <h3>Enter the Code you've received via email.</h3>
    <br>
    <form method="post">
        <input placeholder="Code" class="send_input" type="number" name="code"> <br>
        <button class="send_button" name="submit_code" type="submit">Send</button>
    </form>
</body>

</html>