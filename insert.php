<?php
require_once "VerifyLogin.php";
?>
<!DOCTYPE html>
<html>

    <head>
        <title>Insert Page page</title>
    </head>

    <body>
            <?php
                //should connect to database
                require_once "sql.php"
                //setting a constant userid for use later
                $userid = 1;
                
                //when it receives a post it should update the currentdisplay
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    if (isset($_POST['selected_input'])) {
                        $selectedInput = htmlspecialchars($_POST['selected_input']);
                        
                        // Update the database with the selected input
                        mysqli_query($conn, "UPDATE CurrentDisplays SET CurrentDisplay = '$selectedInput' WHERE UserId = '$userid'");
                        
                        // Display success message
                        echo "<p>Message updated successfully.</p>";
                    } else {
                        echo "<p>Error: No message selected.</p>";
                    }
                }
            ?>
            <p>query sent,click <a href="CurrentDisplay.php">here</a> to view current display</p>
    </body>

</html>
