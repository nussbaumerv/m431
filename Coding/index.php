<?php
include("menu.html");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <title>Document</title>
    <style>
        body{
            text-align:center;
            font-family:arial;
        }
        #container{
            position:fixed;
            bottom:10px;
            left: 50%;
            transform: translate(-50%, 0%);
        }
        input[type="text"]{
            border: solid;
            border-color: grey;
            margin-bottom: 1vh;
            font-size: 16px;
            opacity: 0.97;
            border-radius: 0px;
            color: grey;
            padding: 10px 70px 10px 40px ;
            box-shadow: 5px 10px 18px #888888;
            }
            
            input[type="text"]:focus{           
            border-radius: 0px;
            outline: none;
            background-color: rgb(220, 220, 220);
            box-shadow: 2px 4px 6px #888888;
             }
        #button {
            border: solid;
            -webkit-appearance: none;
            border-color: grey;
            background-color: rgb(209, 209, 209);
            margin-bottom: 1vh;
            font-size: 16px;
            opacity: 0.97;
            font-weight:normal;
            border-radius: 0px;
            padding: 10px 30px;
            color: grey;
            cursor: pointer;
            box-shadow: 2.5px 5px 9px #888888;
        }
        
        #button:hover {
            background-color: rgb(190, 190, 190);
        }
        
        #button:active {
            box-shadow: none;
        }

    </style>
    <script>

        function change_text() {
            document.getElementById("submit").value = "LOADING...";
        }

        function fetch() {
            var loading = 10;
            $.ajax({
                url: 'load.php?amount='+amount,
                success: function(data) {
                    $("#list").prepend(data);
                    var amount = $("#list p").length;
                    if ($("#list p").length > 150) {
                        $('#list p:gt(149)').remove();
                    }
                    $("#list p").fadeIn();
                    fetch();
                }
            });
        }

        $(function() {
        fetch();
        loop();

        });

        function loop() {
            setTimeout(function() {
                fetch();
            }, 3000);
        }



        function save() {
            var message = document.getElementById("message").value;
            $.ajax({
                url: "send.php",
                type: "POST",
                data: {
                    message: message
                },
                cache: false,
                success: function(dataResult) {
                    document.getElementById("message").value == "";
                    fetch();
                    var dataResult = JSON.parse(dataResult);
                    if (dataResult.statusCode == 200) {
                        alert("Saved");

                    } else if (dataResult.statusCode == 201) {
                        alert("Error occured !");
                    }

                }
            });
        }
    </script>
</head>

<body>
    <h1 color="green">Online Groupes</h1>

    <div id="list">
        <p style="color:red">Loading...</p>
    </div>
    <div id="container">
    <input class="input"  type="text" id="message" name="message"> <br>
    <button id="button" type="submit" onclick="save()">Send</button>
    </div>


</body>

</html>