<?php
require_once "/home/site/wwwroot/ScriptFiles/VerifyLogin.php";
require_once "/home/site/wwwroot/ScriptFiles/sql.php";
// Enable error reporting for debugging (comment out in production)
ini_set('display_errors', 1);
error_reporting(E_ALL);

$userid = $_SESSION["UserId"];



?>
<style>
div#all {
    max-width: 90%;
    margin: 0 auto; /* center the div horizontally */
    word-wrap: break-word;
    overflow-wrap: break-word;
    white-space: normal;
}
.preset-display {
    max-width: 100%;
    word-wrap: break-word;
    overflow-wrap: break-word;
    word-break: break-all;
    white-space: normal;
    background-color: #f2f2f2;
    padding: 8px;
    margin: 10px 0;
    border-radius: 5px;
    border: 1px solid #ccc;
    font-family: sans-serif;
}
</style>

<html>
    <head>
        <link rel="stylesheet" type="text/css" href="/../css/Main.css" />
    </head>
    
    
    <body>
        <div id="all" class="center-container">
            <header>
                <h1>Office Message Board Edit Custom Presets</h1>
            </header>
            <?php include '/home/site/wwwroot/templates/navbar.html'; ?>

            <p>
            <?php
            //need sql to pull all of the current custompreset options
            $count = 1;
            $presetsQuery = mysqli_prepare($conn, "SELECT PresetString FROM presets WHERE UserId = ?");
            mysqli_stmt_bind_param($presetsQuery, "i", $userid);
            if(mysqli_stmt_execute($presetsQuery)) {
                mysqli_stmt_store_result($presetsQuery);
                mysqli_stmt_bind_result($presetsQuery, $presetsResult);
                if (mysqli_stmt_fetch($presetsQuery)) {
                    $Preset1 = htmlspecialchars($presetsResult);
                    echo "<div class='preset-display'>Preset $count: " . htmlspecialchars($presetsResult) . ".</div>";
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

            // Then use $presets in your HTML generation
            
            foreach ($presets as $preset) {
                if (!empty($preset)) {
                    $count++;
                    $content = "<div class='preset-display'>Preset " . $count . ": " . htmlspecialchars($preset) . ".<br></div>";
                    echo $content;
                }
            }


            ?>
            </p>
            <form action="/../ScriptFiles/EditPresetScript.php" method="post" id="editpresets"> 
                <div id="addPresetDiv" style ="display:block;">
                    <p>
                        <label for="addPresetinput">Input what text you would like to be a preset(max characters: 250)</label>
                        <input type="text" name="addPresetinput" id="addPresetinput" maxlength="250" onchange="">
                    </p>
                </div>

                <div id = "deletePresetDiv" style = "display:block;">
                    <label for = "deletePresetInput">Select what preset you'd like to delete</label>
                    <input type = "hidden" name="deletePresetInput_hidden" value="">
                    <select name="deletePresetInput" id="deletePresetInput" onchange="">
                        <option value="">Select...</option>
                        <?php

                            //  use $presets in your HTML generation
                            echo "<option value=\"" . $Preset1 . "\">" . $Preset1 . "</option>";
                            foreach ($presets as $preset) {
                                if (!empty($preset)) {
                                    $content = "<option value=\"" . htmlspecialchars($preset) . "\">" . htmlspecialchars($preset) . "</option>";
                                    echo $content;
                                }
                            }
                        ?>
                    </select>
                </div>
                    <p>
                        <b>Note: Your top 4 Custom Presets will be made quick presets on the display page.</b>
                    </p>
                <input type="submit" value="Submit">
            </form>



        </div>
        

    </body>