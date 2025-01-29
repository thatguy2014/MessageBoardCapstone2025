<?php
require_once "VerifyLogin.php";
?>

<html>
    <header>
        <h1>Office Message Board</h1>
    </header>
    <!--Navbar-->
    <nav>
        <ul>
            <li><a href="CurrentDisplay.php">Current Display</a></li>
            <li><a href="Presets.php">Presets</a></li>
            <li><a href="ChangeDisplay.php">Change Display</a></li>
            <li><a href="logout.php">Sign Out of Your Account</a></li>
        </ul>
    </nav>

    <!--Iframe so it'll auto refresh and be fullscreen-->
    <iframe id="iframe" src="Display.php" height="400" width="1000"></iframe><br>
    
    
        <button onclick = "openFullscreen()" > Fullscreen </button>

        <!--Script to let you go fullscreen-->
        <script>
            /* Get the element you want displayed in fullscreen mode (a video in this example): */
            var elem = document.getElementById("iframe");

            /* When the openFullscreen() function is executed, open the video in fullscreen.
            Note that we must include prefixes for different browsers, as they don't support the requestFullscreen method yet */
            function openFullscreen() {
            if (elem.requestFullscreen) {
                elem.requestFullscreen();
            } else if (elem.webkitRequestFullscreen) { /* Safari */
                elem.webkitRequestFullscreen();
            } else if (elem.msRequestFullscreen) { /* IE11 */
                elem.msRequestFullscreen();
            }
            }
        </script>

        <!--Script to auto refresh the iframe-->
        <script>
            window.setInterval(function() {
                reloadIFrame()
            }, 10000);

            function reloadIFrame() {
                console.log('reloading..');
                document.getElementById('iframe').contentWindow.location.reload();
            }
        </script>
    </section>
    <footer>

    </footer>
