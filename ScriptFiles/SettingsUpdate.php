<?php
    //start error reporting for testing
    //ini_set('display_errors', 1);
    //error_reporting(E_ALL);

    //verify user is logged in
    require_once "/home/site/wwwroot/ScriptFiles/VerifyLogin.php";

    //access sql server
    require_once "/home/site/wwwroot/ScriptFiles/sql.php";

    //pass in the radio button answer
    //send a sequel update statement to change the userinfo table ImageView to 1
    $userid = $_SESSION["UserId"];
    //echo "<p>debug running if </p><br>";
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //echo "<p>recieved post</p>";
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
            echo "<p>Query sent,click <a href='/../FullAccessPages/CurrentDisplay.php'>here</a> to view current display</p>";
            header("location: currentdisplay.php");
        } elseif(isset($_POST['Font'])) {
            $selectedFont = htmlspecialchars($_POST['Font']);
            $FontUpdateQuery = "UPDATE userinfo SET Font = '$selectedFont' WHERE UserId = $userid'";

            // Update the database with the selected input
            if (mysqli_query($conn, $FontUpdateQuery)) {
                $message = "<div class='alert alert-success'>Settings updated successfully. Redirecting...</div>";
            } else {
                $message = "<div class='alert alert-danger'>Error updating Settings. Try again.</div>";
            }

        }else {
            echo "<p>Error: No message selected. <a href=/../FullAccessPages/CurrentDisplay.php>Go Back</a></p>";
        }

    }

    // Delay redirect for 6 seconds
    header("refresh:6; url=currentdisplay.php");
?>