<?php
require_once "VerifyLogin.php";
?>

<html>
    <head>
        <link rel="stylesheet" type="text/css" href="CurrentDisplay.css" />
    </head>
    <body>
        <div>
            <header>
                <h1>Office Message Board</h1>
            </header>

            
            <nav>
                <div class="nav-buttons">
                    <button onclick="location.href='CurrentDisplay.php'">Current Display</button>
                    <button onclick="location.href='Presets.php'">Presets</button>
                    <button onclick="location.href='ChangeDisplay.php'">Change Display</button>
                    <button onclick="location.href='Logout.php'">Sign Out</button>
                </div>
            </nav>

            
            <div class="iframe-container">
                <iframe id="iframe" src="Display.php" height="400" width="1000"></iframe><br>
                <button onclick="openFullscreen()">Fullscreen</button>
            </div>

            
            <script>
                var elem = document.getElementById("iframe");

                function openFullscreen() {
                    if (elem.requestFullscreen) {
                        elem.requestFullscreen();
                    } else if (elem.webkitRequestFullscreen) { 
                        elem.webkitRequestFullscreen();
                    } else if (elem.msRequestFullscreen) { 
                        elem.msRequestFullscreen();
                    }
                }
            </script>

            
            <script>
                window.setInterval(function() {
                    reloadIFrame()
                }, 10000);

                function reloadIFrame() {
                    console.log('reloading..');
                    document.getElementById('iframe').contentWindow.location.reload();
                }
            </script>
            
            <footer>
            
            </footer>
        </div>
    </body>
</html>
