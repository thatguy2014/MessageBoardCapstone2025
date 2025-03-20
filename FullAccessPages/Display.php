<?php
// Display errors for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();          

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    $_SESSION["Displayloggedin"] = false;
    echo "<h1>Please refresh the page and log back in</h1><br>";
    exit;
}

// Database connection
require_once "/home/site/wwwroot/ScriptFiles/sql.php";

$userid = intval($_SESSION["UserId"]); // Ensure UserId is an integer

// Get display text
$res = mysqli_prepare($conn, "SELECT CurrentDisplay FROM CurrentDisplays WHERE UserId = ?");
mysqli_stmt_bind_param($res, "i", $userid);
mysqli_stmt_execute($res);
$res = mysqli_stmt_get_result($res);

// Get last updated time
$time = mysqli_prepare($conn, "SELECT (UpdateTime - INTERVAL 5 HOUR) AS Formatted_Time FROM CurrentDisplays WHERE UserId = ?");
mysqli_stmt_bind_param($time, "i", $userid);
mysqli_stmt_execute($time);
$time = mysqli_stmt_get_result($time);

// Get image display setting
$stmt = mysqli_prepare($conn, "SELECT ImageView FROM userinfo WHERE UserId = ?");
mysqli_stmt_bind_param($stmt, "i", $userid);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);
mysqli_stmt_bind_result($stmt, $resultbool);
mysqli_stmt_fetch($stmt);

// Get image location
$ImageStmt = mysqli_prepare($conn, "SELECT ImageLocation FROM currentdisplays WHERE UserId = ?");
mysqli_stmt_bind_param($ImageStmt, "i", $userid);
mysqli_stmt_execute($ImageStmt);
mysqli_stmt_store_result($ImageStmt);
mysqli_stmt_bind_result($ImageStmt, $ImageDir);
mysqli_stmt_fetch($ImageStmt);

$ImageDir = "/.." . substr($ImageDir, 18);

// Get user font preference
$Font = mysqli_prepare($conn, "SELECT Font FROM userinfo WHERE UserId = ?");
mysqli_stmt_bind_param($Font, "i", $userid);
mysqli_stmt_execute($Font);
$FontResult = mysqli_stmt_get_result($Font);
$UserFont = mysqli_fetch_assoc($FontResult);

//Get expiration date
$Expiration = mysqli_query($conn, "SELECT Expiration FROM CurrentDisplays WHERE UserId = '" . $userid . "'");

//Get custom presets
$presetsQuery = mysqli_prepare($conn, "SELECT PresetString FROM presets WHERE UserId = ?");
$preset1;
mysqli_stmt_bind_param($presetsQuery, "i", $userid);
if(mysqli_stmt_execute($presetsQuery)) {
    mysqli_stmt_store_result($presetsQuery);
    mysqli_stmt_bind_result($presetsQuery, $presetsResult);
    if (mysqli_stmt_fetch($presetsQuery)) {
        $preset1 = htmlspecialchars($presetsResult);
    }  
}

$presets = array();
if (mysqli_stmt_num_rows($presetsQuery) > 0) {
    while (mysqli_stmt_fetch($presetsQuery)) {
        $presets[] = $presetsResult;
    }
} else {
    // If no results were found, add a default option
    $presets[] = '';
}
?>



<style>
html, body {                  
    background: white;
    height: 100%;
    width: 100%;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    margin: 0;
    padding: 0;
    text-align: center;
    position: relative;
}

h2, p {
    font-family: <?php echo htmlspecialchars($UserFont["Font"], ENT_QUOTES, 'UTF-8'); ?>;
    text-align: center;
    word-wrap: break-word;
    white-space: normal;
    width: 90%;
    max-width: 100%;
    margin: 0;
    padding: 0;
}

/* Fullscreen Controls */
#fullscreenControls {
    display: flex;
    position: absolute;
    top: 10px;
    width: 100%;
    justify-content: space-between;
    padding: 0 20px;
}

#backArrow, #logo {
    cursor: pointer;
    transition: transform 0.3s ease;
}

/* Default sizes */
#backArrow, #logo {
    width: 200px;
    height: auto;
    position: fixed;
    top: 10px;
    z-index: 1000;
}

#backArrow {
    left: 10px;
}

#logo {
    right: 10px;
}

.presetbutton {
    position: fixed;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
    background-color: orange;
    color: white;
    border: none;
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    display: inline-block;
    margin-right: 10px;
    width: 100px;
    height: 40px;
}

