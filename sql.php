<?php

        define('DB_SERVER', 'mbcwebbapp-server.mysql.database.azure.com');
        define('DB_USERNAME', 'qzmbodniyz');
        define('DB_PASSWORD', "YgM0Smd\$bLYYepT1");
        define('DB_NAME', 'mbcwebbapp-database');


        $conn = mysqli_init();
        mysqli_options($conn, MYSQLI_OPT_CONNECT_TIMEOUT, 10);
        mysqli_ssl_set($conn, NULL, NULL, "ssl/DigiCertGlobalRootCA.crt.pem", NULL, NULL);
        $link = mysqli_real_connect($conn, DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME, 3306, MYSQLI_CLIENT_SSL);
        
        if (mysqli_connect_errno()) {
            die("ERROR: Could not connect. " . mysqli_connect_error());
        }

        //Run the Select query
    $res = mysqli_query($conn, 'SELECT CurrentDisplay FROM CurrentDisplays');
?>

<html>
    <p>
        Reading Data from table:
        <?php
            while ($row = mysqli_fetch_assoc($res)) {
                printf ("%s \n", $row["CurrentDisplay"]);
            }
        ?>
    </p>
</html>
