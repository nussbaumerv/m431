<?php
include("connect.php");
$uid = $_COOKIE['uid'];

if ($uid) {
    $sql = "SELECT * FROM users WHERE id = '$uid'";
    $result = mysqli_query($connect, $sql);
    if (!$result) {
        echo "<script> alert('Daten konnten nicht geladen Werden.'); </script>";
    }

    $row = mysqli_fetch_assoc($result);



    if ($row['token'] != $uid = $_COOKIE['token']) {
        header("Location: login.php");
    }
    if ($row['active'] == 'false') {
        $uid = $row['id'];
        include("2FA.php");
        exit;
    }
} else {
    header("Location: login.php");
}
$json_id = $row['chat_rooms'];
$array_id = json_decode($json_id, true);

if ($_GET['r'] == "") {
    $room = 0;
    $room_name = "My Rooms";
    $display = "style='display:none'";
} else {
    $room = $_GET['r'];
    if (!in_array($room, $array_id)) {
        header("Location: https://edu-chat.me");
    
    }
    $display = "";
    if ($room == 1) {
        $display = "style='display:none'";
    }
    $sql_gr = "SELECT * FROM rooms WHERE id = '$room'";
    $result_gr = mysqli_query($connect, $sql_gr);
    $row_gr = mysqli_fetch_assoc($result_gr);
    $room_name = $row_gr['name'];
}

echo "<script> var room = " . $room . ";</script>";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include("header.html"); 
    include("menu.php");?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <title><?php echo $room_name; ?></title>
</head>
<script>
    var amount = 0;

    function change_text() {
        document.getElementById("submit").value = "LOADING...";
    }

    var value;

    function sendNotification(value) {
        if (document.visibilityState == "hidden" && value != amount) {
            if (Notification.permission == "granted") {
                const notification = new Notification("You've got a new message!");
            } else if (Notification.permission == "denied") {
                Notification.requestPermission().then((permission) => {
                    if (permission === "granted") {
                        const notification = new Notification("Your Notifications should work now!");
                    }
                });
            }
        }
    }

    function fetch() {
        if (room == 0) {
            var url = 'noRooms.php?amount=' + amount;
        } else {
            var url = 'load.php?r=' + room + '&amount=' + amount;
        }
        $.ajax({
            url: url,
            success: function(data) {
                $("#list").prepend(data);
                value = document.getElementById('amount').innerHTML;
                sendNotification(value);
                var minus = value - 1;
                if ($("#list div").length > value) {
                    $('#list div:gt(' + minus + ')').remove();
                }
                $("#list div").fadeIn();
                fetch();
            }
        });
        amount = value;
        var objDiv = document.getElementById("list");
        objDiv.scrollTop = objDiv.scrollHeight;
    }

    function save() {
        var message = document.getElementById("message").value;
        if ("" != message) {
            $.ajax({
                url: "send.php",
                type: "POST",
                data: {
                    message: message,
                    room: room
                },
                cache: false,
                success: function(dataResult) {
                    document.getElementById("message").value == "";
                    fetch();
                    cleanInput();
                }
            });
        }
    }
</script>

<body>
    <div id="infoHead">
    <span class="linksSettings"><a <?php echo $display ?> href="rsettings.php?r=<?php echo $room ?>">Room Settings</a> | <a href="settings.php"><?php echo $row['username']; ?></a></span>
            <br><br>
        <h1><?php echo $room_name; ?></h1><br>
    </div>

    <div id="list">
        <div>Start sending messages</div>
    </div>
    <div <?php echo $display ?> id="container">
        <input class="send_input messageInput" type="text" id="message" name="message">
        <button id="submit_button" class="send_button messageButton" type="submit" onclick="save()">Send</button>
    </div>
    <script>
        fetch();
        setInterval(function() {
            fetch();
        }, 5000);
        var input = document.getElementById("message");
        input.addEventListener("keypress", function(event) {
            if (event.key === "Enter") {
                event.preventDefault();
                save();
                cleanInput();
            }
        });

        function cleanInput() {
            input.value = "";
        }
    </script>

</body>

</html>