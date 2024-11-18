<?php

?>

<html>
    <header>
        <h1>Office Message Board</h1>
    </header>
    <nav>
        <ul>
            <li><a href="CurrentDisplay.php">Current Display</a></li>
            <li><a href="Presets.php">Presets</a></li>
            <li><a href="ChangeDisplay.php">Change Display</a></li>
            <li><a href="/">Logout</a></li>
        </ul>
    </nav>
    <body>
    <form action="insert.php" method="post"> 
            <p>
                <label for="Input">Input what you'd like to display:</label>
                <input type="text" name="Input" id="Input">
            </p>
            
            <input type="submit" value="Submit">
    </form>





    </body>
    <footer>
        <p>&copy; 2023 Your Website</p>
    </footer>
