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
    <?php include("header.html"); ?>
    <title>2FA</title>
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