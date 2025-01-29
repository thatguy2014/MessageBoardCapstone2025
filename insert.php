<?php
    //start the session
    session_start();
    // starts displaying errors when things go wrong
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    //Verify the user is logged in
    require_once "VerifyLogin.php";
    print("Debug: Login Verified \n");
    //should connect to database
    require_once "sql.php";
    print("Debug: SQL connected \n");
?>
<!DOCTYPE html>
<html>

    <head>
        <title>Insert Page</title>
    </head>
    <header>
        <h1>Office Message Board</h1>
    </header>
    <nav>
        <ul>
            <li><a href="CurrentDisplay.php">Current Display</a></li>
            <li><a href="Presets.php">Presets</a></li>
            <li><a href="ChangeDisplay.php">Change Display</a></li>
            <li><a href="/">Logout</a></li>
        </ul>
    </nav>
    <body>
            <?php
                
                //setting up the userid for use later
                $userid = $_SESSION["UserId"];
                
                //when it receives a post it should update the currentdisplay
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    if (isset($_POST['selected_input'])) {
                        $selectedInput = htmlspecialchars($_POST['selected_input']);
                        
                        // Update the database with the selected input
                        mysqli_query($conn, "UPDATE CurrentDisplays SET CurrentDisplay = '$selectedInput' WHERE UserId = '$userid'");
                        
                        // Display success message
                        echo "<p>Message updated successfully.</p>";

                        header("location: currentdisplay.php");
                    } else {
                        echo "<p>Error: No message selected. <a href=CurrentDisplay.php>Go Back</a></p>";
                    }
                }
            ?>
            <p>query sent,click <a href="CurrentDisplay.php">here</a> to view current display</p>
    </body>

</html>
