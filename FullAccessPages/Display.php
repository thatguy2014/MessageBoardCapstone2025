<?php
// Display errors for debugging
//ini_set('display_errors', 1);
//error_reporting(E_ALL);
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
    position: fixed;
    top: 10px;
    width: 100%;
    justify-content: space-between;
    padding: 0 20px;
}

/* Default sizes */
#logo, #fullscreen {
    width: 200px;
    height: auto;
    top: 10px;
    z-index: 1000;
    padding: 10px 20px;
    cursor: pointer;
}

#fullscreen {
    position: absolute;
    bottom: 10px;
    left: 10px;
    z-index: 1000;
    width: 40px;
    height: auto;
}

#logo {
    transition: transform 0.3s ease;
    bottom: 20px;
    right: 20px;
    z-index: 1000;
    width:100px
}

.presetbutton {
    background-color: orange;
    color: white;
    border: none;
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    min-width: 100px;
    min-height: 40px;
    max-width: 200px;
}

.presetbutton:hover {
    background-color: darkorange;
}

#main-content {
    width: 90%;
    max-width: 100%;
    margin: 0 auto;
    padding-bottom: 60px;
    height: calc(100vh - 60px); /* Subtracting the bottom padding */
    margin-bottom: 60px; /* Add bottom margin to create space for the footer */
}

.bottomrow-container {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    display: flex;
    justify-content: center;
    gap: 10px;
    padding: 10px 0; /* Add some padding at the top */
    z-index: 999; /* A high value to ensure it stays above other elements */
}

.presetbutton {
    position: relative;
    z-index: 1;
}


</style>

<html>
    <body>
        <div id="fullscreenControls">
            <img id="logo" src="assets/onulogo.png" alt="logo">
        </div>
        <div id="main-content">
            <h2 id="currentdisplay">
                <?php  
                    //printing actual data (text or image)
                    if (!empty($resultbool) && $resultbool == 1) {
                        echo "<img src='" . htmlspecialchars($ImageDir, ENT_QUOTES, 'UTF-8') . "'>";
                    } else {
                        $content = "";
                        while ($row = mysqli_fetch_assoc($res)) {
                            $content .= htmlspecialchars_decode(htmlspecialchars($row["CurrentDisplay"], ENT_QUOTES, 'UTF-8'), ENT_QUOTES) . " ";
                        }
                        echo $content;
                    }
                ?>
            </h2>
            <p>
                <?php
                    //printing posted time
                    echo "<br> Posted Time: ";
                    if (mysqli_num_rows($time) > 0) {
                        $rowTime = mysqli_fetch_assoc($time);
                        echo htmlspecialchars($rowTime["Formatted_Time"], ENT_QUOTES, 'UTF-8');
                    }
                ?>

                <?php
                    //printing expiration
                    date_default_timezone_set('America/New_York');
                    $ExpirationPrint = "";
                    $now = Date("m-d H:i:s");
                    if(mysqli_num_rows($Expiration) > 0) {
                        $rowExp = mysqli_fetch_assoc($Expiration);
                        $ExpirationPrint = $rowExp["Expiration"];
                        if ($ExpirationPrint < $now && $ExpirationPrint != null) {
                            echo "<br> <br> <h1>MESSAGE EXPIRED ON:";
                            echo $ExpirationPrint;
                            echo "</h1>";
                        }
                    }
                ?>
        </div>
            <div class='bottomrow-container'>
                <img id="fullscreen" src="assets/fullscreen.png" alt="fullscreen">
                <?php
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
            </div>
        </p>
    </body>

    <script>
        var elem = document.documentElement;
                

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
            elem.contentWindow.postMessage("exitFullscreen", "*");
        }

        function FullscreenPress() {
                    console.log("Fullscreen Button Pressed");
                    if (document.fullscreenElement || document.webkitFullscreenElement || document.msFullscreenElement) {
                        console.log("Unfullscreening page");
                        exitFullscreen();
                    }else {
                        console.log("Making screen fullscreen");
                        openFullscreen();
                    }
                }

        function handlePresetButtonClick(event) {
            // Get the clicked button element
            const button = event.target;
            
            // Check if the button has text content
            if (button.textContent.trim()) {
                // Get the text content of the button
                const buttonText = button.textContent.trim();
                
                // Call a function to process the selected preset
                processSelectedPreset(buttonText);
            }
        }

        // Function to process the selected preset
        function processSelectedPreset(buttonText) {
            // Send an AJAX request to your insert.php
            fetch('insert.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `textInput=${encodeURIComponent(buttonText)}&InputType=CustomText`
            })
            .then(response => response.text())
            .then(data => {
                console.log(data);
                // Refresh the page
                window.location.reload();
            })
            .catch(error => console.error('Error:', error));
        }

        document.getElementById('fullscreen').addEventListener('click', FullscreenPress)

        document.querySelectorAll('.presetbutton').forEach(button => {
        button.addEventListener('click', handlePresetButtonClick);
        });

        window.onload = () => {
            adjustFontSize();
        };

        window.onresize = adjustFontSize;
    </script>
</html>
