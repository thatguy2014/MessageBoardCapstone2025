<?php
    $url1=$_SERVER['REQUEST_URI'];
    header("Refresh: 60; URL=$url1");         //this should autorefresh

    $conn = mysqli_init();
    mysqli_options($conn, MYSQLI_OPT_CONNECT_TIMEOUT, 10);
    mysqli_ssl_set($conn, NULL, NULL, "ssl/DigiCertGlobalRootCA.crt.pem", NULL, NULL);
    mysqli_real_connect($conn, "mbcwebbapp-server.mysql.database.azure.com", "qzmbodniyz", "YgM0Smd\$bLYYepT1", "mbcwebbapp-database", 3306, MYSQLI_CLIENT_SSL);

    $res = mysqli_query($conn, 'SELECT CurrentDisplay FROM CurrentDisplays');
?>
<style>
html {
    background:white;
}
    </style>
<html>
    <h2 id="currentdisplay" style="background:white">Current Display is -> 
        <?php   
            while ($row = mysqli_fetch_assoc($res)) {
                printf ("%s \n", $row["CurrentDisplay"]);
            } 
        ?>
    </h2>
        </html>