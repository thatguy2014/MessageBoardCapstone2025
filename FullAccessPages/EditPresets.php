<?php
require_once "/home/site/wwwroot/ScriptFiles/VerifyLogin.php";
require_once "/home/site/wwwroot/ScriptFiles/sql.php";
// Enable error reporting for debugging (comment out in production)
ini_set('display_errors', 1);
error_reporting(E_ALL);

$userid = $_SESSION["UserId"];



?>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="/../css/Main.css" />
    </head>
    
    
    <body>
        <div>
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
                    echo "Preset " . $count . ": " . htmlspecialchars($presetsResult) . ".<br>";
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
                    $content = "Preset " . $count . ": " . htmlspecialchars($preset) . ".<br>";
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