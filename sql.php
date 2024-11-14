<?php
        $conn = mysqli_init();

        $tsql = "SELECT CurrentDisplay FROM CurrentDisplays WHERE UserId = 1";

        mysqli_options($conn, MYSQLI_OPT_CONNECT_TIMEOUT, 10);
        mysqli_ssl_set($conn, NULL, NULL, "ssl/DigiCertGlobalRootCA.crt.pem", NULL, NULL);
        mysqli_real_connect($conn, "mbcwebbapp-server.mysql.database.azure.com", "PHPLogin", "OctoberNovemberUniform", "mbcwebbapp-database", 3306, MYSQLI_CLIENT_SSL);

        //Run the Select query
    printf("Reading data from table: \n");
    $res = mysqli_query($conn, 'SELECT CurrentDisplay FROM CurrentDisplays');
    while ($row = mysqli_fetch_assoc($res)) {
    printf ("%s \n", $row["CurrentDisplay"]);
    }
?>