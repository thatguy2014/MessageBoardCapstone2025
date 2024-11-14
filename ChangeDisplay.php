<?php

    //connection data
    $conn = mysqli_init();
    mysqli_options($conn, MYSQLI_OPT_CONNECT_TIMEOUT, 10);
    mysqli_ssl_set($conn, NULL, NULL, "ssl/DigiCertGlobalRootCA.crt.pem", NULL, NULL);
    mysqli_real_connect($conn, "mbcwebbapp-server.mysql.database.azure.com", "PHPLogin", "OctoberNovemberUniform", "mbcwebbapp-database", 3306, MYSQLI_CLIENT_SSL);

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
