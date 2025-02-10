<?php
    // Start error reporting for debugging
    // ini_set('display_errors', 1);
    // error_reporting(E_ALL);

    // Verify user is logged in
    require_once "/home/site/wwwroot/ScriptFiles/VerifyLogin.php";

    // Connect to the database
    require_once "/home/site/wwwroot/ScriptFiles/sql.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Message</title>
    <style>
        /* Ohio Northern University Theme */
        body {
            background-color: #141414; /* Dark background */
            color: white;
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 50px;
        }

        .container {
            background-color: #ff8200; /* ONU Orange */
            padding: 20px;
            border-radius: 10px;
            display: inline-block;
            box-shadow: 0px 0px 10px rgba(255, 130, 0, 0.8);
        }

        h1 {
            color: black;
        }

        p {
            font-size: 18px;
        }

        a {
            color: black;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>Message Update Status</h1>
        <?php
            // Get user ID
            $userid = $_SESSION["UserId"];
            $updateSuccess = false;

            // Process form submission
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (isset($_POST['selected_input'])) {
                    $selectedInput = htmlspecialchars($_POST['selected_input']);

                    // Ensure user entry exists in database, insert if not
                    $query = "INSERT INTO CurrentDisplays (UserId, CurrentDisplay) 
                              VALUES ('$userid', '$selectedInput') 
                              ON DUPLICATE KEY UPDATE CurrentDisplay = '$selectedInput';";

                    if (mysqli_query($conn, $query)) {
                        echo "<p>✅ Message updated successfully.</p>";
                        $updateSuccess = true;
                    } else {
                        echo "<p>❌ Error updating message: " . mysqli_error($conn) . "</p>";
                    }
                } else {
                    echo "<p>❌ Error: No message selected.</p>";
                }
            }
        ?>

        <p>Redirecting in 6 seconds...</p>
        <p>Click <a href="CurrentDisplay.php">here</a> if not redirected.</p>
    </div>

    <?php if ($updateSuccess): ?>
        <script>
            setTimeout(function() {
                window.location.href = "CurrentDisplay.php";
            }, 6000);
        </script>
    <?php endif; ?>

</body>
</html>
