<?php
//connection data
$conn = mysqli_init();
mysqli_options($conn, MYSQLI_OPT_CONNECT_TIMEOUT, 10);
mysqli_ssl_set($conn, NULL, NULL, "ssl/DigiCertGlobalRootCA.crt.pem", NULL, NULL);
mysqli_real_connect($conn, "mbcwebbapp-server.mysql.database.azure.com", "qzmbodniyz", "YgM0Smd\$bLYYepT1", "mbcwebbapp-database", 3306, MYSQLI_CLIENT_SSL);

?>

<GFG
            <header>
                <div class="HeaderImg">
                    <img src="" alt="" class="">
                </div>
                <h1>Ohio Northern University</h1>
            </header>

            <form action="action_page.php" method="post">
            
                <div class="container">
                <label for="uname"><b>Username</b></label>
                <input type="text" placeholder="Enter Username" name="uname" required>
            
                <label for="psw"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="psw" required>
            
                <a href="CurrentDisplay.php"><!--<button type="submit">Login</button>-->Login</a>
                </div>
            
                <span class="psw"><a href="#">Forgot password?</a></span>

            </form>

            <footer>

            </footer>
