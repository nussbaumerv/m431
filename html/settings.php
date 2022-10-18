<?php
include("alert.php");
include("connect.php");
include("menu.php");
$uid = $_COOKIE['uid'];

if ($uid) {
    $sql = "SELECT * FROM users WHERE id = '$uid'";
    $result = mysqli_query($connect, $sql);
    if (!$result) {
        echo "<script> alert('Daten konnten nicht geladen Werden.'); </script>";
    }

    $row = mysqli_fetch_assoc($result);

    if ($row['token'] != $_COOKIE['token']) {
        header("Location: login.php");
    }
} else {
    header("Location: login.php");
}
$email = $row['email'];
$username = $row['username'];
$color = $row['color'];

if (isset($_POST['submit_pwd'])) {
    $password = $_POST['password'];
    $password = password_hash($password, PASSWORD_DEFAULT);

    $sql_update = "UPDATE users SET password = '$password' WHERE id = '$uid'";
    $result_update = mysqli_query($connect, $sql_update);
    if ($result_update) {
        echo "<script>createAlert('Password sucessfuly changed'); </script>";
        header("Location: logout.php");
    } else {
        echo "<script>createAlert('Something went wrong'); </script>";
    }
}
if (isset($_POST['submit_email'])) {
    $email = $_POST['email'];

    $sql_update = "UPDATE users SET email = '$email' WHERE id = '$uid'";
    $result_update = mysqli_query($connect, $sql_update);
    if ($result_update) {
        echo "<script>createAlert('Email sucessfuly changed'); </script>";
    } else {
        echo "<script>createAlert('Something went wrong'); </script>";
    }
}

if (isset($_POST['submit_user'])) {
    $user = $_POST['user'];

    $sql_update = "UPDATE users SET username = '$user' WHERE id = '$uid'";
    $result_update = mysqli_query($connect, $sql_update);
    if ($result_update) {
        echo "<script>createAlert('Username sucessfuly changed'); </script>";
    } else {
        echo "<script>createAlert('Something went wrong'); </script>";
    }
}
if (isset($_POST['submit_color'])) {
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

    $sql_update = "UPDATE users SET color = '$color' WHERE id = '$uid'";
    $result_update = mysqli_query($connect, $sql_update);
    if ($result_update) {
        echo "<script>createAlert('Color sucessfuly changed'); </script>";
    } else {
        echo "<script>createAlert('Something went wrong'); </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include("header.html"); ?>
    <title>Settings</title>
    <style>
        #logout {
            background-color: orange;
            text-decoration: none;
            color: black;
        }
    </style>
</head>

<body>
    <br>
    <h1>Settings</h1>
    <br>
    <h3>Change Password</h3>
    <br>
    <form method="post">
        <input placeholder="Password" class="send_input" type="password" name="password" required> <br>
        <button class="send_button" name="submit_pwd" type="submit">Send</button>
    </form>
    <br>

    <h3>Change Username</h3>
    <br>
    <form method="post">
        <input value="<?php echo $username; ?>" placeholder="Username" class="send_input" type="text" name="user" required> <br>
        <button class="send_button" name="submit_user" type="submit">Send</button>
    </form>
    <br>

    <h3>Change Email</h3>
    <br>
    <form method="post">
        <input value="<?php echo $email; ?>" placeholder="Email" class="send_input" type="email" name="email" required> <br>
        <button class="send_button" name="submit_email" type="submit">Send</button>
    </form>
    <br>
    <h3>Notifications</h3><br>
    <button class="send_button" name="submit_color" onclick="getNotifications()">Get Notifications</button>
    <br>
    <br>
    <h3>Change Notificationcolor</h3><br>
    <form method="post">
        <button style="background-color: <?php echo $color; ?>; color:black;" class="send_button" name="submit_color" type="submit">Generate new color</button>
    </form>

    <br><br>
    <a href="logout.php" id="logout" class="send_button">Logout</a>
    <br><br><br><br>

    <?php include("footer.php"); ?>
    <script>
        function getNotifications(){
            if (Notification.permission == "granted") {
                const notification = new Notification("Notifications are alredy enabled!");
            } else if (Notification.permission == "denied") {
                Notification.requestPermission().then((permission) => {
                    if (permission === "granted") {
                        const notification = new Notification("Notifications should work now!");
                    }
                });
            }
        }
    </script>

</body>

</html>