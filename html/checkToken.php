<?php
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

    if ($row['token'] != $_SESSION['token']) {
        header("Location: login.php");
    }
}
else{
    header("Location: login.php");
}
?>