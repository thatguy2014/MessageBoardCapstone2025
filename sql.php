<?php
try {
        $conn = mysqli_init();
        if (!$conn) {
            throw new Exception("Failed to initialize MySQL connection");
        }

        $tsql = "SELECT CurrentDisplay FROM CurrentDisplays WHERE UserId = 1";

        mysqli_options($conn, MYSQLI_OPT_CONNECT_TIMEOUT, 10);
        mysqli_ssl_set($conn, NULL, NULL, "ssl/DigiCertGlobalRootCA.crt.pem", NULL, NULL);
        mysqli_real_connect($conn, "mbcwebbapp-server.mysql.database.azure.com", "PHPLogin", "OctoberNovemberUniform", "mbcwebbapp-database", 3306, MYSQLI_CLIENT_SSL);
        

        $getResults = mysqli_real_query($conn, $tsql);
        $printResult = $conn -> use_result();
        print($printResult);


        //if (mysqli_connect_errno($conn)) {
            //throw new Exception("Failed to connect to MySQL server: " . mysqli_error($conn));
        //} 
            
        
    
    } catch (Exception $e) {
        $error_message = "An error occurred: " . $e->getMessage();
        die(print("<div style='color: red;'>Error: $error_message</div>"));
    }
    
    /*finally {
        if (isset($conn)) {
            mysqli_close($conn);
        }
    }*/
?>