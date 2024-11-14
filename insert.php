<?php
$conn = mysqli_init();
mysqli_options($conn, MYSQLI_OPT_CONNECT_TIMEOUT, 10);
mysqli_ssl_set($conn, NULL, NULL, "ssl/DigiCertGlobalRootCA.crt.pem", NULL, NULL);
mysqli_real_connect($conn, "mbcwebbapp-server.mysql.database.azure.com", "PHPLogin", "OctoberNovemberUniform", "mbcwebbapp-database", 3306, MYSQLI_CLIENT_SSL);



$displaydata = $_REQUEST['Input'];


if(mysqli_query($conn, 'UPDATE CurrentDisplays SET CurrentDisplay = '$displaydata' WHERE UserId = 1')){
    echo "<h3>data stored in a database successfully." 
        . " Please browse your localhost php my admin" 
        . " to view the updated data</h3>"; 
    } else{
        echo "ERROR: Hush! Sorry $sql. " 
            . mysqli_error($conn);
    }
    
    // Close connection
    mysqli_close($conn);

?>