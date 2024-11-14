<?php
        $conn = mysqli_init();

        $tsql = "SELECT CurrentDisplay FROM CurrentDisplays WHERE UserId = 1";

        mysqli_options($conn, MYSQLI_OPT_CONNECT_TIMEOUT, 10);
        mysqli_ssl_set($conn, NULL, NULL, "ssl/DigiCertGlobalRootCA.crt.pem", NULL, NULL);
        mysqli_real_connect($conn, "mbcwebbapp-server.mysql.database.azure.com", "PHPLogin", "OctoberNovemberUniform", "mbcwebbapp-database", 3306, MYSQLI_CLIENT_SSL);
        //if (mysqli_connect_errno($conn)) {
        //    die('Failed to connect to MySQL: '.mysqli_connect_error());
        //    }

        //Run the Select query
    printf("Reading data from table: \n");
    $res = mysqli_real_query($conn, 'SELECT * FROM userinfo');
    while ($row = mysqli_fetch_assoc($res)) {
    //var_dump($row);
    print($row);
    }

    //Close the connection
    //mysqli_close($conn);
?>