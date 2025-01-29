<?php
    //start the session
    //session_start();
    // starts displaying errors when things go wrong
    //ini_set('display_errors', 1);
    //error_reporting(E_ALL);
    //Verify the user is logged in
    require_once "VerifyLogin.php";
    //print("Debug: Login Verified \n");
    //should connect to database
    require_once "sql.php";
    //print("Debug: SQL connected \n");
?>
<!DOCTYPE html>
<html>

    <head>
        <title>Insert Page</title>
    </head>
    
    <body>
            <?php
                
                //setting up the userid for use later
                $userid = $_SESSION["UserId"];
                //print($_SESSION["UserId"]);
                //when it receives a post it should update the currentdisplay
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    if (isset($_POST['selected_input'])) {
                        $selectedInput = htmlspecialchars($_POST['selected_input']);
                        
                        // verify the current database input exists (it'll fail if it already exists which is good)
                        mysqli_query($conn, "INSERT INTO CurrentDisplays VALUES ($userid, ' ');");
                        // Update the database with the selected input
                        mysqli_query($conn, "UPDATE CurrentDisplays SET CurrentDisplay = '$selectedInput' WHERE UserId = '$userid';");
                        
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
