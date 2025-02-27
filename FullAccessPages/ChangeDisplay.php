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
                <h1>Office Message Board Change Display</h1>
            </header>
            <?php include '/home/site/wwwroot/templates/navbar.html'; ?>
            <form action="insert.php" method="post"> 
                    <p> 
                        <label for="TypeSpinner">Select what type of display you'd like to input:</label>
                        <select id="TypeSpinner" name="InputType" onchange="displayQuestion(this.value)">
                            <option value="CustomText">Custom Text</option>
                            <option value="PresetText">Preset Text</option>
                            <option value="Image">Image</option>
                        </select>
                    </p>

                    <div id = "PresetText" style = "display:none;">
                        <p>Preset Text</p>
                    </div>

                    <div id = "Image" style = "display:none;">
                        <p>Image Text</p>
                    </div>


                    <div id="CustomText" style ="display:none;">
                        <p>
                            <label for="Input">Input what you'd like to display (250 chararcter limit):</label>
                            <input type="text" name="selected_input" id="Input" maxlength="250">
                        </p>
                    </div>
                    
                    <input type="submit" value="Submit">
            </form>
        </div>
    </body>
    <footer>
        
    </footer>


    <script>
        function displayQuestion(answer) {
            document.getElementById(answer).style.display = "block";
            if (answer != "PresetText") { // hide the div that is not selected
                document.getElementById('PresetText').style.display = "none";
            }
            if (answer != "Image") {
                document.getElementById('Image').style.display = "none";
            }
            if (answer != "CustomText") {
                document.getElementById('CustomText').style.display = "none";
            }
        }
    </script>
