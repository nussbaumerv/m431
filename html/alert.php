<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            text-align: center;
        }

        #message {
            border: solid;
            border-color: red;
            border-width: 2px;
            background-color: white;
            position: relative;
            display: none;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }

        #message_content {
            padding: 30px 100px;
        }


        #message_container {
            position: absolute;
            z-index: 1;
            top: 10%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        #exit {
            position: absolute;
            right: 10px;
            top: 10px;
            cursor: pointer;
        }
    </style>
    <script>
        createAlert("lol");
        function exit() {
            document.getElementById("message").style.display = "none";
            reaction();
        }

        function createAlert(message) {
            document.getElementById("message_content").innerHTML = message;
            document.getElementById("message").style.display = "block";
        }

        window.onclick = function(event) {
            if (event.target == document.getElementById("body") && document.getElementById("body").style.filter == "blur(4px)") {
                exit();

            }
        }
    
    </script>
</head>

<body>
    <div id="message_container">
        <div id="message">
            <span onclick="exit()" id="exit">&#10005;</span>
            <div id="message_content">
                Message
            </div>
        </div>
    </div>
</body>

</html>