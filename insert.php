<!DOCTYPE html>
<html>

    <head>
        <title>Insert Page page</title>
    </head>

    <body>
            <?php
            $conn = mysqli_init();
            mysqli_options($conn, MYSQLI_OPT_CONNECT_TIMEOUT, 10);
            mysqli_ssl_set($conn, NULL, NULL, "ssl/DigiCertGlobalRootCA.crt.pem", NULL, NULL);
            mysqli_real_connect($conn, "mbcwebbapp-server.mysql.database.azure.com", "qzmbodniyz", "YgM0Smd\$bLYYepT1", "mbcwebbapp-database", 3306, MYSQLI_CLIENT_SSL);


            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (isset($_POST['selected_input'])) {
                    $selectedInput = htmlspecialchars($_POST['selected_input']);
                    
                    //testing the received value
                    echo "Received value: " . $selectedInput . "<br>";
                    // Update the database with the selected input
                    mysqli_query($conn, "UPDATE CurrentDisplays SET CurrentDisplay = $selectedInput WHERE UserId = 1");
                    
                    // Display success message
                    echo "<p>Preset updated successfully.</p>";
                } else {
                    echo "<p>Error: No preset selected.</p>";
                }
            }
            
            $displaydata = $_REQUEST['Input'];

            mysqli_query($conn, "UPDATE CurrentDisplays SET CurrentDisplay = '$displaydata' WHERE UserId = 1")
            ?>
            <p>query sent,click <a href="CurrentDisplay.php">here</a> to view current display</p>
    </body>

</html>
