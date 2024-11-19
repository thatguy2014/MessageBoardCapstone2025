<!DOCTYPE html>
<html>

    <head>
        <title>Insert Page page</title>
    </head>

    <body>
        <center>
            <?php
            $conn = mysqli_init();
            mysqli_options($conn, MYSQLI_OPT_CONNECT_TIMEOUT, 10);
            mysqli_ssl_set($conn, NULL, NULL, "ssl/DigiCertGlobalRootCA.crt.pem", NULL, NULL);
            mysqli_real_connect($conn, "mbcwebbapp-server.mysql.database.azure.com", "qzmbodniyz", "YgM0Smd\$bLYYepT1", "mbcwebbapp-database", 3306, MYSQLI_CLIENT_SSL);


            $displaydata = $_REQUEST['Input'];

            mysqli_query($conn, "UPDATE CurrentDisplays SET CurrentDisplay = '$displaydata' WHERE UserId = 1")

            ?>
        </center>
    </body>

</html>