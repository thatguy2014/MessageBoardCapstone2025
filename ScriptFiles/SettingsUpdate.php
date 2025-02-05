<?php
    //start error reporting for testing
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    //verify user is logged in
    require_once "/home/site/wwwroot/ScriptFiles/VerifyLogin.php";

    //access sql server
    require_once "/home/site/wwwroot/ScriptFiles/sql.php";

    //pass in the radio button answer
    //send a sequel update statement to change the userinfo table ImageView to 1
    $userid = $_SESSION["UserId"];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['ImageSetting'])) {
            $selectedInput = htmlspecialchars($_POST['ImageSetting']);
            // Update the database with the selected input
            if($selectedInput == "Image"){
                mysqli_query($conn, "UPDATE userinfo SET ImageView = 1 WHERE UserId = '$userid';");
            }elseif($selectedInput == "Text") {
                mysqli_query($conn, "UPDATE userinfo SET ImageView = 0 WHERE UserId = '$userid';");
            }
            // Display success message
            echo "<p>Message updated successfully.</p>";
            header("location: currentdisplay.php");
        } else {
            echo "<p>Error: No message selected. <a href=CurrentDisplay.php>Go Back</a></p>";
        }
        echo "<p>Query sent,click <a href='CurrentDisplay.php'>here</a> to view current display</p>"
    }
?>