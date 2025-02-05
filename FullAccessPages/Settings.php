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
                <h1>Office Message Board Custom Text Display</h1>
            </header>
            <?php include '/home/site/wwwroot/templates/navbar.html'; ?>
            <form action="/../ScriptFiles/SettingsUpdate.php" method="post" enctype="multipart/form-data">
                <p>Would you like to display your uploaded Image or Text?</p>
                <input type="radio" id="Image" name="ImageSetting" value="Image">
                <label for="Image">Display Image</label><br>
                <input type="radio" id="Text" name="ImageSetting" value="Text">
                <label for="Text">Display Text</label><br>
                <input type="submit" value="Save Changes">
            </form>
        </div>
    </body>
    <footer>
        
    </footer>
