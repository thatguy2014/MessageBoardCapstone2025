<?php
try {
        /*$conn = mysqli_init();
        if (!$conn) {
            throw new Exception("Failed to initialize MySQL connection");
        }

        $tsql = "SELECT CurrentDisplay FROM CurrentDisplays WHERE UserId = 1";

        mysqli_options($conn, MYSQLI_OPT_CONNECT_TIMEOUT, 10);
        mysqli_ssl_set($conn, NULL, NULL, "ssl/DigiCertGlobalRootCA.crt.pem", NULL, NULL);
        mysqli_real_connect($conn, "mbcwebbapp-server.mysql.database.azure.com", "PHPLogin", "OctoberNovemberUniform", "mbcwebbapp-database", 3306, MYSQLI_CLIENT_SSL);
        
        $result = mysqli_real_query($conn, $tsql);

        //$storeresult = mysqli_store_result($conn);

        print($result);
        //$row = mysqli_fetch_assoc($result);

        if ($row) {
            echo "<div style='color: green;'>Current Display: " . htmlspecialchars($row['CurrentDisplay']) . "</div>";
        } else {
            echo "<div style='color: red;'>No results found.</div>";
        }









        //mysqli_free_result($result);          //this was breaking it earlier
        //print($result);
        while ($row=mysqli_fetch_row($result))
        {
        printf ("%s (%s)\n",$row[0],$row[1]);
        }
        // Free result set
        mysqli_free_result($result);
        



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
        }*/

        $mysqli = new mysqli("mbcwebbapp-server.mysql.database.azure.com", "PHPLogin", "OctoberNovemberUniform", "mbcwebbapp-database", 3306, MYSQLI_CLIENT_SSL);

        // Check connection
        if ($mysqli -> connect_errno) {
          echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
          exit();
        }
        
        $mysqli -> real_query("SELECT * FROM CurrentDisplays");
        
        if ($mysqli -> field_count) {
          $result = $mysqli -> store_result();
          $row = $result -> fetch_row();
          printf ("%s (%s)\n", $row[0], $row[1]);
          // Free result set
          $result -> free_result();
        }
        
        $mysqli -> close();





    }
?>