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
    $message = "";
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //echo "<p>recieved post</p>";
        $success = false;
        
        if (isset($_POST['ImageSetting'])) {
            $selectedInput = htmlspecialchars($_POST['ImageSetting']);
            // Update the database with the selected input
            if($selectedInput == "Image"){
                mysqli_query($conn, "UPDATE userinfo SET ImageView = 1 WHERE UserId = '$userid';");
                $success = true;
            }elseif($selectedInput == "Text") {
                mysqli_query($conn, "UPDATE userinfo SET ImageView = 0 WHERE UserId = '$userid';");
                $success = true;
            }
            
        } 
        if (isset($_POST['Font'])) {
            $selectedFont = htmlspecialchars($_POST['Font']);
            
            $FontUpdateQuery = "UPDATE userinfo SET Font = '$selectedFont' WHERE UserId = '$userid';";
            // Update the database with the selected input
            if (mysqli_query($conn, $FontUpdateQuery)) {
                if (empty($selectedFont) && !isset($_POST['ImageSetting'])) {
                    $message = "<div class = 'alert alert-danger'>No input given. Try again. </div>";
                } else {
                    $success = true;
                    $message = "<div class='alert alert-success'>Settings updated successfully. Redirecting...</div>";
                }
            } else {
                $message = "<div class='alert alert-danger'>Error updating Settings. Try again.</div>";
            }
        }
    }

    header("refresh:6; url=/../FullAccessPages/currentdisplay.php");
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Message Updated</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
        <style>
            body {
                background-color: #000000;
                color: #ffffff;
                display: flex;
                align-items: center;
                justify-content: center;
                height: 100vh;
                text-align: center;
            }
            .card {
                background-color: #E87722;
                color: #000000;
                border-radius: 10px;
                padding: 30px;
                box-shadow: 0px 4px 8px rgba(255, 255, 255, 0.2);
            }
            .loader {
                border: 4px solid #ffffff;
                border-top: 4px solid #E87722;
                border-radius: 50%;
                width: 40px;
                height: 40px;
                animation: spin 1s linear infinite;
                margin: 20px auto;
            }
            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
        </style>
    </head>
    <body>
        <div class="card">
            <h2>Success!</h2>
            <?= $message; ?>
            <p>You will be redirected in:</p>
            <div id="countdown" style="font-size: 16px; font-weight: bold;"></div>
            <div class="loader"></div>
            <a href="/../FullAccessPages/CurrentDisplay.php" class="btn btn-dark mt-3">Go Now</a>
        </div>
        <script>
                var countdowntime = 6;
                function countdown() {
                        document.getElementById('countdown').innerHTML = countdowntime + " seconds";
                        if (countdowntime > 0) {
                            countdowntime--;
                        }
                }
                countdown();
                window.setInterval(function() {
                    countdown();
                }, 1000);
        </script>
    </body>
</html>