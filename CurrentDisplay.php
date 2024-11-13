<?php
    /*$url1=$_SERVER['REQUEST_URI'];
    header("Refresh: 60; URL=$url1");*/         //this should autorefresh
    /*try {
        $con = mysqli_init();
        if (!$con) {
            throw new Exception("Failed to initialize MySQL connection");
        }
        
        mysqli_ssl_set($con, NULL, NULL, "ssl\DigiCertGlobalRootCA.crt.pem", NULL, NULL);
        $conn = mysqli_real_connect($con, "mbcwebbapp-server.mysql.database.azure.com", "qzmbodniyz", "YgM0Smd$bLYYepT1", "mbcwebbapp-database", 3306, MYSQLI_CLIENT_SSL);
        
        if (!$conn) {
            throw new Exception("Failed to connect to MySQL server: " . mysqli_error($con));
        }
    
    } catch (Exception $e) {
        $error_message = "An error occurred: " . $e->getMessage();
        die(print("<div style='color: red;'>Error: $error_message</div>"));
    } finally {
        if (isset($con)) {
            mysqli_close($con);
        }
    }*/
?>

<GFG
    <header>
        <h1>Office Message Board</h1>
    </header>
    <nav>
        <ul>
            <li><a href="CurrentDisplay">Current Display</a></li>
            <li><a href="Presets.php">Presets</a></li>
            <li><a href="ChangeDisplay.php">Change Display</a></li>
            <li><a href="/">Logout</a></li>
        </ul>
    </nav>
    <section>
        <h2>Current Display is -> <?php echo htmlspecialchars($getResults); ?></h2>
    </section>
    <footer>
        <p>&copy; 2023 Your Website</p>
    </footer>
