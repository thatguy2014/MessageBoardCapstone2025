<?php
require_once "/../ScriptFiles/VerifyLogin.php";
?>

<html>
    <head>
        <link rel="stylesheet" type="text/css" href="/../css/Main.css" />
    </head>
    <body>
        <div>
            <header>
                <h1>Office Message Board Current Display</h1>
            </header>
            <!--Should import the navbar -->
            <?php include '/../templates/navbar.html'; ?>

            
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
