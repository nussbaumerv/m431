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

        #container {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(5px);
        }

        #message {
            border: solid;
            border-color: red;
            border-width: 2px;
            background-color: white;
            width: 80%;
            position: absolute;
            z-index: 1;
            top: 50%;
            left: 50%;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.4), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            transform: translate(-50%, -50%);
        }

        #message_content {
            padding: 30px 30px;
        }


        .close {
            color: #aaaaaa;
            float: right;
            font-size: 28px;
            padding:1px 10px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: grey;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
    <script>
        function exit() {
            document.getElementById("container").style.display = "none";
            reaction();
        }

        function create(message) {
            document.getElementById("message_content").innerHTML = message;
            document.getElementById("container").style.display = "block";
        }

        window.onclick = function(event) {
            if (event.target == document.getElementById("container") && document.getElementById("container").style.display == "block") {
                exit();

            }
        }
    </script>
</head>

<body>
    <div id="container">
        <div id="message">
            <span onclick="exit()" class="close">&times;</span>
            <div id="message_content">
            </div>
        </div>
    </div>


</body>

</html>