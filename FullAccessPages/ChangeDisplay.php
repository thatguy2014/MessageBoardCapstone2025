<?php
require_once "/home/site/wwwroot/ScriptFiles/VerifyLogin.php";
?>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="/../css/Main.css" />
    </head>
    <header>
        <h1>Office Message Board Custom Display</h1>
    </header>
    <?php include '/home/site/wwwroot/templates/navbar.html'; ?>
    <body>
    <form action="insert.php" method="post"> 
            <p>
                <label for="Input">Input what you'd like to display:</label>
                <input type="text" name="selected_input" id="Input">
            </p>
            
            <input type="submit" value="Submit">
    </form>

    </body>
    <footer>
        
    </footer>
