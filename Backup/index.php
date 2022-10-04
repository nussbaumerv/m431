<?php
include("connect.php");
include("menu.php");
session_start();
$uid = $_SESSION['uid'];

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
} else {
    header("Location: login.php");
}
if ($_GET['r'] == "") {
    $room = 0;
    $room_name = "My Groupes";
    $display = "style='display:none'";
} else {
    $room = $_GET['r'];
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
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <title>Edu Chat</title>
    <style>
        body {
            text-align: center;
            font-family: arial;
        }

        #container {
            position: fixed;
            bottom: 10px;
            left: 50%;
            transform: translate(-50%, 0%);
        }

        .linksRooms {
            color: black;
            text-decoration: none;
            font-size: 25px;
        }

        .linksRooms:hover {
            color: grey;
        }

        p {
            font-size: 18px;
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

        .linksSettings {
            position: fixed;
            top: 10px;
            right: 10px;
        }

        .linksSettings a {
            text-decoration: none;
            color: black;
        }

        .linksSettings a:hover {
            text-decoration: underline;
            color: grey;
        }
    </style>

</head>
<script>
    var amount = 0;

    function change_text() {
        document.getElementById("submit").value = "LOADING...";
    }

    var value;

    fetch();
    setInterval(function() {
        fetch();
    }, 5000);


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
                var minus = value - 1;
                console.log(value);
                if ($("#list p").length > value) {
                    $('#list p:gt(' + minus + ')').remove();
                }
                $("#list p").fadeIn();
                fetch();
            }
        });
        amount = value;
    }

    function save() {
        var message = document.getElementById("message").value;
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
            }
        });
    }
</script>

<body>
    <span class="linksSettings"><a href="rsettings.php?r=<?php echo $room ?>">Room Settings</a> | <a href="settings.php"><?php echo $row['username']; ?></a></span>
    <br><br>
    <h1><?php echo $room_name; ?></h1><br>

    <div id="list">
        <p>Start sending messages</p>
    </div>
    <div <?php echo $display ?> id="container">
        <input class="send_input" type="text" id="message" name="message"> <br>
        <button id="submit_button" class="send_button" type="submit" onclick="save()">Send</button>
    </div>
    <script>
        var input = document.getElementById("message");
        input.addEventListener("keypress", function(event) {
            if (event.key === "Enter") {
                event.preventDefault();
                save();
                input.value = "";
            }
        });
    </script>

</body>


</html>