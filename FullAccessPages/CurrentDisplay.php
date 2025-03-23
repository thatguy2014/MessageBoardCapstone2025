<?php
require_once "/home/site/wwwroot/ScriptFiles/VerifyLogin.php";
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

            <!-- Import Navbar -->
            <?php include '/home/site/wwwroot/templates/navbar.html'; ?>

            <div class="iframe-container">
                <iframe id="iframe" src="Display.php" height="400" width="1000"></iframe><br>
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

                    setTimeout(() => {
                        elem.contentWindow.postMessage("fullscreenOn", "*");
                    }, 500);
                }

                window.addEventListener("fullscreenchange", function() {
                    if (!document.fullscreenElement) {
                        elem.contentWindow.postMessage("fullscreenOff", "*");
                    }
                });

                window.addEventListener("message", function(event) {
                    if (event.data === "exitFullscreen") {
                        if (document.exitFullscreen) {
                            document.exitFullscreen();
                        } else if (document.webkitExitFullscreen) {
                            document.webkitExitFullscreen();
                        } else if (document.msExitFullscreen) {
                            document.msExitFullscreen();
                        }
                    }
                });

                //refresh I-frame every 60 seconds
                window.setInterval(function() {
                    reloadIFrame();
                }, 60000);

                function reloadIFrame() {
                    console.log('Reloading iframe...');
                    document.getElementById('iframe').contentWindow.location.reload();
                }
            </script>

            <footer>
            </footer>
        </div>
    </body>
</html>