.presetbutton:last-child {
    margin-right: 0;
}

.presetbutton:hover {
    background-color: darkorange;
}
</style>

<html>
    <body>
        <div id="fullscreenControls">
            <img id="backArrow" src="assets/backarrow.png" alt="Back">
            <img id="logo" src="assets/onulogo.png" alt="Logo">
        </div>

        <h2 id="currentdisplay">
            <?php  
                if (!empty($resultbool) && $resultbool == 1) {
                    echo "<img src='" . htmlspecialchars($ImageDir, ENT_QUOTES, 'UTF-8') . "'>";
                } else {
                    $content = "";
                    while ($row = mysqli_fetch_assoc($res)) {
                        $content .= htmlspecialchars($row["CurrentDisplay"], ENT_QUOTES, 'UTF-8') . " ";
                    }
                    echo $content;
                }
            ?>
        </h2>
        <p>
            <?php
                echo "<br> Posted Time: ";
                if (mysqli_num_rows($time) > 0) {
                    $rowTime = mysqli_fetch_assoc($time);
                    echo htmlspecialchars($rowTime["Formatted_Time"], ENT_QUOTES, 'UTF-8');
                }
            ?>

            <?php

                date_default_timezone_set('America/New_York');
                $ExpirationPrint = "";
                $now = Date("Y-m-d H:i:s");
                if(mysqli_num_rows($Expiration) > 0) {
                    $rowExp = mysqli_fetch_assoc($Expiration);
                    $ExpirationPrint = $rowExp["Expiration"];
                    if ($ExpirationPrint < $now && $ExpirationPrint != null) {
                        echo "<br> <h1>WARNING THIS MESSAGE HAS EXPIRED AS OF:";
                        echo $ExpirationPrint;
                        echo "</h1>";
                    }
                }
                $count = 0;
                $content = "<button class = 'presetbutton' id = button" . $count . ">" . htmlspecialchars($preset1) . "</button>";
                echo $content;
                $count++;
                foreach ($presets as $preset) {
                    if (!empty($preset)) {
                        if($count < 4) {
                            $content = "<button class = 'presetbutton' id = button" . $count . ">" . htmlspecialchars($preset) . "</button>";
                            echo $content;
                            $count++;
                        } else {
                            break;
                        }
                    }
                }
                while ($count < 4) {
                    $content = "<button class = 'presetbutton' id = button" . $count . "></button>";
                    echo $content;
                    $count++;
                }
            ?>
        </p>
    </body>

    <script>
        function checkFullscreen() {
            let logo = document.getElementById("logo");
            let backArrow = document.getElementById("backArrow");
            let textElement = document.getElementById("currentdisplay");

            console.log("Fullscreen Check Triggered"); // Debugging log

            if (document.fullscreenElement || document.webkitFullscreenElement || document.msFullscreenElement) {
                // Make images smaller in fullscreen
                backArrow.style.width = "60px";
                backArrow.style.height = "60px";
                logo.style.width = "80px";

                // Adjust text size dynamically
                textElement.style.fontSize = "6vw";

                console.log("Entered Fullscreen Mode - Images Shrunk");
            } else {
                // Reset to normal sizes when exiting fullscreen
                backArrow.style.width = "200px";
                backArrow.style.height = "200px";
                logo.style.width = "200px";

                // Reset text size
                textElement.style.fontSize = "4vw";

                console.log("Exited Fullscreen Mode - Images Back to Normal");
            }
        }


        function adjustFontSize() {
            let textElement = document.getElementById("currentdisplay");
            let parent = document.documentElement;
            let fontSize = 8; // Start with a reasonable font size
            textElement.style.fontSize = fontSize + "vw";

            while (textElement.scrollHeight > parent.clientHeight || textElement.scrollWidth > parent.clientWidth) {
                fontSize -= 0.5;
                textElement.style.fontSize = fontSize + "vw";
                if (fontSize < 2) break; // Prevent text from getting too small
            }
        }

        function exitFullscreen() {
            window.parent.postMessage("exitFullscreen", "*");
        }

        document.getElementById("backArrow").addEventListener("click", exitFullscreen);

        document.addEventListener("fullscreenchange", checkFullscreen);
        document.addEventListener("webkitfullscreenchange", checkFullscreen);
        document.addEventListener("msfullscreenchange", checkFullscreen);

        window.onload = () => {
            checkFullscreen();
            adjustFontSize();
        };

        window.onresize = adjustFontSize;
    </script>
</html>
