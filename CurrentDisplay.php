<?php
    /*$url1=$_SERVER['REQUEST_URI'];
    header("Refresh: 60; URL=$url1");*/         //this should autorefresh
   
    //include('sql.php');               //I will need to go back to this but want to test

    $conn = mysqli_init();

    $tsql = "SELECT CurrentDisplay FROM CurrentDisplays WHERE UserId = 1";

    mysqli_options($conn, MYSQLI_OPT_CONNECT_TIMEOUT, 10);
    mysqli_ssl_set($conn, NULL, NULL, "ssl/DigiCertGlobalRootCA.crt.pem", NULL, NULL);
    mysqli_real_connect($conn, "mbcwebbapp-server.mysql.database.azure.com", "qzmbodniyz", "YgM0Smd\$bLYYepT1", "mbcwebbapp-database", 3306, MYSQLI_CLIENT_SSL);

    //Run the Select query
    //printf("Reading data from table: \n");
    $res = mysqli_query($conn, 'SELECT CurrentDisplay FROM CurrentDisplays');
    //while ($row = mysqli_fetch_assoc($res)) {
    //    printf ("%s \n", $row["CurrentDisplay"]);
    //} 
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
    <section>
        <h2>Current Display is -> 
            <?php   while ($row = mysqli_fetch_assoc($res)) {
                        printf ("%s \n", $row["CurrentDisplay"]);
                    } ?>
        </h2>
    </section>
    <footer>
        <p>&copy; 2023 Your Website</p>
    </footer>
