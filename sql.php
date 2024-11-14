<?php
        $conn = mysqli_init();

        $tsql = "SELECT CurrentDisplay FROM CurrentDisplays WHERE UserId = 1";

        mysqli_options($conn, MYSQLI_OPT_CONNECT_TIMEOUT, 10);
        mysqli_ssl_set($conn, NULL, NULL, "ssl/DigiCertGlobalRootCA.crt.pem", NULL, NULL);
        mysqli_real_connect($conn, "mbcwebbapp-server.mysql.database.azure.com", "PHPLogin", "OctoberNovemberUniform", "mbcwebbapp-database", 3306, MYSQLI_CLIENT_SSL);
        if (mysqli_connect_errno($conn)) {
            die('Failed to connect to MySQL: '.mysqli_connect_error());
            }
        if (mysqli_query($conn, '
        CREATE TABLE Products (
        `Id` INT NOT NULL AUTO_INCREMENT ,
        `ProductName` VARCHAR(200) NOT NULL ,
        `Color` VARCHAR(50) NOT NULL ,
        `Price` DOUBLE NOT NULL ,
        PRIMARY KEY (`Id`)
        );
        ')) {
        printf("Table created\n");
        }
        
        //Close the connection
        mysqli_close($conn);
        ?>
?>