<?php
require_once "/home/site/wwwroot/ScriptFiles/VerifyLogin.php";

// Enable error reporting for debugging (comment out in production)
//ini_set('display_errors', 1);
//error_reporting(E_ALL);
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
            <form action="insert.php" method="post" id="changedisplay" enctype="multipart/form-data"> 
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
                        <input type="hidden" name="setPresets" value="">
                        <select name="presets" id="presets" onchange="setSelectedValue(this)">
                            <option value="">Select...</option>
                            <option value="I'll be back in 5">I'll be back in 5</option>
                            <option value="I'm off campus for the rest of the day">I'm off campus for the rest of the day</option>
                            <option value="I'll be back soon">I'll be back soon</option>
                            <option value="I'm in class and will be back after">I'm in class and will be back after</option>
                        </select>

                        <p>or select a custom preset:</p>
                        <input type = "hidden" name="customPresets" value="">
                        <select name="custompresets" id="custompresets" onchange="setSelectedValue(this)">
                            <option value="">Select...</option>
                            <option value="custompresettest">CustomPresetTest</option>
                            <!-- need php to handle the database custom preset pulling-->
                        </select>
                    </div>

                    <div id = "Image" style = "display:none;">
                        <label for="imageUpload">Select image to upload (max 500kb):</label>
                        <input type="file" name="imageUpload" id="imageUpload" onchange="validateForm()">
                    </div>


                    <div id="CustomText" style ="display:none;">
                        <p>
                            <label for="Input">Input what you'd like to display (250 chararcter limit):</label>
                            <input type="text" name="textInput" id="Input" maxlength="250" onchange="validateForm()">
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

             // Determine which select element triggered the event
            var triggerElement = select;
            
            // Update the input value based on the triggering element
            if (triggerElement.id === 'presets') {
                document.getElementById('changedisplay').querySelector('[name="customPresets"]').value = '';
                document.getElementById('changedisplay').querySelector('[name="setPresets"]').value = selectedValue;
            } else if (triggerElement.id === 'custompresets') {
                document.getElementById('changedisplay').querySelector('[name="customPresets"]').value = selectedValue;
                document.getElementById('changedisplay').querySelector('[name="setPresets"]').value = '';
            }
            
            // Update form validation
            validateForm();
        }

        function validateForm() {
            var form = document.getElementById('changedisplay');
            var submitButton = form.querySelector('input[type="submit"]');
            
            if (submitButton.disabled) {
                submitButton.disabled = false;
            } else {
                //figure out which element we are looking at and get its selectedValue

                var hasValue = false;
                if(document.getElementById('TypeSpinner').value === "CustomText") {
                    hasValue = document.querySelector('[name="textInput"]').value.trim() !== '';
                }
                if (document.getElementById('TypeSpinner').value === "PresetText") {
                    hasValue =  document.querySelector('[name="presets"]').value !== '' || 
                                document.querySelector('[name="custompresets"]').value !== '';
                }
                if (document.getElementById('TypeSpinner').value === "Image") {
                    hasValue = document.querySelector('[name="imageUpload"]').files.length > 0;
                }
                
                if (hasValue) {
                    submitButton.disabled = false;
                } else {
                    submitButton.disabled = true;
                }
            }
        }
    </script>
