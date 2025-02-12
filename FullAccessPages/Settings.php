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
                <h1>Office Message Board Display Settings</h1>
            </header>
            <?php include '/home/site/wwwroot/templates/navbar.html'; ?>
            <form action="/../ScriptFiles/SettingsUpdate.php" method="post" enctype="multipart/form-data" id="SettingsForm">
                <p>Would you like to display your uploaded Image or Text?</p>
                <input type="radio" id="Image" name="ImageSetting" value="Image">
                <label for="Image">Display Image</label><br>
                <input type="radio" id="Text" name="ImageSetting" value="Text">
                <label for="Text">Display Text</label><br>

                <br>

                <p> What Font would you like? </p>
                <input type="hidden" name="Font" value="">
                <select name="Font" id="Font" onchange="setSelectedValue(this)">
                    <option value="">Select...</option>
                    <option value="TimesNewRoman">Times New Roman</option>
                    <option value="Arial">Arial</option>
                    <option value="ComicSans">Comic Sans</option>
                    <option value="Impact">Impact</option>
                </select>

                <input type="submit" value="Save Changes">
                
            </form>

            <script>

            function setSelectedValue(select) {
                    var selectedValue = select.value;
                    document.getElementById('SettingsForm').querySelector('[name="Font"]').value = selectedValue;
                    validateForm();
                }

            function validateForm() {
                var form = document.getElementById('SettingsForm');
                var submitButton = form.querySelector('input[type="submit"]');
                
                if (submitButton.disabled) {
                    submitButton.disabled = false;
                } else {
                    var selectedValue = form.querySelector('[name="Font"]').value;
                    if (selectedValue === "") {
                        submitButton.disabled = true;
                    } else {
                        submitButton.disabled = false;
                    }
                }
            }

            </script>
            
        </div>
    </body>
    <footer>
        
    </footer>
