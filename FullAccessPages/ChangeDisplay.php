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
            <form action="insert.php" method="post"> 
                    <p>
                        <label for="Input">Input what you'd like to display (250 chararcter limit):</label>
                        <input type="text" name="selected_input" id="Input" maxlength="250">
                    </p>
                    
                    <input type="submit" value="Submit">
            </form>
        </div>
    </body>
    <footer>
        
    </footer>
