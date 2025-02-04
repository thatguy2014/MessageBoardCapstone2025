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
                <h1>Office Message Board Presets</h1>
            </header>

            <?php include '/home/site/wwwroot/templates/navbar.html'; ?>
            
            <p>Select a preset below:</p>
            <form action="insert.php" method="post" id="presetform">
                <input type="hidden" name="selected_input" value="">
                <select name="presets" id="presets" onchange="setSelectedValue(this)">
                    <option value="">Select...</option>
                    <option value="I'll be back in 5">I'll be back in 5</option>
                    <option value="I'm off campus for the rest of the day">I'm off campus for the rest of the day</option>
                    <option value="I'll be back soon">I'll be back soon</option>
                    <option value="I'm in class and will be back after">I'm in class and will be back after</option>
                </select>
                <input type="submit" value="Submit" disabled>
            </form>

            <script>
                function setSelectedValue(select) {
                    var selectedValue = select.value;
                    document.getElementById('presetform').querySelector('[name="selected_input"]').value = selectedValue;
                    validateForm();
                }

                function validateForm() {
                    var form = document.getElementById('presetform');
                    var submitButton = form.querySelector('input[type="submit"]');
                    
                    if (submitButton.disabled) {
                        submitButton.disabled = false;
                    } else {
                        var selectedValue = form.querySelector('[name="selected_input"]').value;
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
</html>
