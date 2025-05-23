<?php

// Starts displaying errors when things go wrong
ini_set('display_errors', 1);
error_reporting(E_ALL);
// Start a session
session_start();           

// Verify user is logged in
require_once "/home/site/wwwroot/ScriptFiles/VerifyViewOnlyLogin.php";

// Verify we are connected to the database
require_once "/home/site/wwwroot/ScriptFiles/sql.php";

// Fetch the user ID
$userid = $_SESSION["UserId"];

// Retrieve whether the user has an image display enabled
$stmt = mysqli_prepare($conn, "SELECT ImageView FROM userinfo WHERE UserId = ?");
$res = mysqli_query($conn, "SELECT CurrentDisplay FROM CurrentDisplays WHERE UserId = '" . $userid . "'");
$time = mysqli_query($conn, "SELECT (UpdateTime - INTERVAL 5 HOUR) AS Formatted_Time FROM CurrentDisplays WHERE UserId = '" . $userid . "'");

mysqli_stmt_bind_param($stmt, "i", $userid);

if (mysqli_stmt_execute($stmt)) {
    mysqli_stmt_store_result($stmt);
    mysqli_stmt_bind_result($stmt, $resultbool);
    mysqli_stmt_fetch($stmt);
}

// Retrieve the image location (if any)
$ImageStmt = mysqli_prepare($conn, "SELECT ImageLocation FROM currentdisplays where UserId = ?");
mysqli_stmt_bind_param($ImageStmt, "i", $userid);
if (mysqli_stmt_execute($ImageStmt)) {
    mysqli_stmt_store_result($ImageStmt);
    mysqli_stmt_bind_result($ImageStmt, $ImageDir);
    mysqli_stmt_fetch($ImageStmt);
}

$ImageDir = substr($ImageDir, 18);
$ImageDir = "/.." . $ImageDir;

// Fetch the current display text
$displayText = "";
if (!$resultbool) {
    while ($row = mysqli_fetch_assoc($res)) {
        $displayText .= $row["CurrentDisplay"] . " ";
    }
    $displayText = trim($displayText);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Current Display</title>
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
            font-family: <?php echo $UserFont["Font"] ?? "Arial, sans-serif"; ?>;
            text-align: center;
            word-wrap: break-word;
            white-space: normal;
            width: 90%;
            max-width: 100%;
            margin: 0;
            padding: 0;
            font-size: 5vw; /* Default size */
            font-weight: bold;
        }

        /* Ensures images fit properly */
        h2 img {
            max-width: 90%;
            height: auto;
        }
    </style>
</head>
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
            }
        ?>
    </h2>

    <script>
        function resizeText() {
            const textElement = document.getElementById('currentdisplay');
            const parent = document.body;
            
            let fontSize = 10; // Start small
            textElement.style.fontSize = fontSize + "px";

            // Increase font size until it fits the screen width/height
            while (textElement.scrollWidth < parent.clientWidth && textElement.scrollHeight < parent.clientHeight) {
                fontSize += 2;
                textElement.style.fontSize = fontSize + "px";
            }

            // Reduce font size slightly to prevent overflow
            textElement.style.fontSize = (fontSize - 4) + "px";
        }

        window.onload = resizeText;
        window.onresize = resizeText; // Resize text when screen size changes
    </script>
</body>
</html>
