<?php
// Starts displaying errors when things go wrong
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();          

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    $_SESSION["Displayloggedin"] = false;
    echo "<h1>Please refresh the page and log back in</h1><br>";
    exit;
}

// Make sure we have SQL access
require_once "/home/site/wwwroot/ScriptFiles/sql.php";

$userid = $_SESSION["UserId"];

$res = mysqli_query($conn, "SELECT CurrentDisplay FROM CurrentDisplays WHERE UserId = '" . $userid . "'");
$time = mysqli_query($conn, "SELECT (UpdateTime - INTERVAL 5 HOUR) AS Formatted_Time FROM CurrentDisplays WHERE UserId = '" . $userid . "'");

// Image-related queries
$stmt = mysqli_prepare($conn, "SELECT ImageView FROM userinfo WHERE UserId = ?");
mysqli_stmt_bind_param($stmt, "i", $userid);
if(mysqli_stmt_execute($stmt)) {
    mysqli_stmt_store_result($stmt);
    mysqli_stmt_bind_result($stmt, $resultbool);
    mysqli_stmt_fetch($stmt);
}

$ImageStmt = mysqli_prepare($conn, "SELECT ImageLocation FROM currentdisplays WHERE UserId = ?");
mysqli_stmt_bind_param($ImageStmt, "i", $userid);
if (mysqli_stmt_execute($ImageStmt)) {
    mysqli_stmt_store_result($ImageStmt);
    mysqli_stmt_bind_result($ImageStmt, $ImageDir);
    mysqli_stmt_fetch($ImageStmt);
}
$ImageDir = substr($ImageDir, 18);
$ImageDir = "/.." . $ImageDir;

// Font family SQL
$Font = mysqli_query($conn, "SELECT Font FROM userinfo WHERE UserId = '" . $userid . "'");
$UserFont = mysqli_fetch_assoc($Font);

$Expiration = mysqli_query($conn, "SELECT Expiration FROM CurrentDisplays WHERE UserId = '" . $userid . "'");

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

h2 {
    font-family: <?php echo $UserFont["Font"] ?>;
    text-align: center;
    word-wrap: break-word;
    white-space: normal;
    width: 90%;
    max-width: 100%;
    margin: 0;
    padding: 0;
}

p {
    font-family: <?php echo $UserFont["Font"] ?>;
    text-align: center;
    word-wrap: break-word;
    white-space: normal;
    width: 90%;
    max-width: 100%;
    margin: 0;
    padding: 0;
}

/* Fullscreen controls */
#fullscreenControls {
    display: none;
    position: absolute;
    top: 10px;
    width: 100%;
    display: flex;
    justify-content: space-between;
    padding: 0 20px;
}

#backArrow, #logo {
    width: 40px;
    height: 40px;
    cursor: pointer;
}

</style>

<html>
    <body>
        <div id="fullscreenControls">
        <img id="backArrow" src="assets/backarrow.png" alt="Back" 
            style="cursor: pointer; position: fixed; top: 10px; left: 10px; width: 40px; height: 40px; z-index: 1000;">

        <img id="logo" src="assets/onulogo.png" alt="Logo" 
            style="position: fixed; top: 10px; right: 10px; width: 60px; height: auto; z-index: 1000; transition: width 0.3s ease;">

        </div>

        <h2 id="currentdisplay">
            <?php  
                if ($resultbool) {
                    echo "<img src='" . $ImageDir . "'>";
                } else {
                    $content = "";
                    while ($row = mysqli_fetch_assoc($res)) {
                        $content .= $row["CurrentDisplay"] . " ";
                    }
                    echo $content;
                    $content = "";
                }
            ?>
        </h2>
        <p>
            <?php
                $timestamp = "";
                echo "<br> Posted Time: ";
                if (mysqli_num_rows($time) > 0) {
                    $rowTime = mysqli_fetch_assoc($time);
                    $timestamp = $rowTime["Formatted_Time"];  
                } else {
                    $timestamp = "";
                }
                echo $timestamp;
            ?>

            <?php
                date_default_timezone_set('America/New_York');
                $ExpirationPrint = "";
                $now = Date("Y-m-d H:i:s");
                if(mysqli_num_rows($time) > 0) {
                    $rowExp = mysqli_fetch_assoc($Expiration);
                    $ExpirationPrint = $rowExp["Expiration"];
                    if ($ExpirationPrint < $now) {
                        echo "<br> <h1>WARNING THIS MESSAGE HAS EXPIRED AS OF:";
                        echo $ExpirationPrint;
                        echo "</h1>";
                    }
                }
            ?>
        </p>
    </body>

    <script>
        function adjustFontSize() {
            let textElement = document.getElementById("currentdisplay");
            if (!textElement || textElement.innerHTML.trim() === "") return;

            let parent = document.documentElement;
            let fontSize = 10;
            textElement.style.fontSize = fontSize + "vw";

            while (textElement.scrollHeight > parent.clientHeight || textElement.scrollWidth > parent.clientWidth) {
                fontSize -= 0.5;
                textElement.style.fontSize = fontSize + "vw";
                if (fontSize < 2) break;
            }
        }

        function checkFullscreen() {
            if (document.fullscreenElement) {
                document.getElementById("fullscreenControls").style.display = "flex";
            } else {
                document.getElementById("fullscreenControls").style.display = "none";
            }
        }

        function exitFullscreen() {
            window.parent.postMessage("exitFullscreen", "*");
        }

        // Back Arrow Click - Send Message to Parent
        document.getElementById("backArrow").addEventListener("click", exitFullscreen);

        function adjustLogoSize() {
            let logo = document.getElementById("logo");
        
            if (document.fullscreenElement) {
                logo.style.width = "100px";
            } else {
                logo.style.width = "60px";
            }
        }

        document.addEventListener("fullscreenchange", adjustLogoSize);
        window.onload = adjustLogoSize;

        document.addEventListener("fullscreenchange", checkFullscreen);
        document.addEventListener("webkitfullscreenchange", checkFullscreen);
        document.addEventListener("msfullscreenchange", checkFullscreen);

        window.onload = adjustFontSize;
        window.onresize = adjustFontSize;
    </script>
</html>
