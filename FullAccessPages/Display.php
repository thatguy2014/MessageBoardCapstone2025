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

// The following lines should connect to the database and run the query
$userid = $_SESSION["UserId"];

$res = mysqli_query($conn, "SELECT CurrentDisplay FROM CurrentDisplays WHERE UserId = '" . $userid . "'");
$time = mysqli_query($conn, "SELECT (UpdateTime - INTERVAL 5 HOUR) FROM CurrentDisplays WHERE UserId = '" . $userid . "'");

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
?>

<style>
html, body {                  
    background: white;
    height: 100%;
    width: 100%;
    overflow: hidden; /* Prevents scrolling */
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 0;
    padding: 0;
    text-align: center;
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

/* Ensures images fit properly */
h2 img {
    max-width: 90%;
    height: auto;
}
</style>

<html>
    <body>
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
                    $timestamp = "";
                    echo "<br> Posted Time: ";
                    if (mysqli_num_rows($time) > 0) {
                        $row = mysqli_fetch_assoc($time);
                        //debugging lines
                        echo "debugging: ";
                        while ($row = mysqli_fetch_assoc($res)) {
                            $content .= $row["UpdateTime"] . " ";
                            echo $content;
                        }
                        echo "<br>";
                        $timestamp = date("Y-m-d H:i:s", $row["UpdateTime"]);
                        //end of debugging
                        echo $timestamp;
                    } else {
                        $timestamp = "";
                    }
                    echo $timestamp;
                }
            ?>
        </h2>
    </body>

    <script>
        function adjustFontSize() {
            let textElement = document.getElementById("currentdisplay");
            if (!textElement || textElement.innerHTML.trim() === "") return;

            let parent = document.documentElement;
            let fontSize = 10; // Start with a large font size
            textElement.style.fontSize = fontSize + "vw";

            // Reduce font size if text overflows
            while (textElement.scrollHeight > parent.clientHeight || textElement.scrollWidth > parent.clientWidth) {
                fontSize -= 0.5;
                textElement.style.fontSize = fontSize + "vw";
                if (fontSize < 2) break; // Prevents infinite loop
            }
        }

        window.onload = adjustFontSize;
        window.onresize = adjustFontSize;
    </script>
</html>
