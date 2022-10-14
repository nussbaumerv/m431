<?php

include("alert.php");
if (isset($_POST['submit_leave'])) {
    $sql_remove = "SELECT * FROM users WHERE id = '$uid'";
    $result_remove = mysqli_query($connect, $sql_remove);
    $row_remove = mysqli_fetch_assoc($result_remove);


    $json_id_remove = $row_remove['chat_rooms'];
    $json_names_remove = $row_remove['chat_rooms_name'];

    $array_id_remove = json_decode($json_id_remove, true);
    $array_name_remove = json_decode($json_names_remove, true);

    $key = array_search($room, $array_id_remove);

    if (false !== $key) {
        unset($array_id_remove[$key]);
        unset($array_name_remove[$key]);

        $array_id_remove = json_encode($array_id_remove);
        $array_name_remove = json_encode($array_name_remove);

        $sql_update = "UPDATE users SET chat_rooms = '$array_id_remove', chat_rooms_name ='$array_name_remove' WHERE id = '$uid'";
        $result_update = mysqli_query($connect, $sql_update);
        if ($result_update) {
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
    <form method="post">
        <button id="leave" class="send_button" name="submit_leave" type="submit">Leave room</button>
    </form>
</body>

</html>