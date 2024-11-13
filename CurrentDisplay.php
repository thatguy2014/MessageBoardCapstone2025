<?php
    /*$url1=$_SERVER['REQUEST_URI'];
    header("Refresh: 60; URL=$url1");*/         //this should autorefresh
    try {
        $conn = mysqli_init();
        mysqli_ssl_set($conn,NULL,NULL, "ssl\DigiCertGlobalRootCA.crt.pem", NULL, NULL);
        //mysqli_real_connect($conn, "mbcwebbapp-server.mysql.database.azure.com", "qzmbodniyz", "YgM0Smd$bLYYepT1", "mbcwebbapp-database", 3306, MYSQLI_CLIENT_SSL);
        //$tsql = "SELECT CurrentDisplay FROM CurrentDisplays WHERE UserId = 1";
        //$getResults = sqlsrv_query($conn, $tsql);
    }
    catch {
        print("Connection failed: " . mysqli_connect_error());
}



?>

<GFG
    <header>
        <h1>Office Message Board</h1>
    </header>
    <nav>
        <ul>
            <li><a href="CurrentDisplay">Current Display</a></li>
            <li><a href="Presets.php">Presets</a></li>
            <li><a href="ChangeDisplay.php">Change Display</a></li>
            <li><a href="/">Logout</a></li>
        </ul>
    </nav>
    <section>
        <h2>Current Display is -> <?php echo htmlspecialchars($getResults); ?></h2>
    </section>
    <footer>
        <p>&copy; 2023 Your Website</p>
    </footer>
