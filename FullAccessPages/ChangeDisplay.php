<?php
require_once "/../ScriptFiles/VerifyLogin.php";
?>
<html>
    <header>
        <h1>Office Message Board</h1>
    </header>
    <?php include '/../templates/navbar.html'; ?>
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
