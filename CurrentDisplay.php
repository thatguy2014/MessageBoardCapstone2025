<?php
    /*$url1=$_SERVER['REQUEST_URI'];
    header("Refresh: 60; URL=$url1");*/         //this should autorefresh

    $host = "office-message-board-sqlserver.database.windows.net";
    $username = "ONUMBC";
    $password = "Am!At@Bd#Jt\$Th%";
    $dbname = "OfficeMessageBoardSQLDB";
    $conn = mysqli_connect($host, $username, $password, $dbname);
    
    if (!$conn) {
        die(print("Connection failed: " . mysqli_connect_error()));
    }

    //$tsql = "SELECT CurrentDisplay FROM CurrentDisplays WHERE UserId = 1";
    //$getResults = sqlsrv_query($conn, $tsql);
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
