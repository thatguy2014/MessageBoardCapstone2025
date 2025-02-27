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
            <form action="insert.php" method="post" id="changedisplay"> 
                    <p> 
                        <label for="TypeSpinner">Select what type of display you'd like to input:</label>
                        <input type="hidden" name="no_input" value="">
                        <select id="TypeSpinner" name="InputType" onchange="displayQuestion(this.value)">
                            <option value="">Select...</option>
                            <option value="CustomText">Custom Text</option>
                            <option value="PresetText">Preset Text</option>
                            <option value="Image">Image</option>
                        </select>
                    </p>

                    <div id = "PresetText" style = "display:none;">
                        <label for = "presets">Select what preset you'd like to display</label>
                        <input type="hidden" name="selected_input" value="">
                        <select name="presets" id="presets" onchange="setSelectedValue(this)">
                            <option value="">Select...</option>
                            <option value="I'll be back in 5">I'll be back in 5</option>
                            <option value="I'm off campus for the rest of the day">I'm off campus for the rest of the day</option>
                            <option value="I'll be back soon">I'll be back soon</option>
                            <option value="I'm in class and will be back after">I'm in class and will be back after</option>
                        </select>

                        <p>or select a custom preset:</p>
                        <input type = "hidden" name="selected_input" value="">
                        <select name="custompresets" id="custompresets" onchange="setSelectedValue(this)">
                            <option value="">Select...</option>
                            <option value="custompresettest">CustomPresetTest</option>
                            <!-- need php to handle the database custom preset pulling-->
                        </select>
                    </div>

                    <div id = "Image" style = "display:none;">
                        <label for="fileToUpload">Select image to upload (max 500kb):</label>
                        <input type="file" name="selected_input" id="fileToUpload" onchange="validateForm()">
                    </div>


                    <div id="CustomText" style ="display:none;">
                        <p>
                            <label for="Input">Input what you'd like to display (250 chararcter limit):</label>
                            <input type="text" name="selected_input" id="Input" maxlength="250" onchange="validateForm()">
                        </p>
                    </div>
                    
                    <input type="submit" value="Submit" disabled>
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

        function setSelectedValue(select) {
            var selectedValue = select.value;
            
            // Update the input value
            document.getElementById('changedisplay').querySelector('[name="selected_input"]').value = selectedValue;

            // Reset other preset dropdowns
            document.querySelectorAll('#changedisplay select[name="presets"], #changedisplay select[name="custompresets"]').forEach(function(presetSelect) {
                if (presetSelect !== select) {
                    presetSelect.value = '';
                }
            });

            // Update form validation
            validateForm();
        }

        function validateForm() {
            var form = document.getElementById('changedisplay');
            var submitButton = form.querySelector('input[type="submit"]');
            
            if (submitButton.disabled) {
                submitButton.disabled = false;
            } else {
                var selectedValue = form.querySelector('[name="selected_input"]').value; //this may need fixed, idk if it'll work right
                if (selectedValue === "") {
                    submitButton.disabled = true;
                } else {
                    submitButton.disabled = false;
                }
            }
        }
    </script>
