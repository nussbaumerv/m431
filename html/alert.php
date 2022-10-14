<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script>
        createAlert("lol");
        function exit() {
            document.getElementById("AlertMessage").style.display = "none";
            reaction();
        }

        function createAlert(message) {
            document.getElementById("AlertMessageContent").innerHTML = message;
            document.getElementById("AlertMessage").style.display = "block";
        }
    </script>
</head>

<body>
    <div id="AlertMessageContainer">
        <div id="AlertMessage">
            <span onclick="exit()" id="AlertExit">&#10005;</span>
            <div id="AlertMessageContent">
                Message
            </div>
        </div>
    </div>
</body>

</html>