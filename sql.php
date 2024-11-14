<?php
try {
        $conn = mysqli_init();
        if (!$conn) {
            throw new Exception("Failed to initialize MySQL connection");
        }
        
        mysqli_ssl_set($conn, NULL, NULL, "ssl/DigiCertGlobalRootCA.crt.pem", NULL, NULL);
        mysqli_real_connect($conn, "mbcwebbapp-server.mysql.database.azure.com", "PHPLogin", "OctoberNovemberUniform", "mbcwebbapp-database", 3306, MYSQLI_CLIENT_SSL);
        
        

        //if (mysqli_connect_errno($conn)) {
        //    throw new Exception("Failed to connect to MySQL server: " . mysqli_error($con));
        //} 
            
        
    
    } catch (Exception $e) {
        $error_message = "An error occurred: " . $e->getMessage();
        die(print("<div style='color: red;'>Error: $error_message</div>"));
    }
    print("debug \n");
    /*finally {
        if (isset($con)) {
            mysqli_close($con);
        }
    }*/
?>