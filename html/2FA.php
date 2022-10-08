<?php
include("alert.php");
include("PHPMailer/mail.php");

$codeSql = $row['2FA'];
if($_GET['sc'] == 1){
    $to = $row['email'];
    $subject = "Aktivierungs Code";
    $message = "Ihr Aktivierungs Code: ".$codeSql." <br>
    Geben Sie Ihren Code hier <a href='https://edu'chat.me/index.php'>hier</a> ein.";
    send_mail($to, $subject, $message);
    echo "<script>createAlert('Your Code was sent again to: ".$to.".'); </script>";
}


if (isset($_POST['submit_code'])) {
    $code = $_POST['code'];
    if ($code == $codeSql) {
        $sql_update = "UPDATE users SET active = 'true' WHERE id = '$uid'";
        $result_update = mysqli_query($connect, $sql_update);
        if ($result_update) {
            header("Location: index.php");
        } else {
            echo "<script>createAlert('Something went wrong'); </script>";
        }
    } else {
        echo "<script>createAlert('Incorect Code'); </script>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>2FA</title>
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
        .sendCodeAgain{
            color:black;
            text-decoration: none;
        }
        .sendCodeAgain:hover{
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <br><br>
    <h1>Edu Chat</h1>
    <p>Enter the Code you've received via email.</p>
    <br>
    <form method="post">
        <input placeholder="Code" class="send_input" type="number" name="code"> <br>
        <button class="send_button" name="submit_code" type="submit">Send</button>
    </form>
    <br>
    <a class="sendCodeAgain" href='?sc=1'>Send Code again</a>
</body>

</html>