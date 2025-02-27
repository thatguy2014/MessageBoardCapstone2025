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
            this is going to display all of your current presets
            </p>
            <form action="/../ScriptFiles/EditPresetScript.php" method="post" id="editpresets"> 
                <div id="addPresetDiv" style ="display:block;">
                    <p>
                        <label for="addPresetinput">Input what text you would like to be a preset(max characters: 250)</label>
                        <input type="text" name="addPresetinput" id="addPresetinput" maxlength="250" onchange="validateForm()">
                    </p>
                </div>

                <div id = "deletePresetDiv" style = "display:block;">
                    <label for = "deletePresetInput">Select what preset you'd like to delete</label>
                    <input type = "hidden" name="deletePresetInput_hidden" value="">
                    <select name="deletePresetInput" id="deletePresetInput" onchange="setSelectedValue(this)">
                        <option value="">Select...</option>
                        <option value="custompresettest">CustomPresetTest</option>
                        <?php
                            //need sql to pull all of the current custompreset options
                            echo "running php";
                            $presetsQuery = mysqli_prepare($conn, "SELECT PresetString FROM presets WHERE UserId = ?");
                            mysqli_stmt_bind_param($presetsQuery, "i", $userid);
                            echo "running query";
                            if(mysqli_stmt_execute($presetsQuery)) {
                                mysqli_stmt_store_result($presetsQuery);
                                mysqli_stmt_bind_result($presetsQuery, $presetsResult);
                                mysqli_stmt_fetch($presetsQuery);
                            }
                            while ($row = mysqli_fetch_assoc($res)) {
                                $content = "<option value=\"";
                                $content .= $row["PresetString"] . "\"> " . $row["PresetString"] . "</option>";
                                echo $content;
                            }
                            $content = "";
                            echo "done with php";
                        ?>
                    </select>
                </div>

                <input type="submit" value="Submit" disabled>
            </form>



        </div>
        

    </body>